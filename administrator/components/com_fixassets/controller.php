<?php
defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Factory;

class FixassetsController extends BaseController
{
    protected $default_view = 'fixassets';

    public function display($cachable = false, $urlparams = array())
    {
        $view = $this->input->get('view', 'fixassets');
        $layout = $this->input->get('layout', 'default');
        $id = $this->input->getInt('id');

        // For list views, ensure proper defaults are set
        if ($view === 'items' && $layout === 'default')
        {
            $this->input->set('view', 'items');
        }

        return parent::display($cachable, $urlparams);
    }
}