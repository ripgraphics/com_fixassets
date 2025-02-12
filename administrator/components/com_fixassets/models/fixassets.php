<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Log\Log;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Table\Asset;

class FixassetsModelFixassets extends ListModel
{
    public function __construct($config = array())
    {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id',
                'title',
                'type',
                'asset_id'
            );
        }

        parent::__construct($config);
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

    public function fixMissingAssets($entityType, $runAll, $selectedIds = array())
    {
        $db = $this->getDbo();
        $results = array();
        $entitiesToFix = array();

        if ($runAll) {
            $entitiesToFix = array('articles', 'categories', 'modules', 'plugins');
        } elseif (!empty($entityType)) {
            $entitiesToFix = array($entityType);
        } else {
            return Text::_('COM_FIXASSETS_NO_ENTITY_SELECTED');
        }

        foreach ($entitiesToFix as $type) {
            try {
                switch ($type) {
                    case 'articles':
                        $count = $this->fixArticles($selectedIds);
                        $results[] = Text::sprintf('COM_FIXASSETS_FIXED_ARTICLES', $count);
                        break;
                    case 'categories':
                        $count = $this->fixCategories($selectedIds);
                        $results[] = Text::sprintf('COM_FIXASSETS_FIXED_CATEGORIES', $count);
                        break;
                    case 'modules':
                        $count = $this->fixModules($selectedIds);
                        $results[] = Text::sprintf('COM_FIXASSETS_FIXED_MODULES', $count);
                        break;
                    case 'plugins':
                        $count = $this->fixPlugins($selectedIds);
                        $results[] = Text::sprintf('COM_FIXASSETS_FIXED_PLUGINS', $count);
                        break;
                    default:
                        $results[] = Text::sprintf('COM_FIXASSETS_UNKNOWN_TYPE', $type);
                }
            } catch (Exception $e) {
                Log::add($e->getMessage(), Log::ERROR, 'com_fixassets');
                throw new Exception(Text::sprintf('COM_FIXASSETS_ERROR_FIXING', $type));
            }
        }

        return implode('<br>', $results);
    }

    protected function fixArticles($selectedIds = array())
    {
        return $this->fixEntity('#__content', 'com_content.article', '', $selectedIds);
    }

    protected function fixCategories($selectedIds = array())
    {
        return $this->fixEntity('#__categories', 'com_categories.category', '', $selectedIds);
    }

    protected function fixModules($selectedIds = array())
    {
        return $this->fixEntity('#__modules', 'com_modules.module', '', $selectedIds);
    }

    protected function fixPlugins($selectedIds = array())
    {
        try {
            $db = $this->getDbo();
            $query = $db->getQuery(true);

            // Find plugins without assets
            $query->select('e.extension_id as id, e.name as title, e.element, e.folder')
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

            if (!empty($selectedIds)) {
                $query->where($db->quoteName('e.extension_id') . ' IN (' . implode(',', array_map('intval', $selectedIds)) . ')');
            }

            $db->setQuery($query);
            $plugins = $db->loadObjectList();

            if (empty($plugins)) {
                return 0;
            }

            $count = 0;
            foreach ($plugins as $plugin) {
                // Create new asset
                $asset = new Asset($db);
                $asset->name = 'com_plugins.plugin.' . $plugin->id;
                $asset->title = $plugin->folder . '/' . $plugin->element;
                $asset->rules = '{"core.edit":[],"core.edit.state":[],"core.edit.own":[]}';

                if (!$asset->store()) {
                    Log::add(
                        sprintf(
                            'Failed to create asset for plugin: %s. Error: %s',
                            $plugin->title,
                            $asset->getError()
                        ),
                        Log::ERROR,
                        'com_fixassets'
                    );
                    continue;
                }

                // Update the plugin with new asset id
                $query = $db->getQuery(true)
                    ->update($db->quoteName('#__extensions'))
                    ->set($db->quoteName('asset_id') . ' = ' . (int) $asset->id)
                    ->where($db->quoteName('extension_id') . ' = ' . (int) $plugin->id);

                $db->setQuery($query);
                
                try {
                    $db->execute();
                    $count++;
                    Log::add(
                        sprintf('Fixed asset for plugin: %s', $plugin->title),
                        Log::INFO,
                        'com_fixassets'
                    );
                } catch (Exception $e) {
                    Log::add(
                        sprintf(
                            'Failed to update plugin asset_id: %s. Error: %s',
                            $plugin->title,
                            $e->getMessage()
                        ),
                        Log::ERROR,
                        'com_fixassets'
                    );
                }
            }

            return $count;
        } catch (Exception $e) {
            Log::add('Error in fixPlugins: ' . $e->getMessage(), Log::ERROR, 'com_fixassets');
            throw new Exception(Text::_('COM_FIXASSETS_ERROR_FIXING_PLUGINS'));
        }
    }

    protected function fixEntity($table, $assetName, $additionalWhere = '', $selectedIds = array())
    {
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Find items without assets
        $query->select('a.id, a.title, a.asset_id')
            ->from($db->quoteName($table) . ' AS a')
            ->leftJoin(
                $db->quoteName('#__assets') . ' AS ast ON ast.id = a.asset_id'
            )
            ->where('(a.asset_id = 0 OR a.asset_id IS NULL OR ast.id IS NULL)');

        if (!empty($selectedIds)) {
            $query->where('a.id IN (' . implode(',', array_map('intval', $selectedIds)) . ')');
        }

        if ($additionalWhere) {
            $query->where($additionalWhere);
        }

        $db->setQuery($query);
        $items = $db->loadObjectList();

        if (empty($items)) {
            return 0;
        }

        $count = 0;
        foreach ($items as $item) {
            // Create new asset
            $asset = \Joomla\CMS\Table\Table::getInstance('Asset', 'JTable');
            $asset->name = $assetName . '.' . $item->id;
            $asset->title = $item->title;
            $asset->rules = '{}';

            if ($asset->store()) {
                // Update the item with new asset id
                $query = $db->getQuery(true)
                    ->update($db->quoteName($table))
                    ->set($db->quoteName('asset_id') . ' = ' . (int) $asset->id)
                    ->where($db->quoteName('id') . ' = ' . (int) $item->id);

                $db->setQuery($query);
                if ($db->execute()) {
                    $count++;
                }
            }
        }

        return $count;
    }
}