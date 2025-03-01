<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_fixassets
 *
 * @copyright   Copyright (C) 2023 RIP Graphics. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\HTML\HTMLHelper;

// Get the application
$app = Factory::getApplication();
$input = $app->input;

// Force dashboard view when no specific view is requested
if (!$input->get('view')) {
    $input->set('view', 'dashboard');
    $input->set('layout', 'default');
}

// Access check
if (!$app->getIdentity()->authorise('core.manage', 'com_fixassets')) {
    throw new \Exception(Text::_('JERROR_ALERTNOAUTHOR'), 404);
}

// Get the document object
$wa = $app->getDocument()->getWebAssetManager();

// Load required assets - using correct Joomla 5.x asset identifiers
$wa->usePreset('bootstrap.framework'); // Use the correct preset name for Bootstrap in Joomla 5.x
$wa->useScript('core');

// Register and use component assets if they exist
if (file_exists(JPATH_ROOT . '/media/com_fixassets/js/admin.js')) {
    $wa->registerAndUseScript('com_fixassets.admin', 'com_fixassets/js/admin.js', [], ['defer' => true]);
}
if (file_exists(JPATH_ROOT . '/media/com_fixassets/css/admin.css')) {
    $wa->registerAndUseStyle('com_fixassets.admin', 'com_fixassets/css/admin.css');
}

try {
    // Initialize the controller
    $controllerClass = 'RipGraphics\\Component\\Fixassets\\Administrator\\Controller\\DisplayController';
    
    if (!class_exists($controllerClass)) {
        // Fall back to legacy controller naming as backup
        $controller = BaseController::getInstance('Fixassets');
    } else {
        $controller = new $controllerClass();
    }
    
    $controller->execute($input->get('task'));
    $controller->redirect();
} catch (\Exception $e) {
    $app->enqueueMessage($e->getMessage(), 'error');
    $app->redirect('index.php');
}