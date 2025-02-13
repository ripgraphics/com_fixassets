<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Helper\ContentHelper;
use Joomla\CMS\Toolbar\Toolbar;

class FixassetsViewItems extends HtmlView
{
    /**
     * An array of items
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
     * The application user object
     *
     * @var  \Joomla\CMS\User\User
     */
    protected $user;

    /**
     * Display the view
     *
     * @param   string  $tpl  The name of the template file to parse
     *
     * @return  void
     */
    public function display($tpl = null)
    {
        try {
            $this->items         = $this->get('Items');
            $this->pagination    = $this->get('Pagination');
            $this->state         = $this->get('State');
            $this->user          = Factory::getApplication()->getIdentity();
            $this->filterForm    = $this->get('FilterForm');
            $this->activeFilters = $this->get('ActiveFilters');

            // Check for errors.
            if (count($errors = $this->get('Errors'))) {
                throw new \Exception(implode("\n", $errors), 500);
            }

            // Load the component helper
            if (!class_exists('FixassetsHelper')) {
                JLoader::register('FixassetsHelper', JPATH_ADMINISTRATOR . '/components/com_fixassets/helpers/fixassets.php');
            }

            if (method_exists('FixassetsHelper', 'addSubmenu')) {
                FixassetsHelper::addSubmenu('items');
            }

            $this->addToolbar();

            return parent::display($tpl);
        } catch (\Exception $e) {
            Factory::getApplication()->enqueueMessage($e->getMessage(), 'error');
            return false;
        }
    }

    /**
     * Add the page title and toolbar.
     *
     * @return  void
     */
    protected function addToolbar()
    {
        // Get the toolbar object instance
        $toolbar = Toolbar::getInstance('toolbar');

        // Set the title
        ToolbarHelper::title(Text::_('COM_FIXASSETS_ITEMS_TITLE'), 'list');

        // Get the permissions
        $canDo = ContentHelper::getActions('com_fixassets');

        if ($canDo->get('core.create')) {
            $toolbar->addNew('item.add');
        }

        if ($canDo->get('core.edit.state')) {
            $dropdown = $toolbar->dropdownButton('status-group')
                ->text('JTOOLBAR_CHANGE_STATUS')
                ->toggleSplit(false)
                ->icon('icon-ellipsis-h')
                ->buttonClass('btn btn-action');

            $childBar = $dropdown->getChildToolbar();
            
            $childBar->publish('items.publish')->listCheck(true);
            $childBar->unpublish('items.unpublish')->listCheck(true);
            $childBar->archive('items.archive')->listCheck(true);
            $childBar->checkin('items.checkin')->listCheck(true);
        }

        if ($canDo->get('core.admin')) {
            $toolbar->preferences('com_fixassets');
        }

        if ($this->state->get('filter.published') == -2 && $canDo->get('core.delete')) {
            $toolbar->delete('items.delete')
                ->text('JTOOLBAR_EMPTY_TRASH')
                ->message('JGLOBAL_CONFIRM_DELETE')
                ->listCheck(true);
        }
    }
}