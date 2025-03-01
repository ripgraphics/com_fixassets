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

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Response\JsonResponse;

/**
 * Fixassets Controller
 *
 * @since  1.0.0
 */
class FixassetsController extends BaseController
{
    /**
     * Constructor.
     *
     * @param   array  $config  An optional associative array of configuration settings.
     *
     * @since   1.0.0
     */
    public function __construct($config = array())
    {
        parent::__construct($config);
    }

    /**
     * Recursively copies a directory.
     *
     * @param   string  $src   Source directory.
     * @param   string  $dst   Destination directory.
     *
     * @return  bool    True on success, false on failure.
     * 
     * @since   1.0.0
     */
    protected function copyDirectory(string $src, string $dst): bool
    {
        if (!is_dir($src)) {
            return false;
        }

        if (!is_dir($dst)) {
            mkdir($dst, 0755, true);
        }

        $dir = new \DirectoryIterator($src);

        foreach ($dir as $fileinfo) {
            if ($fileinfo->isDot()) {
                continue;
            }

            $srcPath = $fileinfo->getPathname();
            $dstPath = rtrim($dst, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $fileinfo->getFilename();

            if ($fileinfo->isDir()) {
                if (!$this->copyDirectory($srcPath, $dstPath)) {
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

    /**
     * Check and setup API folder
     *
     * @return  bool  True if successful, false otherwise
     * 
     * @since   1.0.0
     */
    public function checkApiFolder(): bool
    {
        // Get the component root path (2 levels up from the controller directory)
        $componentRoot = dirname(dirname(__DIR__));
        
        // API folder path
        $expectedApiPath = $componentRoot . DIRECTORY_SEPARATOR . 'api' . DIRECTORY_SEPARATOR . 'src';
        $sourceApiPath = $componentRoot . DIRECTORY_SEPARATOR . 'api' . DIRECTORY_SEPARATOR . 'src';
        
        if (!is_dir($expectedApiPath)) {
            if (is_dir($sourceApiPath)) {
                if (!$this->copyDirectory($sourceApiPath, $expectedApiPath)) {
                    Factory::getApplication()->getLogger()->error(
                        Text::_('Component Update: Failed to copy API files.'),
                        ['category' => 'com_fixassets']
                    );
                    return false;
                }
            } else {
                // Log the missing API directory for debugging purposes
                Factory::getApplication()->getLogger()->notice(
                    Text::_('COM_FIXASSETS_API_DIRECTORY_MISSING'),
                    ['category' => 'com_fixassets']
                );
            }
        }
        
        return true;
    }
    
    /**
     * Task to fix assets
     *
     * @return  void
     * 
     * @since   1.0.0
     */
    public function fixAssets()
    {
        // Check for request forgeries
        $this->checkToken();
        
        $app = Factory::getApplication();
        $model = $this->getModel('Fixassets', 'Administrator');
        
        try {
            $result = $model->fixAssets();
            
            if ($app->input->get('format') === 'json') {
                echo new JsonResponse($result);
                $app->close();
            } else {
                $this->setRedirect(
                    'index.php?option=com_fixassets&view=dashboard',
                    Text::_('COM_FIXASSETS_ASSETS_FIXED_SUCCESSFULLY')
                );
            }
        } catch (\Exception $e) {
            if ($app->input->get('format') === 'json') {
                echo new JsonResponse(['error' => $e->getMessage()], $e->getMessage(), true);
                $app->close();
            } else {
                $this->setRedirect(
                    'index.php?option=com_fixassets&view=dashboard',
                    $e->getMessage(),
                    'error'
                );
            }
        }
    }
}