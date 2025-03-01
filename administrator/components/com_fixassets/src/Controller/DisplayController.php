<?php
declare(strict_types=1);

/**
 * @package     Joomla.Administrator
 * @subpackage  com_fixassets
 *
 * @copyright   Copyright (C) 2023 RIP Graphics. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace RipGraphics\Component\Fixassets\Administrator\Controller;

\defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

/**
 * Display Controller for Fixassets component
 *
 * @since  1.0.0
 */
class DisplayController extends BaseController
{
    /**
     * The default view.
     *
     * @var    string
     * @since  1.0.0
     */
    protected $default_view = 'dashboard';

    /**
     * Method to display a view.
     *
     * @param   boolean  $cachable   If true, the view output will be cached
     * @param   array    $urlparams  An array of safe URL parameters and their variable types
     *
     * @return  BaseController  This object to support chaining.
     *
     * @since   1.0.0
     * @throws  \Exception
     */
    public function display($cachable = false, $urlparams = []): BaseController
    {
        // Get the input
        $input = Factory::getApplication()->input;
        $view = $input->get('view', $this->default_view);
        
        // Set default layout if not specified
        if ($view === 'dashboard' && !$input->get('layout')) {
            $input->set('layout', 'default');
        }
        
        // Add safe url parameters for dashboard view
        if ($view === 'dashboard') {
            $urlparams = array_merge(
                $urlparams,
                [
                    'id' => 'INT',
                    'filter' => 'STRING',
                    'layout' => 'CMD',
                ]
            );
        }
        
        return parent::display($cachable, $urlparams);
    }
}