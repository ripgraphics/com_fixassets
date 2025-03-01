<?php
declare(strict_types=1);

/**
 * @package     Joomla.Administrator
 * @subpackage  com_fixassets
 *
 * @copyright   Copyright (C) 2023 RIP Graphics. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace RipGraphics\Component\Fixassets\Administrator\Field;

\defined('_JEXEC') or die;

use Joomla\CMS\Form\FormField;
use Joomla\CMS\HTML\HTMLHelper;

/**
 * Custom field for handling sortable lists in Fixassets component
 *
 * @since  1.0.0
 */
class SortableField extends FormField
{
    /**
     * The form field type.
     *
     * @var    string
     * @since  1.0.0
     */
    protected $type = 'Sortable';

    /**
     * Method to get the field input markup.
     *
     * @return  string  The field input markup.
     *
     * @since   1.0.0
     */
    protected function getInput(): string
    {
        // Add sortable script
        HTMLHelper::_('script', 'com_fixassets/sortable.js', ['version' => 'auto', 'relative' => true]);

        return '<div class="sortable-list" id="' . $this->id . '">' . $this->value . '</div>';
    }
}