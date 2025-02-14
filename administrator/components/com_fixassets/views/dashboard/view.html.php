<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\HTML\HTMLHelper;

class FixassetsViewDashboard extends HtmlView
{
    /**
     * The items to display
     *
     * @var  array
     */
    protected $items;

    /**
     * The pagination object
     *
     * @var  \Joomla\CMS\Pagination\Pagination
     */
    protected $pagination;

    /**
     * The model state
     *
     * @var  \Joomla\CMS\Object\CMSObject
     */
    protected $state;

    /**
     * Display the view
     *
     * @param   string  $tpl  The name of the template file to parse
     *
     * @return  void
     */
    public function display($tpl = null)
    {
        // Add the CSS file
        $wa = $this->document->getWebAssetManager();
        $wa->registerAndUseStyle('com_fixassets.dashboard', 'administrator/components/com_fixassets/assets/css/dashboard.css');
        
        // Add body class
        Factory::getApplication()->getDocument()->setHtml5(true);
        Factory::getApplication()->input->set('hidemainmenu', true);
        
        // Get data from the model
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');
        $this->state = $this->get('State');

        // Check for errors.
        if (count($errors = $this->get('Errors')))
        {
            throw new Exception(implode("\n", $errors), 500);
        }

        $this->addToolbar();
        
        return parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @return  void
     */
    protected function addToolbar()
    {
        ToolbarHelper::title(Text::_('COM_FIXASSETS_MANAGER'), 'puzzle');

        // Add toolbar buttons
        if (Factory::getUser()->authorise('core.admin', 'com_fixassets'))
        {
            ToolbarHelper::preferences('com_fixassets');
        }
    }
}