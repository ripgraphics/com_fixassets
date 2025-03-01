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
 * Custom field for handling events in Fixassets component
 *
 * @since  1.0.0
 */
class EventsField extends FormField
{
    /**
     * The form field type.
     *
     * @var    string
     * @since  1.0.0
     */
    protected $type = 'Events';

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
            HTMLHelper::_('select.option', 'event1', Text::_('COM_FIXASSETS_EVENT1')),
            HTMLHelper::_('select.option', 'event2', Text::_('COM_FIXASSETS_EVENT2'))
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