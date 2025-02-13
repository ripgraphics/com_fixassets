<?php
defined('_JEXEC') or die;

use Joomla\CMS\Table\Table;
use Joomla\Database\DatabaseDriver;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Tag\TaggableTableInterface;
use Joomla\CMS\Tag\TaggableTableTrait;

class FixassetsTableItem extends Table implements TaggableTableInterface
{
    use TaggableTableTrait;

    public function __construct(DatabaseDriver $db)
    {
        parent::__construct('#__content', 'id', $db);
    }

    public function getTypeAlias()
    {
        return 'com_fixassets.item';
    }

    public function check()
    {
        if (trim($this->title) == '')
        {
            $this->setError(Text::_('COM_FIXASSETS_ERROR_EMPTY_TITLE'));
            return false;
        }

        return true;
    }

    public function bind($array, $ignore = array())
    {
        return parent::bind($array, $ignore);
    }

    public function store($updateNulls = false)
    {
        return parent::store($updateNulls);
    }

    public function delete($pk = null)
    {
        return parent::delete($pk);
    }
}