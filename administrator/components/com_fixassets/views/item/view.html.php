<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_fixassets
 *
 * @copyright   Copyright (C) 2023 RIP Graphics. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace RipGraphics\Component\Fixassets\Administrator\View\Item;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ContentHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;

/**
 * View to edit an item
 *
 * @since  1.0.0
 */
class HtmlView extends BaseHtmlView
{
    /**
     * The form object
     *
     * @var  \Joomla\CMS\Form\Form
     */
    protected $form;

    /**
     * The active item
     *
     * @var  object
     */
    protected $item;

    /**
     * The model state
     *
     * @var  object
     */
    protected $state;

    /**
     * Display the view
     *
     * @param   string  $tpl  The name of the template file to parse
     *
     * @return  void
     */
    public function display($tpl = null)
    {
        $this->form = $this->get('Form');
        $this->item = $this->get('Item');
        $this->state = $this->get('State');

        $this->addToolbar();

        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar
     *
     * @return  void
     */
    protected function addToolbar()
    {
        Factory::getApplication()->input->set('hidemainmenu', true);

        $isNew = ($this->item->id == 0);
        $canDo = ContentHelper::getActions('com_fixassets');

        ToolbarHelper::title(
            Text::_('COM_FIXASSETS_' . ($isNew ? 'ADD_ITEM' : 'EDIT_ITEM')),
            'puzzle'
        );

        if ($canDo->get('core.edit') || $canDo->get('core.create'))
        {
            ToolbarHelper::apply('item.apply');
            ToolbarHelper::save('item.save');
        }

        if ($canDo->get('core.create'))
        {
            ToolbarHelper::save2new('item.save2new');
        }

        if (!$isNew && $canDo->get('core.create'))
        {
            ToolbarHelper::save2copy('item.save2copy');
        }

        ToolbarHelper::cancel('item.cancel', 'JTOOLBAR_CLOSE');
    }
}