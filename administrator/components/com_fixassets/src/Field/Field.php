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

/**
 * Base custom field class for Fixassets component
 *
 * @since  1.0.0
 */
abstract class Field extends FormField
{
    /**
     * Method to get the field input markup.
     *
     * @return  string  The field input markup.
     *
     * @since   1.0.0
     */
    abstract protected function getInput(): string;
}