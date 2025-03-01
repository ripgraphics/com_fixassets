<?php
declare(strict_types=1);

/**
 * @package     Joomla.Administrator
 * @subpackage  com_fixassets
 */

namespace RipGraphics\Component\Fixassets\Administrator\Rule;

\defined('_JEXEC') or die;

use Joomla\CMS\Form\FormRule;

/**
 * Custom rules for Fixassets component
 *
 * @since  1.0.0
 */
class Rules extends FormRule
{
    /**
     * Method to test a field value.
     *
     * @param   \SimpleXMLElement  $element  The SimpleXMLElement object representing the <field /> tag for the form field object.
     * @param   mixed              $value    The form field value to validate.
     * @param   string             $group    The field name group control value. This acts as as an array container for the field.
     * @param   \Joomla\CMS\Form\Form  $form     The form object for which the field is being tested.
     *
     * @return  boolean  True if the value is valid, false otherwise.
     *
     * @since   1.0.0
     */
    public function test(\SimpleXMLElement $element, $value, $group = null, $form = null): bool
    {
        // Custom validation logic here
        return true;
    }
}