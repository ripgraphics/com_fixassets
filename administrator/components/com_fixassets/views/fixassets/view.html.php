<?php
defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\HTML\HTMLHelper;

class FixassetsViewFixassets extends HtmlView
{
    protected $items;
    protected $state;
    
    public function display($tpl = null)
    {
        $this->items = $this->get('Items');
        $this->state = $this->get('State');

        // Add toolbar buttons
        $this->addToolbar();

        // Display the template
        parent::display($tpl);
    }

    protected function addToolbar()
    {
        ToolbarHelper::title(Text::_('COM_FIXASSETS_MANAGER'), 'puzzle');
        ToolbarHelper::custom('fixassets.fixselected', 'refresh', '', 'COM_FIXASSETS_BUTTON_FIX_SELECTED', false);
        ToolbarHelper::custom('fixassets.fixall', 'refresh', '', 'COM_FIXASSETS_BUTTON_FIX_ALL', false);
    }
}