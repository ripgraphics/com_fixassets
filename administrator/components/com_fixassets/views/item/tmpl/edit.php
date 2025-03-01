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

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Language\Text;

HTMLHelper::_('behavior.formvalidator');
HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('formbehavior.chosen', 'select');

?>
<form action="<?php echo JRoute::_('index.php?option=com_fixassets&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="item-form" class="form-validate">
    <div class="form-horizontal">
        <?php echo LayoutHelper::render('joomla.edit.title_alias', $this); ?>
        <?php echo $this->form->renderField('description'); ?>
        <?php echo $this->form->renderField('state'); ?>
        <?php echo $this->form->renderField('created'); ?>
        <?php echo $this->form->renderField('created_by'); ?>
        <?php echo $this->form->renderField('modified'); ?>
        <?php echo $this->form->renderField('modified_by'); ?>
    </div>
    <input type="hidden" name="task" value="item.edit" />
    <?php echo HTMLHelper::_('form.token'); ?>
</form>