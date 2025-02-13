<?php
defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\FormController;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

class FixassetsControllerItem extends FormController
{
    protected $text_prefix = 'COM_FIXASSETS_ITEM';

    public function getModel($name = 'Item', $prefix = 'FixassetsModel', $config = array('ignore_request' => true))
    {
        return parent::getModel($name, $prefix, $config);
    }

    public function edit($key = null, $urlVar = 'id')
    {
        $type = $this->input->get('type', 'articles');
        $this->setRedirect(
            Route::_('index.php?option=com_fixassets&view=item&layout=edit&id=' . $this->input->getInt('id') . '&type=' . $type, false)
        );
        return true;
    }

    protected function postSaveHook($model, $validData = array())
    {
        return;
    }
}