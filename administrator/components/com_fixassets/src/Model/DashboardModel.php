<?php
declare(strict_types=1);

/**
 * @package     Joomla.Administrator
 * @subpackage  com_fixassets
 */
namespace RipGraphics\Component\Fixassets\Administrator\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\BaseDatabaseModel;

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
     */
    public function getAssets(): array
    {
        // Fetch the assets data from the database
        $db = $this->getDbo();
        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__fixassets_assets'))
            ->where($db->quoteName('items_needing_fixing') . ' > 0');
        $db->setQuery($query);

        return $db->loadObjectList();
    }
}