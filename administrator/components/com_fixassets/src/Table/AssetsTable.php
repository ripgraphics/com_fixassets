<?php
declare(strict_types=1);

/**
 * @package     Joomla.Administrator
 * @subpackage  com_fixassets
 *
 * @copyright   Copyright (C) 2023 RIP Graphics. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace RipGraphics\Component\Fixassets\Administrator\Table;

\defined('_JEXEC') or die;

use Joomla\CMS\Table\Asset;
use Joomla\Database\DatabaseDriver;
use Joomla\CMS\Factory;
use Joomla\Database\ParameterType;

/**
 * Assets table class.
 *
 * @since  1.0.0
 */
class AssetsTable extends Asset
{
    /**
     * Constructor
     *
     * @param   DatabaseDriver  $db  Database connector object
     *
     * @since   1.0.0
     */
    public function __construct(DatabaseDriver $db)
    {
        parent::__construct($db);
    }

    /**
     * Method to load an asset by its name
     *
     * @param   string  $name  The name of the asset
     *
     * @return  boolean  True on success
     *
     * @since   1.0.0
     */
    public function loadByName(string $name): bool
    {
        $db = $this->getDbo();
        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__assets'))
            ->where($db->quoteName('name') . ' = :name')
            ->bind(':name', $name, ParameterType::STRING);

        $db->setQuery($query);

        $result = $db->loadAssoc();

        if (empty($result)) {
            return false;
        }

        return $this->bind($result);
    }

    /**
     * Method to fix missing assets
     *
     * @param   string   $componentName  The component name
     * @param   integer  $parentId       The parent asset ID
     *
     * @return  boolean  True on success
     *
     * @since   1.0.0
     */
    public function fixMissingAssets(string $componentName, int $parentId = 1): bool
    {
        $db = $this->getDbo();
        $date = Factory::getDate()->toSql();

        // Set up basic asset properties
        $this->name = $componentName;
        $this->title = $componentName;
        $this->parent_id = $parentId;
        $this->rules = '{}';
        $this->level = 1;
        $this->setLocation($parentId, 'last-child');

        return $this->store();
    }
}