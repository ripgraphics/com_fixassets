<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_fixassets
 *
 * @copyright   Copyright (C) 2023 RIP Graphics. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace RipGraphics\Component\Fixassets\Administrator\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\Factory;

/**
 * Dashboard model for Fixassets component
 */
class DashboardModel extends BaseDatabaseModel
{
    /**
     * Get total number of items
     *
     * @return  integer
     */
    public function getTotalItems()
    {
        $db = $this->getDatabase();
        $query = $db->getQuery(true)
            ->select('COUNT(*)')
            ->from($db->quoteName('#__fixassets_items'));
        
        $db->setQuery($query);
        
        try {
            $total = (int) $db->loadResult();
        } catch (\RuntimeException $e) {
            Factory::getApplication()->enqueueMessage($e->getMessage(), 'error');
            $total = 0;
        }
        
        return $total;
    }
}