<?php
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
?>

<form action="<?php echo Route::_('index.php?option=com_fixassets&view=fixassets'); ?>" method="post" name="adminForm" id="adminForm">
    <div class="row">
        <div class="col-md-12">
            <!-- Your existing items list/grid content here -->
            <?php if (!empty($this->items)) : ?>
                <table class="table table-striped">
                    <!-- Your table content -->
                </table>
            <?php else : ?>
                <div class="alert alert-info">
                    <?php echo Text::_('COM_FIXASSETS_NO_ITEMS_FOUND'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</form>