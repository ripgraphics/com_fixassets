<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\BaseController;

// Access check
if (!Factory::getUser()->authorise('core.manage', 'com_fixassets')) {
    throw new InvalidArgumentException(Text::_('JERROR_ALERTNOAUTHOR'), 404);
}

// Register helper file
JLoader::register('FixassetsHelper', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/fixassets.php');

// Get an instance of the controller
$controller = BaseController::getInstance('Fixassets');

// Execute the task
$controller->execute(Factory::getApplication()->input->get('task', 'display'));

// Redirect if set by the controller
$controller->redirect();