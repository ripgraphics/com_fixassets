<?php
declare(strict_types=1);

/**
 * @package     Joomla.Administrator
 * @subpackage  com_fixassets
 *
 * @copyright   Copyright (C) 2023 RIP Graphics. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace RipGraphics\Component\Fixassets\Administrator\Service\HTML;

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

/**
 * Service class for handling administrator-specific tasks in Fixassets component
 *
 * @since  1.0.0
 */
class AdministratorService
{
    /**
     * Method to render a custom button
     *
     * @param   string  $text  The button text
     * @param   string  $link  The button link
     *
     * @return  string  The HTML for the button
     *
     * @since   1.0.0
     */
    public static function renderButton(string $text, string $link): string
    {
        return '<a href="' . $link . '" class="btn btn-primary">' . Text::_($text) . '</a>';
    }

    /**
     * Method to get the current user
     *
     * @return  object  The current user object
     *
     * @since   1.0.0
     */
    public static function getCurrentUser(): object
    {
        return Factory::getApplication()->getIdentity();
    }
}