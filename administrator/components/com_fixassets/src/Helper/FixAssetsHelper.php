<?php
declare(strict_types=1);

/**
 * @package     Joomla.Administrator
 * @subpackage  com_fixassets
 */

namespace RipGraphics\Component\Fixassets\Administrator\Helper;

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

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
     * @return  array  List of items
     *
     * @since   1.0.0
     */
    public static function getItems(): array
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__fixassets_items'));

        $db->setQuery($query);

        return $db->loadObjectList();
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
            ->select('*')
            ->from($db->quoteName('#__fixassets_items'))
            ->where($db->quoteName('id') . ' = :id')
            ->bind(':id', $id, \Joomla\Database\ParameterType::INTEGER);

        $db->setQuery($query);

        return $db->loadObject();
    }
}