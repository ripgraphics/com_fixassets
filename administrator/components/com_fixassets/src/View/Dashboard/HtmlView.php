<?php
declare(strict_types=1);

/**
 * @package     Joomla.Administrator
 * @subpackage  com_fixassets
 */
namespace RipGraphics\Component\Fixassets\Administrator\View\Dashboard;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;

/**
 * HTML View class for the Fixassets Component Dashboard
 *
 * @since  1.0.0
 */
class HtmlView extends BaseHtmlView
{
    /**
     * Method to add the page title and toolbar.
     *
     * @return void
     */
    protected function addToolbar(): void
    {
        // Set the title for the dashboard view.
        ToolbarHelper::title(Text::_('COM_FIXASSETS_DASHBOARD_TITLE'), 'dashboard fa-fixassets');

        // Add preferences button if user has admin access
        if (Factory::getApplication()->getIdentity()->authorise('core.admin', 'com_fixassets')) {
            ToolbarHelper::preferences('com_fixassets');
        }
    }

    /**
     * Display the dashboard view.
     *
     * @param   string  $tpl  The name of the template file to parse
     *
     * @return  void
     *
     * @throws  \Exception
     */
    public function display($tpl = null): void
    {
        // Get the assets data from the model
        $this->assets = $this->get('Assets');

        // Check for errors
        if (count($errors = $this->get('Errors'))) {
            throw new \Exception(implode("\n", $errors), 500);
        }

        $this->addToolbar();
        parent::display($tpl);
    }
}