<?php
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;

HTMLHelper::_('behavior.multiselect');
HTMLHelper::_('formbehavior.chosen', 'select');
?>

<form action="<?php echo Route::_('index.php?option=com_fixassets'); ?>" method="post" name="adminForm" id="adminForm">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo Text::_('COM_FIXASSETS_SELECT_TYPE'); ?></label>
                                <select name="filter[type]" class="form-control" onchange="this.form.submit()">
                                    <option value=""><?php echo Text::_('COM_FIXASSETS_SELECT_TYPE_OPTION'); ?></option>
                                    <option value="articles" <?php echo ($this->state->get('filter.type') == 'articles' ? 'selected' : ''); ?>>
                                        <?php echo Text::_('COM_FIXASSETS_ARTICLES'); ?>
                                    </option>
                                    <option value="categories" <?php echo ($this->state->get('filter.type') == 'categories' ? 'selected' : ''); ?>>
                                        <?php echo Text::_('COM_FIXASSETS_CATEGORIES'); ?>
                                    </option>
                                    <option value="modules" <?php echo ($this->state->get('filter.type') == 'modules' ? 'selected' : ''); ?>>
                                        <?php echo Text::_('COM_FIXASSETS_MODULES'); ?>
                                    </option>
                                    <option value="plugins" <?php echo ($this->state->get('filter.type') == 'plugins' ? 'selected' : ''); ?>>
                                        <?php echo Text::_('COM_FIXASSETS_PLUGINS'); ?>
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <?php if (!empty($this->items)) : ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="1%" class="center">
                                        <?php echo HTMLHelper::_('grid.checkall'); ?>
                                    </th>
                                    <th>
                                        <?php echo Text::_('JGLOBAL_TITLE'); ?>
                                    </th>
                                    <th width="1%" class="nowrap center">
                                        <?php echo Text::_('JGRID_HEADING_ID'); ?>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($this->items as $i => $item) : ?>
                                    <tr>
                                        <td class="center">
                                            <?php echo HTMLHelper::_('grid.id', $i, $item->id); ?>
                                        </td>
                                        <td>
                                            <?php echo $this->escape($item->title); ?>
                                        </td>
                                        <td class="center">
                                            <?php echo (int) $item->id; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <div class="alert alert-info">
                            <?php echo Text::_('COM_FIXASSETS_NO_ITEMS_FOUND'); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="task" value="">
    <input type="hidden" name="boxchecked" value="0">
    <?php echo HTMLHelper::_('form.token'); ?>
</form>