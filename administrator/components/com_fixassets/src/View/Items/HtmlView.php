<?php
declare(strict_types=1);

/**
 * @package     Joomla.Administrator
 * @subpackage  com_fixassets
 *
 * @copyright   Copyright (C) 2023 RIP Graphics. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace RipGraphics\Component\Fixassets\Administrator\View\Items;

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Router\Route;

/**
 * Items view class for Fixassets component
 *
 * @since  1.0.0
 */
class HtmlView extends BaseHtmlView
{
    /**
     * Display the view
     *
     * @param   string  $tpl  The name of the template file to parse
     *
     * @return  void
     *
     * @throws  \Exception
     */
    public function display($tpl = null): void
    {
        // Get the WebAsset Manager
        $wa = $this->document->getWebAssetManager();
        
        // Add web assets
        $wa->useStyle('com_fixassets.admin')
           ->useScript('com_fixassets.admin.items');

        // Add the toolbar
        $this->addToolbar();

        // Display the template
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar
     *
     * @return  void
     */
    protected function addToolbar(): void
    {
        $app = Factory::getApplication();

        ToolbarHelper::title(Text::_('COM_FIXASSETS_ITEMS'), 'items');

        // Add preferences button if user has access
        if ($app->getIdentity()->authorise('core.admin', 'com_fixassets')) 
        {
            ToolbarHelper::preferences('com_fixassets');
        }
    }
}