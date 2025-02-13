<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\Helpers\Sidebar;

class FixassetsHelper
{
    public static function addSubmenu($vName)
    {
        Sidebar::addEntry(
            Text::_('COM_FIXASSETS_MENU_DASHBOARD'),
            'index.php?option=com_fixassets&view=fixassets',
            $vName === 'fixassets'
        );

        Sidebar::addEntry(
            Text::_('COM_FIXASSETS_MENU_ITEMS'),
            'index.php?option=com_fixassets&view=items',
            $vName === 'items'
        );
    }

    public static function getActions($categoryId = 0)
    {
        $user = Factory::getUser();
        $result = new \Joomla\CMS\Object\CMSObject;

        $assetName = 'com_fixassets';

        if ($categoryId)
        {
            $assetName .= '.category.' . (int) $categoryId;
        }

        $actions = array(
            'core.admin', 'core.manage', 'core.create', 'core.edit',
            'core.edit.own', 'core.edit.state', 'core.delete'
        );

        foreach ($actions as $action)
        {
            $result->set($action, $user->authorise($action, $assetName));
        }

        return $result;
    }
}