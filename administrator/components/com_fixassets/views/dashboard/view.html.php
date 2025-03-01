<?php
declare(strict_types=1);

/**
 * @package     Joomla.Administrator
 * @subpackage  com_fixassets
 *
 * @copyright   Copyright (C) 2023-2025 RIP Graphics. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace RipGraphics\Component\Fixassets\Administrator\View\Dashboard;

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Model\BaseModel;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Object\CMSObject;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\Toolbar\ToolbarHelper;

/**
 * Dashboard View for the Fixassets component
 * 
 * Displays a summary of fixed assets data and statistics.
 *
 * @since  1.0.0
 */
class HtmlView extends BaseHtmlView
{
    /**
     * The model state containing filter information
     *
     * @var    CMSObject
     * @since  1.0.0
     */
    protected $state;
    
    /**
     * Summary statistics for the dashboard
     *
     * @var    \stdClass
     * @since  1.0.0
     */
    protected $statistics;
    
    /**
     * Recent items to display in the dashboard
     *
     * @var    array
     * @since  1.0.0
     */
    protected $recentItems;

    /**
     * Display the dashboard view
     *
     * @param   string|null  $tpl  The name of the template file to parse
     *
     * @return  void
     *
     * @since   1.0.0
     * @throws  \Exception
     */
    public function display(?string $tpl = null): void
    {
        // Check access permissions
        $this->checkPermissions();
        
        // Get an instance of the model
        $this->setupModel();
        
        // Get data from the model
        $this->loadModelData();

        // Add the toolbar
        $this->addToolbar();

        // Display the template
        parent::display($tpl);
    }

    /**
     * Check if user has necessary permissions
     *
     * @return  void
     *
     * @since   1.0.0
     * @throws  \Exception
     */
    protected function checkPermissions(): void
    {
        $user = Factory::getApplication()->getIdentity();
        
        if (!$user->authorise('core.manage', 'com_fixassets')) {
            throw new \Exception(Text::_('JERROR_ALERTNOAUTHOR'), 403);
        }
    }
    
    /**
     * Set up the model
     *
     * @return  void
     *
     * @since   1.0.0
     * @throws  \RuntimeException
     */
    protected function setupModel(): void
    {
        $model = $this->getModel('Dashboard', 'Administrator');
        
        if (!$model instanceof BaseModel) {
            throw new \RuntimeException(Text::_('COM_FIXASSETS_ERROR_MODEL_NOT_FOUND'), 500);
        }
        
        $this->setModel($model, true);
    }
    
    /**
     * Load data from the model
     *
     * @return  void
     *
     * @since   1.0.0
     * @throws  \RuntimeException
     */
    protected function loadModelData(): void
    {
        $model = $this->getModel();
        
        // Get data from the model
        $this->state = $model->getState();
        $this->statistics = $model->getStatistics();
        $this->recentItems = $model->getRecentItems();

        // Check for errors
        if (count($errors = $model->getErrors())) {
            throw new \RuntimeException(implode("\n", $errors), 500);
        }
    }

    /**
     * Add the page title and toolbar
     *
     * @return  void
     *
     * @since   1.0.0
     */
    protected function addToolbar(): void
    {
        // Set the title
        ToolbarHelper::title(Text::_('COM_FIXASSETS_DASHBOARD_TITLE'), 'dashboard');
        
        // Add toolbar buttons based on permissions
        $user = Factory::getApplication()->getIdentity();
        $toolbar = Toolbar::getInstance('toolbar');
        
        // Show buttons based on permissions
        if ($user->authorise('core.create', 'com_fixassets')) {
            $toolbar->addNew('asset.add')
                ->icon('icon-plus')
                ->text('JTOOLBAR_NEW');
        }
        
        if ($user->authorise('core.edit.state', 'com_fixassets')) {
            $toolbar->standardButton('publish')
                ->text('JTOOLBAR_PUBLISH')
                ->task('assets.publish')
                ->icon('icon-publish')
                ->listCheck(true);
            
            $toolbar->standardButton('unpublish')
                ->text('JTOOLBAR_UNPUBLISH')
                ->task('assets.unpublish')
                ->icon('icon-unpublish')
                ->listCheck(true);
        }
        
        if ($user->authorise('core.admin', 'com_fixassets')) {
            $toolbar->preferences('com_fixassets');
        }
    }
}