<?php
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

HTMLHelper::_('behavior.formvalidator');
HTMLHelper::_('behavior.keepalive');

$type = rtrim($this->type, 's');
$type = strtoupper($type);
?>

<form action="<?php echo Route::_('index.php?option=com_fixassets&layout=edit&id=' . (int) $this->item->id); ?>"
    method="post" name="adminForm" id="adminForm" class="form-validate">
    <div class="row-fluid">
        <div class="span10 form-horizontal">
            <fieldset class="adminform">
                <?php 
                // Override the title field description with type-specific text
                $this->form->setFieldAttribute('title', 'description', 'COM_FIXASSETS_FIELD_' . $type . '_TITLE_DESC');
                echo $this->form->renderField('title');
                ?>
                <?php echo $this->form->renderField('state'); ?>
                <?php echo $this->form->renderField('id'); ?>
            </fieldset>
        </div>
    </div>
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="type" value="<?php echo $this->type; ?>" />
    <?php echo HTMLHelper::_('form.token'); ?>
</form>