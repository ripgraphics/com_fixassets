<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\BaseController;

// Access check
if (!Factory::getUser()->authorise('core.manage', 'com_fixassets')) {
    throw new InvalidArgumentException(Text::_('JERROR_ALERTNOAUTHOR'), 404);
}

// Get an instance of the controller
$controller = BaseController::getInstance('FixAssets', ['base_path' => JPATH_COMPONENT_ADMINISTRATOR]);

// Force the dashboard view as default
$input = Factory::getApplication()->input;
if ($input->get('view') === null) {
    $input->set('view', 'dashboard');
}

// Execute the task
$controller->execute($input->get('task', 'display'));
$controller->redirect();