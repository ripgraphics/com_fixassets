<?php
declare(strict_types=1);

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
use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\HTML\HTMLHelper;

/**
 * Recursively copies a directory.
 *
 * @param   string  $src   Source directory.
 * @param   string  $dst   Destination directory.
 *
 * @return  bool    True on success, false on failure.
 */
function copyDirectory(string $src, string $dst): bool
{
    if (!is_dir($src)) {
        return false;
    }

    if (!is_dir($dst)) {
        mkdir($dst, 0755, true);
    }

    $dir = new DirectoryIterator($src);

    foreach ($dir as $fileinfo) {
        if ($fileinfo->isDot()) {
            continue;
        }

        $srcPath = $fileinfo->getPathname();
        $dstPath = rtrim($dst, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $fileinfo->getFilename();

        if ($fileinfo->isDir()) {
            if (!copyDirectory($srcPath, $dstPath)) {
                return false;
            }
        } else {
            if (!copy($srcPath, $dstPath)) {
                return false;
            }
        }
    }

    return true;
}

// Access check
if (!Factory::getApplication()->getIdentity()->authorise('core.manage', 'com_fixassets')) 
{
    throw new \Exception(Text::_('JERROR_ALERTNOAUTHOR'), 404);
}

// Check API folder existence (for component updates)
// Assuming the expected API folder is located at: 
// c:\Users\cshan\OneDrive\Desktop\Projects\com_fixassets\administrator\components\com_fixassets\api\src
$expectedApiPath = __DIR__ . DIRECTORY_SEPARATOR . 'api' . DIRECTORY_SEPARATOR . 'src';
if (!is_dir($expectedApiPath))
{
    // Define the source path where the API files should be available during installation.
    // Adjust this path depending on your installation package structure.
    $sourceApiPath = __DIR__ . DIRECTORY_SEPARATOR . 'api' . DIRECTORY_SEPARATOR . 'src';
    if (is_dir($sourceApiPath))
    {
        if (!copyDirectory($sourceApiPath, $expectedApiPath))
        {
            throw new \Exception(Text::_('Component Update: Failed to copy API files.'), 500);
        }
    }
    else
    {
        // Remove the exception to prevent installation failure
        // Log the missing API directory for debugging purposes
        Factory::getApplication()->getLogger()->addEntry(array(
            'status'  => Text::_('COM_FIXASSETS_API_DIRECTORY_MISSING'),
            'group'   => 'com_fixassets',
            'code'    => 404,
            'priority' => 3,
        ));
    }
}

// Get the application
/** @var CMSApplication $app */
$app = Factory::getApplication();

// Register WebAsset
$wa = $app->getDocument()->getWebAssetManager();
$wa->usePreset('com_fixassets.admin')
   ->useScript('com_fixassets.admin');

// Get an instance of the controller
$controller = BaseController::getInstance('Fixassets');

// Execute the task
$controller->execute($app->input->get('task'));

// Set default view if none specified
if (empty($app->input->get('view'))) 
{
    $app->input->set('view', 'dashboard');
}

// Redirect if set by the controller
$controller->redirect();