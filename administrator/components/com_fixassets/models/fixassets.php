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

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\Database\ParameterType;

/**
 * Fixassets Model for handling fix assets operations.
 *
 * @since  1.0.0
 */
class FixassetsModel extends BaseDatabaseModel
{
    /**
     * Method to get the fix assets data.
     *
     * @return  array  The fix assets data.
     *
     * @since   1.0.0
     */
    public function getFixAssetsData(): array
    {
        $db = $this->getDatabase();
        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__fixassets'));

        $db->setQuery($query);

        return $db->loadObjectList();
    }

    /**
     * Method to fix a specific asset by ID.
     *
     * @param   int  $id  The ID of the asset to fix.
     *
     * @return  boolean  True on success, false on failure.
     *
     * @since   1.0.0
     */
    public function fixAssetById(int $id): bool
    {
        $db = $this->getDatabase();
        $query = $db->getQuery(true)
            ->update($db->quoteName('#__fixassets'))
            ->set($db->quoteName('fixed') . ' = 1')
            ->where($db->quoteName('id') . ' = :id')
            ->bind(':id', $id, ParameterType::INTEGER);

        $db->setQuery($query);

        return (bool) $db->execute();
    }
}