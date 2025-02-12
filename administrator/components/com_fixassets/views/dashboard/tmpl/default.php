<?php
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\HTML\HTMLHelper;

// Load required CSS and JavaScript
HTMLHelper::_('bootstrap.framework');
HTMLHelper::_('stylesheet', 'administrator/components/com_fixassets/assets/css/dashboard.css');
HTMLHelper::_('script', 'administrator/components/com_fixassets/assets/js/dashboard.js');
?>

<div class="dashboard-container">
    <!-- Header -->
    <div class="dashboard-header">
        <div class="header-content">
            <button id="sidebarToggle" class="btn btn-link">
                <i class="fas fa-bars"></i>
            </button>
            <h1><?php echo Text::_('COM_FIXASSETS_DASHBOARD_TITLE'); ?></h1>
        </div>
    </div>

    <div class="dashboard-body">
        <div class="row">
            <!-- Articles Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="h5 mb-0 font-weight-bold text-primary">
                                    <?php echo Text::_('COM_FIXASSETS_ARTICLES'); ?>
                                </div>
                                <div class="text-xs font-weight-bold text-uppercase mb-1">
                                    <?php echo Text::sprintf('COM_FIXASSETS_MISSING_ASSETS_COUNT', $this->missingAssetsCount['articles']); ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-newspaper fa-2x text-gray-300"></i>
                            </div>
                        </div>
                        <a href="<?php echo Route::_('index.php?option=com_fixassets&view=fixassets&filter[type]=articles'); ?>" class="stretched-link"></a>
                    </div>
                </div>
            </div>

            <!-- Categories Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="h5 mb-0 font-weight-bold text-success">
                                    <?php echo Text::_('COM_FIXASSETS_CATEGORIES'); ?>
                                </div>
                                <div class="text-xs font-weight-bold text-uppercase mb-1">
                                    <?php echo Text::sprintf('COM_FIXASSETS_MISSING_ASSETS_COUNT', $this->missingAssetsCount['categories']); ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-folder fa-2x text-gray-300"></i>
                            </div>
                        </div>
                        <a href="<?php echo Route::_('index.php?option=com_fixassets&view=fixassets&filter[type]=categories'); ?>" class="stretched-link"></a>
                    </div>
                </div>
            </div>

            <!-- Modules Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="h5 mb-0 font-weight-bold text-info">
                                    <?php echo Text::_('COM_FIXASSETS_MODULES'); ?>
                                </div>
                                <div class="text-xs font-weight-bold text-uppercase mb-1">
                                    <?php echo Text::sprintf('COM_FIXASSETS_MISSING_ASSETS_COUNT', $this->missingAssetsCount['modules']); ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-cube fa-2x text-gray-300"></i>
                            </div>
                        </div>
                        <a href="<?php echo Route::_('index.php?option=com_fixassets&view=fixassets&filter[type]=modules'); ?>" class="stretched-link"></a>
                    </div>
                </div>
            </div>

            <!-- Plugins Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="h5 mb-0 font-weight-bold text-warning">
                                    <?php echo Text::_('COM_FIXASSETS_PLUGINS'); ?>
                                </div>
                                <div class="text-xs font-weight-bold text-uppercase mb-1">
                                    <?php echo Text::sprintf('COM_FIXASSETS_MISSING_ASSETS_COUNT', $this->missingAssetsCount['plugins']); ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-puzzle-piece fa-2x text-gray-300"></i>
                            </div>
                        </div>
                        <a href="<?php echo Route::_('index.php?option=com_fixassets&view=fixassets&filter[type]=plugins'); ?>" class="stretched-link"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>