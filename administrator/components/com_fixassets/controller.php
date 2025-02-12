<?php
defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\BaseController;

class FixassetsController extends BaseController
{
    protected $default_view = 'fixassets';

    public function display($cachable = false, $urlparams = array())
    {
        return parent::display($cachable, $urlparams);
    }
}