<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_fixassets
 *
 * @copyright   Copyright (C) 2023 RIP Graphics. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace RipGraphics\Component\Fixassets\Administrator\Table;

defined('_JEXEC') or die;

use Joomla\CMS\Application\ApplicationHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Table\Table;
use Joomla\Database\DatabaseDriver;
use Joomla\String\StringHelper;
use Joomla\CMS\Tag\TaggableTableInterface;
use Joomla\CMS\Tag\TaggableTableTrait;
use Joomla\Registry\Registry;

/**
 * Item Table class
 */
class ItemTable extends Table implements TaggableTableInterface
{
    use TaggableTableTrait;

    /**
     * Constructor
     *
     * @param   DatabaseDriver  $db  Database driver object.
     */
    public function __construct(DatabaseDriver $db)
    {
        parent::__construct('#__fixassets_items', 'id', $db);

        // Set the alias for the table
        $this->setColumnAlias('published', 'state');
    }

    /**
     * Method to bind an associative array or object to the Table instance.
     *
     * @param   array|object  $src     An associative array or object to bind to the Table instance.
     * @param   mixed         $ignore  An optional array or space separated list of properties to ignore while binding.
     *
     * @return  boolean  True on success.
     */
    public function bind($src, $ignore = array()): bool
    {
        if (isset($src['params']) && is_array($src['params']))
        {
            $registry = new Registry($src['params']);
            $src['params'] = (string) $registry;
        }

        return parent::bind($src, $ignore);
    }

    /**
     * Method to perform sanity checks on the instance properties to ensure they are safe to store in the database.
     *
     * @return  boolean  True if the instance is sane and able to be stored in the database.
     */
    public function check(): bool
    {
        // Check for valid name
        if (trim($this->title) == '')
        {
            $this->setError(Text::_('COM_FIXASSETS_ERROR_TITLE_REQUIRED'));
            return false;
        }

        // Check for existing alias
        $this->alias = ApplicationHelper::stringURLSafe($this->alias);

        if (trim($this->alias) == '')
        {
            $this->alias = ApplicationHelper::stringURLSafe($this->title);
        }

        return parent::check();
    }
}