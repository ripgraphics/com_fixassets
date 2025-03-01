<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_fixassets
 *
 * @copyright   Copyright (C) 2023 RIP Graphics. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace RipGraphics\Component\Fixassets\Administrator\Service\HTML;

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

/**
 * Icon Helper class for the Fix Assets component
 *
 * @since  1.0.0
 */
class IconHelper
{
    /**
     * Display a status icon
     *
     * @param   integer  $status  The status code
     *
     * @return  string   The HTML for the status icon
     *
     * @since   1.0.0
     */
    public static function status($status)
    {
        $icons = [
            -2 => 'icon-trash',
            0  => 'icon-times',
            1  => 'icon-check',
            2  => 'icon-archive'
        ];

        $states = [
            -2 => 'JTRASHED',
            0  => 'JUNPUBLISHED',
            1  => 'JPUBLISHED',
            2  => 'JARCHIVED'
        ];

        $icon = isset($icons[$status]) ? $icons[$status] : 'icon-question';
        $state = isset($states[$status]) ? $states[$status] : 'JUNKNOWN';

        return '<span class="' . $icon . '" aria-hidden="true" title="' . Text::_($state) . '"></span>';
    }

    /**
     * Display an action icon
     *
     * @param   string   $action  The action name
     * @param   boolean  $isLink  Whether the icon should be a link
     *
     * @return  string   The HTML for the action icon
     *
     * @since   1.0.0
     */
    public static function action($action, $isLink = false)
    {
        $icons = [
            'fix'     => 'icon-wrench',
            'rebuild' => 'icon-refresh',
            'delete'  => 'icon-trash',
            'backup'  => 'icon-download',
            'restore' => 'icon-upload'
        ];

        $icon = isset($icons[$action]) ? $icons[$action] : 'icon-question';
        $text = 'COM_FIXASSETS_ACTION_' . strtoupper($action);

        if ($isLink) {
            return '<a href="#" class="' . $icon . '" aria-hidden="true" title="' . Text::_($text) . '"></a>';
        }

        return '<span class="' . $icon . '" aria-hidden="true" title="' . Text::_($text) . '"></span>';
    }
}