<?php
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Factory;

HTMLHelper::_('behavior.multiselect');
HTMLHelper::_('bootstrap.tooltip');

$user = Factory::getUser();
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));
$itemType = $this->state->get('item_type', 'articles');
?>

<div class="dashboard-container">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3><?php echo Text::_('COM_FIXASSETS_DASHBOARD'); ?></h3>
        </div>
        <ul class="sidebar-menu">
            <li class="sidebar-item">
                <a href="<?php echo Route::_('index.php?option=com_fixassets&view=dashboard&item_type=articles'); ?>" 
                   class="sidebar-link <?php echo $itemType === 'articles' ? 'active' : ''; ?>">
                    <i class="icon-file-alt"></i>
                    <span><?php echo Text::_('COM_FIXASSETS_ARTICLES'); ?></span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="<?php echo Route::_('index.php?option=com_fixassets&view=dashboard&item_type=categories'); ?>" 
                   class="sidebar-link <?php echo $itemType === 'categories' ? 'active' : ''; ?>">
                    <i class="icon-folder"></i>
                    <span><?php echo Text::_('COM_FIXASSETS_CATEGORIES'); ?></span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="<?php echo Route::_('index.php?option=com_fixassets&view=dashboard&item_type=modules'); ?>" 
                   class="sidebar-link <?php echo $itemType === 'modules' ? 'active' : ''; ?>">
                    <i class="icon-cube"></i>
                    <span><?php echo Text::_('COM_FIXASSETS_MODULES'); ?></span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="<?php echo Route::_('index.php?option=com_fixassets&view=dashboard&item_type=plugins'); ?>" 
                   class="sidebar-link <?php echo $itemType === 'plugins' ? 'active' : ''; ?>">
                    <i class="icon-plug"></i>
                    <span><?php echo Text::_('COM_FIXASSETS_PLUGINS'); ?></span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="dashboard-content">
        <form action="<?php echo Route::_('index.php?option=com_fixassets&view=dashboard'); ?>" method="post" name="adminForm" id="adminForm">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped" id="itemList">
                                <thead>
                                    <tr>
                                        <th width="1%" class="nowrap center">
                                            <?php echo HTMLHelper::_('grid.checkall'); ?>
                                        </th>
                                        <th>
                                            <?php echo HTMLHelper::_('grid.sort', 'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder); ?>
                                        </th>
                                        <th width="10%" class="nowrap">
                                            <?php echo HTMLHelper::_('grid.sort', 'JSTATUS', 'a.state', $listDirn, $listOrder); ?>
                                        </th>
                                        <th width="10%" class="nowrap">
                                            <?php echo HTMLHelper::_('grid.sort', 'JDATE_CREATED', 'a.created', $listDirn, $listOrder); ?>
                                        </th>
                                        <th width="1%" class="nowrap">
                                            <?php echo HTMLHelper::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($this->items)) : ?>
                                        <?php foreach ($this->items as $i => $item) : ?>
                                            <tr class="row<?php echo $i % 2; ?>">
                                                <td class="center">
                                                    <?php echo HTMLHelper::_('grid.id', $i, $item->id); ?>
                                                </td>
                                                <td>
                                                    <a href="<?php echo Route::_('index.php?option=com_fixassets&task=item.edit&id=' . $item->id . '&type=' . $itemType); ?>">
                                                        <?php echo $this->escape($item->title); ?>
                                                    </a>
                                                </td>
                                                <td class="center">
                                                    <?php echo HTMLHelper::_('jgrid.published', $item->state, $i, 'items.', true); ?>
                                                </td>
                                                <td class="small">
                                                    <?php echo HTMLHelper::_('date', $item->created, Text::_('DATE_FORMAT_LC4')); ?>
                                                </td>
                                                <td class="center">
                                                    <?php echo (int) $item->id; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>

                            <?php echo $this->pagination->getListFooter(); ?>
                        </div>
                    </div>
                </div>
            </div>

            <input type="hidden" name="task" value="">
            <input type="hidden" name="boxchecked" value="0">
            <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>">
            <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>">
            <?php echo HTMLHelper::_('form.token'); ?>
        </form>
    </div>
</div>