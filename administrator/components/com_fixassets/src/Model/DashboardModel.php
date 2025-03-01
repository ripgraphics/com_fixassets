<?php
declare(strict_types=1);

/**
 * @package     Joomla.Administrator
 * @subpackage  com_fixassets
 *
 * @copyright   Copyright (C) 2023 RIP Graphics. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
namespace RipGraphics\Component\Fixassets\Administrator\Model;

\defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\Factory;
use Joomla\Database\Exception\ExecutionFailureException;

/**
 * Model class for the Fixassets Component Dashboard
 *
 * @since  1.0.0
 */
class DashboardModel extends BaseDatabaseModel
{
    /**
     * Method to get the assets data
     *
     * @return  array  The assets data
     *
     * @since   1.0.0
     * @throws  \Exception on database error
     */
    public function getAssets(): array
    {
        try {
            // Fetch the assets data from the database
            $db = $this->getDbo();
            $query = $db->getQuery(true)
                ->select('*')
                ->from($db->quoteName('#__assets'))
                ->where($db->quoteName('name') . ' LIKE ' . $db->quote('%com_%'))
                ->order($db->quoteName('name') . ' ASC');
            
            $db->setQuery($query);
            
            return $db->loadObjectList() ?: [];
        } catch (ExecutionFailureException $e) {
            Factory::getApplication()->enqueueMessage($e->getMessage(), 'error');
            return [];
        }
    }
    
    /**
     * Method to get the count of items needing fixes
     *
     * @return  int  Number of items needing fixes
     *
     * @since   1.0.0
     */
    public function getItemsNeedingFixesCount(): int
    {
        try {
            $db = $this->getDbo();
            $query = $db->getQuery(true)
                ->select('COUNT(*)')
                ->from($db->quoteName('#__assets'))
                ->where($db->quoteName('parent_id') . ' = ' . $db->quote('0'))
                ->where($db->quoteName('name') . ' NOT LIKE ' . $db->quote('root.%'));
            
            $db->setQuery($query);
            
            return (int) $db->loadResult();
        } catch (ExecutionFailureException $e) {
            Factory::getApplication()->enqueueMessage($e->getMessage(), 'error');
            return 0;
        }
    }
}