<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Log\Log;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Table\Asset;

class FixassetsModelFixassets extends ListModel
{
    protected $context = 'com_fixassets.fixassets';

    public function __construct($config = array())
    {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id',
                'title',
                'type',
                'asset_id',
                'state',
                'created',
                'modified'
            );
        }

        parent::__construct($config);
    }

    protected function populateState($ordering = 'a.id', $direction = 'desc')
    {
        $app = Factory::getApplication();

        // Load the filter state
        $search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $published = $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', '');
        $this->setState('filter.published', $published);

        // List state information
        parent::populateState($ordering, $direction);
    }

    public function getItems()
    {
        $type = $this->getState('filter.type', '');
        
        if (empty($type)) {
            return array();
        }

        switch ($type) {
            case 'articles':
                return $this->getMissingArticleAssets();
            case 'categories':
                return $this->getMissingCategoryAssets();
            case 'modules':
                return $this->getMissingModuleAssets();
            case 'plugins':
                return $this->getMissingPluginAssets();
            default:
                return array();
        }
    }

    protected function getMissingArticleAssets()
    {
        return $this->getMissingAssets('#__content', 'id', 'title', 'com_content.article');
    }

    protected function getMissingCategoryAssets()
    {
        return $this->getMissingAssets('#__categories', 'id', 'title', 'com_categories.category');
    }

    protected function getMissingModuleAssets()
    {
        return $this->getMissingAssets('#__modules', 'id', 'title', 'com_modules.module');
    }

    protected function getMissingPluginAssets()
    {
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        $query->select('e.extension_id as id, CONCAT(e.folder, "/", e.element) as title')
            ->from($db->quoteName('#__extensions', 'e'))
            ->leftJoin(
                $db->quoteName('#__assets', 'a') . ' ON ' . 
                $db->quoteName('a.name') . ' = CONCAT(' . 
                $db->quote('com_plugins.plugin.') . ', ' . 
                $db->quoteName('e.extension_id') . ')'
            )
            ->where([
                $db->quoteName('e.type') . ' = ' . $db->quote('plugin'),
                $db->quoteName('a.id') . ' IS NULL'
            ]);

        $db->setQuery($query);
        return $db->loadObjectList();
    }

    protected function getMissingAssets($table, $idField, $titleField, $assetPrefix)
    {
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        $query->select('a.' . $idField . ' as id, a.' . $titleField . ' as title')
            ->from($db->quoteName($table) . ' AS a')
            ->leftJoin(
                $db->quoteName('#__assets') . ' AS ast ON ast.id = a.asset_id'
            )
            ->where('(a.asset_id = 0 OR a.asset_id IS NULL OR ast.id IS NULL)');

        $db->setQuery($query);
        return $db->loadObjectList();
    }
}