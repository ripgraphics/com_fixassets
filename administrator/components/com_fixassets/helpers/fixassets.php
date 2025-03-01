<?php
declare(strict_types=1);

/**
 * @package     Joomla.Administrator
 * @subpackage  com_fixassets
 *
 * @copyright   Copyright (C) 2023-2025 RIP Graphics. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace RipGraphics\Component\Fixassets\Administrator\Helper;

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\Database\ParameterType;

/**
 * Helper class for Fixassets component
 *
 * @since  1.0.0
 */
class FixAssetsHelper
{
    /**
     * Method to get a list of items
     *
     * @param   array  $options  Options for filtering results
     *
     * @return  array  List of items
     *
     * @since   1.0.0
     */
    public static function getItems(array $options = []): array
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        
        // Default options
        $defaults = [
            'limit' => 0,
            'offset' => 0,
            'state' => 1,
            'ordering' => 'id',
            'direction' => 'ASC'
        ];
        
        $options = array_merge($defaults, $options);
        
        $query->select([
                'i.id', 'i.title', 'i.description', 'i.state', 'i.created', 'i.created_by'
            ])
            ->from($db->quoteName('#__fixassets_items', 'i'));
            
        // Filter by state
        if ($options['state'] !== null) {
            $query->where($db->quoteName('i.state') . ' = :state')
                ->bind(':state', $options['state'], ParameterType::INTEGER);
        }
        
        // Set ordering
        $allowedOrdering = ['id', 'title', 'created', 'state'];
        $ordering = in_array($options['ordering'], $allowedOrdering) ? $options['ordering'] : 'id';
        $direction = strtoupper($options['direction']) === 'ASC' ? 'ASC' : 'DESC';
        
        $query->order($db->quoteName('i.' . $ordering) . ' ' . $direction);
        
        // Set limits
        if ($options['limit'] > 0) {
            $query->setLimit($options['limit'], $options['offset']);
        }

