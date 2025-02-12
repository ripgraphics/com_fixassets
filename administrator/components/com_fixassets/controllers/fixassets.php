<?php
defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\AdminController;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

class FixassetsControllerFixassets extends AdminController
{
    public function getModel($name = 'Fixassets', $prefix = 'FixassetsModel', $config = array())
    {
        return parent::getModel($name, $prefix, $config);
    }

    public function fixmissingassets()
    {
        // Check for request forgeries
        $this->checkToken();

        try {
            $input = Factory::getApplication()->input;
            $entityType = $input->get('entity_type', array(), 'ARRAY');
            $runAll = $input->get('run_all', false, 'BOOLEAN');

            $model = $this->getModel();
            $result = $model->fixMissingAssets($entityType, $runAll);
            
            Factory::getApplication()->enqueueMessage($result, 'success');
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage($e->getMessage(), 'error');
        }

        $this->setRedirect(Route::_('index.php?option=com_fixassets&view=fixassets', false));
    }
}