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
use Joomla\CMS\Factory;

/**
 * Custom field for handling asset selection in Fixassets component
 *
 * @since  1.0.0
 */
class AssetField extends FormField
{
    /**
     * The form field type.
     *
     * @var    string
     * @since  1.0.0
     */
    protected $type = 'Asset';

    /**
     * Method to get the field input markup.
     *
     * @return  string  The field input markup.
     *
     * @since   1.0.0
     */
    protected function getInput(): string
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true)
            ->select($db->quoteName('id', 'title'))
            ->from($db->quoteName('#__assets'));

        $db->setQuery($query);
        $assets = $db->loadObjectList();

        $options = [];
        foreach ($assets as $asset) {
            $options[] = HTMLHelper::_('select.option', $asset->id, $asset->title);
        }

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