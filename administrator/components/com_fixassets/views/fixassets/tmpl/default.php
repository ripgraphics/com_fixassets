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
    <!-- Include Sidebar -->
    <?php include_once JPATH_COMPONENT_ADMINISTRATOR . '/views/dashboard/tmpl/sidebar.php'; ?>

    <!-- Content -->
    <div class="dashboard-content">
        <!-- Dashboard Header -->
        <div class="dashboard-header">
            <div class="header-left">
                <button id="sidebarToggle" class="btn btn-link">
                    <i class="fas fa-bars"></i>
                </button>
                <h1><?php echo Text::_('COM_FIXASSETS_TITLE'); ?></h1>
            </div>
            <div class="header-right">
                <a href="<?php echo Route::_('index.php'); ?>" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i>
                    <?php echo Text::_('COM_FIXASSETS_BACK_TO_ADMIN'); ?>
                </a>
            </div>
        </div>

        <div class="dashboard-body">
            <!-- Load the specific view content -->
            <?php echo $this->loadTemplate('items'); ?>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.querySelector('.sidebar');
        const dashboardContent = document.querySelector('.dashboard-content');

        function toggleSidebar() {
            sidebar.classList.toggle('sidebar-closed');
            dashboardContent.classList.toggle('content-expanded');
        }

        sidebar.classList.remove('sidebar-closed');
        dashboardContent.classList.add('content-expanded');

        sidebarToggle.addEventListener('click', function(e) {
            e.preventDefault();
            toggleSidebar();
        });
    });
</script>