<?php
defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\AdminController;
use Joomla\CMS\Factory;

class FixassetsControllerItems extends AdminController
{
    protected $text_prefix = 'COM_FIXASSETS_ITEMS';

    public function getModel($name = 'Item', $prefix = 'FixassetsModel', $config = array('ignore_request' => true))
    {
        return parent::getModel($name, $prefix, $config);
    }
}