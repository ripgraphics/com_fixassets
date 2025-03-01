<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_fixassets
 *
 * @copyright   Copyright (C) 2023 RIP Graphics. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;

// Get the web asset manager
$wa = Factory::getApplication()->getDocument()->getWebAssetManager();

// Add component assets
$wa->useStyle('com_fixassets.dashboard-css')
   ->useScript('com_fixassets.dashboard-js');

// Get statistics from model
try {
    $model = $this->getModel('Dashboard', 'Administrator');
    $totalItems = $model ? $model->getTotalItems() : 0;
} catch (Exception $e) {
    $totalItems = 0;
    Factory::getApplication()->enqueueMessage($e->getMessage(), 'error');
}

// Add custom inline styles to hide Joomla admin panels
$wa->addInlineStyle('
    body.com_fixassets #subhead-container,
    body.com_fixassets #sidebar-wrapper,
    body.com_fixassets .header-nav {
        display: none !important;
    }
    body.com_fixassets #content {
        margin-left: 0 !important;
        width: 100% !important;
    }
    body.com_fixassets .wrapper {
        padding-left: 0 !important;
    }
');
?>

<div class="com-fixassets-dashboard">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div class="header-content">
            <h1><?php echo Text::_('COM_FIXASSETS_DASHBOARD_TITLE'); ?></h1>
        </div>
        <div class="header-actions">
            <a href="<?php echo Route::_('index.php'); ?>" class="btn btn-primary">
                <span class="icon-arrow-left-4" aria-hidden="true"></span>
                <?php echo Text::_('COM_FIXASSETS_BACK_TO_ADMIN'); ?>
            </a>
        </div>
    </div>

    <!-- Dashboard Content -->
    <div class="dashboard-content">
        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h2><?php echo Text::_('COM_FIXASSETS_DASHBOARD_QUICK_ACTIONS'); ?></h2>
            </div>
            <div class="card-body">
                <div class="quick-actions">
                    <a href="<?php echo Route::_('index.php?option=com_fixassets&view=items'); ?>" class="btn btn-primary">
                        <span class="icon-list" aria-hidden="true"></span>
                        <?php echo Text::_('COM_FIXASSETS_DASHBOARD_VIEW_ITEMS'); ?>
                    </a>
                    <a href="<?php echo Route::_('index.php?option=com_fixassets&view=item&layout=edit'); ?>" class="btn btn-primary">
                        <span class="icon-plus" aria-hidden="true"></span>
                        <?php echo Text::_('COM_FIXASSETS_DASHBOARD_ADD_ITEM'); ?>
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="card">
            <div class="card-header">
                <h2><?php echo Text::_('COM_FIXASSETS_DASHBOARD_STATISTICS'); ?></h2>
            </div>
            <div class="card-body">
                <div class="dashboard-stats">
                    <div class="stat-card">
                        <div class="stat-value"><?php echo $totalItems; ?></div>
                        <div class="stat-label"><?php echo Text::_('COM_FIXASSETS_DASHBOARD_TOTAL_ITEMS'); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>