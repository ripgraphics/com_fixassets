<?php
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

?>

<div class="sidebar">
    <div class="sidebar-header">
        <h3><?php echo Text::_('COM_FIXASSETS'); ?></h3>
    </div>
    <ul class="sidebar-menu">
        <li class="sidebar-item">
            <a href="<?php echo Route::_('index.php?option=com_fixassets&view=dashboard'); ?>" class="sidebar-link">
                <i class="fas fa-tachometer-alt"></i>
                <span><?php echo Text::_('COM_FIXASSETS_DASHBOARD'); ?></span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="<?php echo Route::_('index.php?option=com_fixassets&view=fixassets&filter[type]=articles'); ?>" class="sidebar-link">
                <i class="fas fa-newspaper"></i>
                <span><?php echo Text::_('COM_FIXASSETS_ARTICLES'); ?></span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="<?php echo Route::_('index.php?option=com_fixassets&view=fixassets&filter[type]=categories'); ?>" class="sidebar-link">
                <i class="fas fa-folder"></i>
                <span><?php echo Text::_('COM_FIXASSETS_CATEGORIES'); ?></span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="<?php echo Route::_('index.php?option=com_fixassets&view=fixassets&filter[type]=modules'); ?>" class="sidebar-link">
                <i class="fas fa-cube"></i>
                <span><?php echo Text::_('COM_FIXASSETS_MODULES'); ?></span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="<?php echo Route::_('index.php?option=com_fixassets&view=fixassets&filter[type]=plugins'); ?>" class="sidebar-link">
                <i class="fas fa-puzzle-piece"></i>
                <span><?php echo Text::_('COM_FIXASSETS_PLUGINS'); ?></span>
            </a>
        </li>
        <!-- Add more menu items here -->
    </ul>
</div>