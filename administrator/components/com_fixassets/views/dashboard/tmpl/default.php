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
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h2><?php echo Text::_('COM_FIXASSETS_DASHBOARD_WELCOME'); ?></h2>
                    <p><?php echo Text::_('COM_FIXASSETS_DASHBOARD_INTRO'); ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3><?php echo Text::_('COM_FIXASSETS_DASHBOARD_SUMMARY'); ?></h3>
                </div>
                <div class="card-body">
                    <p><?php echo Text::_('COM_FIXASSETS_DASHBOARD_SUMMARY_DESC'); ?></p>
                    <!-- Add summary content here -->
                    <ul>
                        <li><?php echo Text::_('COM_FIXASSETS_DASHBOARD_TOTAL_ASSETS'); ?>: 100</li>
                        <li><?php echo Text::_('COM_FIXASSETS_DASHBOARD_TOTAL_CATEGORIES'); ?>: 10</li>
                        <li><?php echo Text::_('COM_FIXASSETS_DASHBOARD_TOTAL_USERS'); ?>: 50</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3><?php echo Text::_('COM_FIXASSETS_DASHBOARD_RECENT_ACTIVITY'); ?></h3>
                </div>
                <div class="card-body">
                    <p><?php echo Text::_('COM_FIXASSETS_DASHBOARD_RECENT_ACTIVITY_DESC'); ?></p>
                    <!-- Add recent activity content here -->
                    <ul>
                        <li><?php echo Text::_('COM_FIXASSETS_DASHBOARD_RECENT_ACTIVITY_1'); ?></li>
                        <li><?php echo Text::_('COM_FIXASSETS_DASHBOARD_RECENT_ACTIVITY_2'); ?></li>
                        <li><?php echo Text::_('COM_FIXASSETS_DASHBOARD_RECENT_ACTIVITY_3'); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <?php if (!empty($this->assets)) : ?>
            <?php foreach ($this->assets as $asset): ?>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3><?php echo $asset->title; ?></h3>
                        </div>
                        <div class="card-body">
                            <p><?php echo Text::_('COM_FIXASSETS_DASHBOARD_ITEMS_NEED_FIXING'); ?>: <?php echo $asset->items_needing_fixing; ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="col-md-12">
                <div class="alert alert-info">
                    <?php echo Text::_('COM_FIXASSETS_DASHBOARD_NO_ITEMS'); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>