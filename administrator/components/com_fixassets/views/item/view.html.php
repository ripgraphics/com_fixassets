<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Helper\ContentHelper;

class FixassetsViewItem extends HtmlView
{
    protected $form;
    protected $item;
    protected $state;
    protected $type;

    public function display($tpl = null)
    {
        $this->form = $this->get('Form');
        $this->item = $this->get('Item');
        $this->state = $this->get('State');
        $this->type = Factory::getApplication()->input->get('type', 'articles');

        // Check for errors.
        if (count($errors = $this->get('Errors')))
        {
            throw new Exception(implode("\n", $errors), 500);
        }

        $this->addToolbar();

        return parent::display($tpl);
    }

    protected function addToolbar()
    {
        Factory::getApplication()->input->set('hidemainmenu', true);

        $user = Factory::getApplication()->getIdentity();
        $isNew = ($this->item->id == 0);

        // Convert plural type to singular for the title
        $type = rtrim($this->type, 's');
        $type = strtoupper($type);

        ToolbarHelper::title(
            Text::_('COM_FIXASSETS_' . ($isNew ? 'ADD_' : 'EDIT_') . $type),
            'pencil-2 article-add'
        );

        ToolbarHelper::apply('item.apply');
        ToolbarHelper::save('item.save');

        if (empty($this->item->id))
        {
            ToolbarHelper::cancel('item.cancel');
        }
        else
        {
            ToolbarHelper::cancel('item.cancel', 'JTOOLBAR_CLOSE');
        }
    }
}