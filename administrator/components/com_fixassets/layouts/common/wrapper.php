<?php
declare(strict_types=1);

defined('_JEXEC') or die;

use Joomla\CMS\Layout\LayoutHelper;

// Render the dashboard view so it appears on every page of the component.
echo LayoutHelper::render('dashboard.default');

// Render the main component view content passed as $displayData['content'].
?>
<div class="component-content">
    <?php
    // Expects that the calling code passes main view content as part of the display data.
    echo $displayData['content'] ?? '';
    ?>
</div>