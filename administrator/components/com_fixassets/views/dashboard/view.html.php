<?php
defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Factory;

class FixassetsViewDashboard extends HtmlView
{
    protected $missingAssetsCount;
    
    public function display($tpl = null)
    {
        // Add custom body class
        Factory::getApplication()->getDocument()->addCustomTag('
            <script>
                document.body.classList.add("com_fixassets");
            </script>
        ');

        $model = $this->getModel();
        $this->missingAssetsCount = [
            'articles' => $model->getMissingAssetsCount('articles'),
            'categories' => $model->getMissingAssetsCount('categories'),
            'modules' => $model->getMissingAssetsCount('modules'),
            'plugins' => $model->getMissingAssetsCount('plugins')
        ];

        $this->addToolbar();
        parent::display($tpl);
    }

    protected function addToolbar()
    {
        ToolbarHelper::title(Text::_('COM_FIXASSETS_DASHBOARD'), 'puzzle');
    }
}