<?php
// Load Joomla framework
define('_JEXEC', 1);
define('JPATH_BASE', realpath(__DIR__ . '/../../..')); // Path to Joomla root
require_once JPATH_BASE . '/includes/defines.php';
require_once JPATH_BASE . '/includes/framework.php';

// Initialize Joomla application
$app = JFactory::getApplication('site');