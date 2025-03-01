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

use Joomla\CMS\Application\ApplicationHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Table\Table;
use Joomla\CMS\Language\Text;
use Joomla\Database\DatabaseDriver;
use Joomla\CMS\Tag\TaggableTableInterface;
use Joomla\CMS\Tag\TaggableTableTrait;
use Joomla\CMS\Versioning\VersionableTableInterface;

/**
 * Items table class.
 *
 * @since  1.0.0
 */
class ItemsTable extends Table implements TaggableTableInterface, VersionableTableInterface
{
    use TaggableTableTrait;

    /**
     * Constructor
     *
     * @param   DatabaseDriver  $db  Database connector object
     *
     * @since   1.0.0
     */
    public function __construct(DatabaseDriver $db)
    {
        parent::__construct('#__fixassets_items', 'id', $db);

        $this->setColumnAlias('published', 'state');
    }

    /**
     * Method to bind an associative array or object to the Table instance.
     *
     * @param   array|object  $array   An associative array or object to bind to the Table instance.
     * @param   array|string  $ignore  An optional array or space separated list of properties to ignore while binding.
     *
     * @return  boolean  True on success.
     *
     * @since   1.0.0
     * @throws  \InvalidArgumentException
     */
    public function bind($array, $ignore = ''): bool
    {
        if (isset($array['params']) && is_array($array['params'])) {
            $registry = new Registry($array['params']);
            $array['params'] = (string) $registry;
        }

        return parent::bind($array, $ignore);
    }

    /**
     * Method to perform sanity checks on the Table instance properties to ensure
     * they are safe to store in the database.
     *
     * @return  boolean  True if the instance is sane and able to be stored in the database.
     *
     * @since   1.0.0
     */
    public function check(): bool
    {
        try {
            parent::check();
        } catch (\Exception $e) {
            $this->setError($e->getMessage());
            return false;
        }

        // Check for valid title
        if (trim($this->title) === '') {
            $this->setError(Text::_('COM_FIXASSETS_ERROR_ITEM_TITLE_REQUIRED'));
            return false;
        }

        return true;
    }

    /**
     * Method to store a row
     *
     * @param   boolean  $updateNulls  True to update fields even if they are null.
     *
     * @return  boolean  True on success.
     *
     * @since   1.0.0
     */
    public function store($updateNulls = true): bool
    {
        $date = Factory::getDate()->toSql();
        $user = Factory::getApplication()->getIdentity();

        // Set created date if not set
        if (!(int) $this->created) {
            $this->created = $date;
        }

        if ($this->id) {
            // Existing item
            $this->modified = $date;
            $this->modified_by = $user->id;
        } else {
            // New item
            if (!(int) $this->created_by) {
                $this->created_by = $user->id;
            }
        }

        return parent::store($updateNulls);
    }

    /**
     * Get the type alias for the history table
     *
     * @return  string  The alias as described above
     *
     * @since   1.0.0
     */
    public function getTypeAlias(): string
    {
        return 'com_fixassets.item';
    }
}