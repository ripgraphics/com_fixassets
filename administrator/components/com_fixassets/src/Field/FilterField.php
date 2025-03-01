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
use Joomla\CMS\Language\Text;

/**
 * Custom field for handling filter selection in Fixassets component
 *
 * @since  1.0.0
 */
class FilterField extends FormField
{
    /**
     * The form field type.
     *
     * @var    string
     * @since  1.0.0
     */
    protected $type = 'Filter';

    /**
     * Method to get the field input markup.
     *
     * @return  string  The field input markup.
     *
     * @since   1.0.0
     */
    protected function getInput(): string
    {
        $options = [
            HTMLHelper::_('select.option', 'all', Text::_('COM_FIXASSETS_FILTER_ALL')),
            HTMLHelper::_('select.option', 'published', Text::_('COM_FIXASSETS_FILTER_PUBLISHED')),
            HTMLHelper::_('select.option', 'unpublished', Text::_('COM_FIXASSETS_FILTER_UNPUBLISHED'))
        ];

        return HTMLHelper::_(
            'select.genericlist',
            $options,
            $this->name,
            [
                'id' => $this->id,
                'list.attr' => 'class="custom-select"',
                'list.select' => (string) $this->value
            ]
        );
    }
}