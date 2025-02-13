<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\CMS\Table\Table;
use Joomla\CMS\Language\Text;

class FixassetsModelItem extends AdminModel
{
    protected $text_prefix = 'COM_FIXASSETS';

    public function getTable($type = 'Item', $prefix = 'FixassetsTable', $config = array())
    {
        return Table::getInstance($type, $prefix, $config);
    }

    public function getForm($data = array(), $loadData = true)
    {
        $form = $this->loadForm(
            'com_fixassets.item',
            'item',
            array(
                'control' => 'jform',
                'load_data' => $loadData
            )
        );

        if (empty($form))
        {
            return false;
        }

        return $form;
    }

    protected function loadFormData()
    {
        $data = Factory::getApplication()->getUserState('com_fixassets.edit.item.data', array());

        if (empty($data))
        {
            $data = $this->getItem();
        }

        return $data;
    }

    protected function prepareTable($table)
    {
        $date = Factory::getDate();
        $user = Factory::getApplication()->getIdentity();

        if (empty($table->id))
        {
            $table->created = $date->toSql();
            $table->created_by = $user->id;
        }
        else
        {
            $table->modified = $date->toSql();
            $table->modified_by = $user->id;
        }
    }
}