        try {
            $db->setQuery($query);
            return $db->loadObjectList();
        } catch (\RuntimeException $e) {
            Factory::getApplication()->enqueueMessage(Text::_('COM_FIXASSETS_DATABASE_ERROR') . ': ' . $e->getMessage(), 'error');
            return [];
        }
    }

    /**
     * Method to get a specific item by ID
     *
     * @param   int  $id  The ID of the item
     *
     * @return  object|null  The item object or null if not found
     *
     * @since   1.0.0
     */
    public static function getItem(int $id): ?object
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true)
            ->select([
                'i.id', 'i.title', 'i.description', 'i.state', 'i.created', 'i.created_by'
            ])
            ->from($db->quoteName('#__fixassets_items', 'i'))
            ->where($db->quoteName('i.id') . ' = :id')
            ->bind(':id', $id, ParameterType::INTEGER);

        try {
            $db->setQuery($query);
            return $db->loadObject();
        } catch (\RuntimeException $e) {
            Factory::getApplication()->enqueueMessage(Text::_('COM_FIXASSETS_DATABASE_ERROR') . ': ' . $e->getMessage(), 'error');
            return null;
        }
    }

    /**
     * Get JReviews listings with related data
     *
     * @param   array  $options  Array of options to filter listings
     *
     * @return  array  List of JReviews content items
     *
     * @since   1.0.0
     */
    public static function getJreviewsListings(array $options = []): array
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        
        // Set default options
        $defaults = [
            'limit' => 10,
            'offset' => 0,
            'directoryId' => null,
            'categoryId' => null,
            'featured' => null,
            'ordering' => 'a.created',
            'direction' => 'DESC',
        ];
        
        $options = array_merge($defaults, $options);
        
        // Get current user for access control
        $user = Factory::getApplication()->getIdentity();
        $groups = $user->getAuthorisedViewLevels();
        
        // Select fields from all needed tables
        $query->select([
            'a.id', 'a.title', 'a.alias', 'a.introtext', 'a.created', 'a.created_by',
            'a.catid', 'a.state', 'a.hits', 'a.featured AS content_featured',
            'c.title AS category_title', 'c.alias AS category_alias',
            'jr.featured AS jr_featured', 'jr.email', 
            'jr.jr_website', 'jr.jr_address', 'jr.jr_email', 'jr.jr_city',
            'jr.jr_telephonenum', 'jr.jr_postalcodenum'
        ])->from($db->quoteName('#__content', 'a'))
            ->join('INNER', $db->quoteName('#__categories', 'c') . ' ON c.id = a.catid')
            ->join('INNER', $db->quoteName('#__jreviews_content', 'jr') . ' ON jr.contentid = a.id')
            ->where($db->quoteName('c.extension') . ' = ' . $db->quote('com_content'))
            ->where($db->quoteName('a.access') . ' IN (' . implode(',', $groups) . ')')
            ->where($db->quoteName('c.access') . ' IN (' . implode(',', $groups) . ')');
        
        // Add filter by directory if specified
        if ($options['directoryId'] !== null) {
            $query->join('INNER', $db->quoteName('#__jreviews_categories', 'jrc') . ' ON jrc.id = a.catid')
                  ->where($db->quoteName('jrc.dirid') . ' = :directoryId')
                  ->bind(':directoryId', $options['directoryId'], ParameterType::INTEGER);
        }
        
        // Add category filter if specified
        if ($options['categoryId'] !== null) {
            $query->where($db->quoteName('a.catid') . ' = :categoryId')
                  ->bind(':categoryId', $options['categoryId'], ParameterType::INTEGER);
        }
        
        // Add published state filter
        $query->where($db->quoteName('a.state') . ' = 1');
        
        // Add featured filter if specified
        if ($options['featured'] !== null) {
            $query->where($db->quoteName('a.featured') . ' = :featured')
                  ->bind(':featured', $options['featured'], ParameterType::INTEGER);
        }
        
        // Set ordering with security validation
        $allowedOrdering = ['a.created', 'a.title', 'a.hits', 'a.featured', 'a.id'];
        $ordering = in_array($options['ordering'], $allowedOrdering) ? $options['ordering'] : 'a.created';
        $direction = strtoupper($options['direction']) === 'ASC' ? 'ASC' : 'DESC';
        
        $query->order($db->quoteName($ordering) . ' ' . $direction);
        
        // Set limits
        $query->setLimit($options['limit'], $options['offset']);
        
        try {
            $db->setQuery($query);
            return $db->loadObjectList();
        } catch (\RuntimeException $e) {
            Factory::getApplication()->enqueueMessage(Text::_('COM_FIXASSETS_DATABASE_ERROR') . ': ' . $e->getMessage(), 'error');
            return [];
        }
    }

    /**
     * Get JReviews directories
     *
     * @return  array  List of directories
     *
     * @since   1.0.0
     */
    public static function getDirectories(): array
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true)
            ->select(['id', 'slug', 'title', 'image', 'tmpl_suffix', 'description'])
            ->from($db->quoteName('#__jreviews_directories'))
            ->order($db->quoteName('title') . ' ASC');
        
        try {
            $db->setQuery($query);
            return $db->loadObjectList();
        } catch (\RuntimeException $e) {
            Factory::getApplication()->enqueueMessage(Text::_('COM_FIXASSETS_DATABASE_ERROR') . ': ' . $e->getMessage(), 'error');
            return [];
        }
    }

    /**
     * Get JReviews categories by directory
     *
     * @param   int  $directoryId  Directory ID
     *
     * @return  array  List of categories
     *
     * @since   1.0.0
     */
    public static function getCategoriesByDirectory(int $directoryId): array
    {
        $db = Factory::getDbo();
        $user = Factory::getApplication()->getIdentity();
        $groups = $user->getAuthorisedViewLevels();
        
        $query = $db->getQuery(true)
            ->select(['c.id', 'c.title', 'c.alias', 'c.description', 'c.published', 'c.level', 'c.path'])
            ->from($db->quoteName('#__categories', 'c'))
            ->join('INNER', 
                $db->quoteName('#__jreviews_categories', 'jrc') . 
                ' ON ' . $db->quoteName('jrc.id') . ' = ' . $db->quoteName('c.id')
            )
            ->where([
                $db->quoteName('jrc.dirid') . ' = :directoryId',
                $db->quoteName('c.published') . ' = 1',
                $db->quoteName('c.extension') . ' = ' . $db->quote('com_content'),
                $db->quoteName('c.access') . ' IN (' . implode(',', $groups) . ')'
            ])
            ->bind(':directoryId', $directoryId, ParameterType::INTEGER)
            ->order($db->quoteName('c.lft') . ' ASC');
        
        try {
            $db->setQuery($query);
            return $db->loadObjectList();
        } catch (\RuntimeException $e) {
            Factory::getApplication()->enqueueMessage(Text::_('COM_FIXASSETS_DATABASE_ERROR') . ': ' . $e->getMessage(), 'error');
            return [];
        }
    }
}