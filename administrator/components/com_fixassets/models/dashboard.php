<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\Database\DatabaseDriver;

class FixassetsModelDashboard extends ListModel
{
    protected $context = 'com_fixassets.dashboard';

    public function __construct($config = array())
    {
        if (empty($config['filter_fields']))
        {
            $config['filter_fields'] = array(
                'id',
                'a.id',
                'title',
                'a.title',
                'state',
                'a.state',
                'created',
                'a.created',
                'modified',
                'a.modified',
                'published',
                'a.published'
            );
        }

        parent::__construct($config);
    }

    protected function populateState($ordering = 'a.id', $direction = 'desc')
    {
        $app = Factory::getApplication();

        // Get the type of items to display (articles, categories, modules, plugins)
        $itemType = $app->getUserStateFromRequest($this->context . '.item_type', 'item_type', 'articles');
        $this->setState('item_type', $itemType);

        // Load the filter state
        $search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $published = $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', '');
        $this->setState('filter.published', $published);

        // List state information
        parent::populateState($ordering, $direction);
    }

    protected function getListQuery()
    {
        $db = $this->getDbo();
        $query = $db->getQuery(true);
        $type = $this->getState('item_type', 'articles');

        switch ($type) {
            case 'articles':
                $query->select('a.id, a.title, a.state, a.created, a.modified, a.access')
                    ->from($db->quoteName('#__content', 'a'))
                    ->select('c.title AS category_title')
                    ->join('LEFT', '#__categories AS c ON c.id = a.catid');
                break;

            case 'categories':
                $query->select('a.id, a.title, a.published AS state, a.created_time AS created, a.modified_time AS modified, a.access')
                    ->from($db->quoteName('#__categories', 'a'))
                    ->where('a.extension = ' . $db->quote('com_content'));
                break;

            case 'modules':
                $query->select('a.id, a.title, a.published AS state, a.created AS created, a.created AS modified, a.access')
                    ->from($db->quoteName('#__modules', 'a'));
                break;

            case 'plugins':
                $query->select('a.extension_id AS id, a.name AS title, a.enabled AS state, NULL AS created, NULL AS modified, 1 AS access')
                    ->from($db->quoteName('#__extensions', 'a'))
                    ->where('a.type = ' . $db->quote('plugin'));
                break;

            default:
                $query->select('a.id, a.title, a.state, a.created, a.modified, a.access')
                    ->from($db->quoteName('#__content', 'a'));
                break;
        }

        // Filter by search
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            $search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
            $query->where('a.title LIKE ' . $search);
        }

        // Filter by published state
        $published = $this->getState('filter.published');
        if (is_numeric($published)) {
            $query->where('a.state = ' . (int) $published);
        }

        // Add the list ordering clause
        $orderCol = $this->state->get('list.ordering', 'a.id');
        $orderDirn = $this->state->get('list.direction', 'desc');
        
        $query->order($db->escape($orderCol . ' ' . $orderDirn));

        return $query;
    }
}