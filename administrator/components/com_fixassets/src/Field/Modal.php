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
 * Custom field for handling modal selection in Fixassets component
 *
 * @since  1.0.0
 */
class Modal extends FormField
{
    /**
     * The form field type.
     *
     * @var    string
     * @since  1.0.0
     */
    protected $type = 'Modal';

    /**
     * Method to get the field input markup.
     *
     * @return  string  The field input markup.
     *
     * @since   1.0.0
     */
    protected function getInput(): string
    {
        // Add modal script
        HTMLHelper::_('script', 'com_fixassets/modal.js', ['version' => 'auto', 'relative' => true]);

        return '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#' . $this->id . 'Modal">'
            . Text::_('COM_FIXASSETS_SELECT_ITEM') . '</button>'
            . '<div class="modal fade" id="' . $this->id . 'Modal" tabindex="-1" role="dialog" aria-labelledby="' . $this->id . 'ModalLabel" aria-hidden="true">'
            . '<div class="modal-dialog" role="document">'
            . '<div class="modal-content">'
            . '<div class="modal-header">'
            . '<h5 class="modal-title" id="' . $this->id . 'ModalLabel">' . Text::_('COM_FIXASSETS_SELECT_ITEM') . '</h5>'
            . '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'
            . '<span aria-hidden="true">&times;</span>'
            . '</button>'
            . '</div>'
            . '<div class="modal-body">'
            . '<p>' . Text::_('COM_FIXASSETS_MODAL_CONTENT') . '</p>'
            . '</div>'
            . '<div class="modal-footer">'
            . '<button type="button" class="btn btn-secondary" data-dismiss="modal">' . Text::_('COM_FIXASSETS_CLOSE') . '</button>'
            . '<button type="button" class="btn btn-primary">' . Text::_('COM_FIXASSETS_SAVE_CHANGES') . '</button>'
            . '</div>'
            . '</div>'
            . '</div>'
            . '</div>';
    }
}