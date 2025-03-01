<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\HTML\HTMLHelper;

class FixassetsViewItems extends BaseHtmlView
{
    protected $items;
    protected $pagination;
    protected $state;

    public function display($tpl = null)
    {
        $this->items      = $this->get('Items');
        $this->pagination = $this->get('Pagination');
        $this->state      = $this->get('State');

        if (count($errors = $this->get('Errors')))
        {
            throw new Exception(implode("\n", $errors), 500);
        }

        // Load required JavaScript and CSS
        HTMLHelper::_('behavior.core');
        HTMLHelper::_('bootstrap.framework');

        // Add the toolbar
        $this->addToolbar();

        // Display the template
        parent::display($tpl);
    }

    protected function addToolbar()
    {
        ToolbarHelper::title(Text::_('COM_FIXASSETS_ITEMS_TITLE'), 'items');

        if (Factory::getApplication()->getIdentity()->authorise('core.admin', 'com_fixassets'))
        {
            ToolbarHelper::preferences('com_fixassets');
        }
    }
}