<?php
defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\BaseDatabaseModel;

class FixassetsModelDashboard extends BaseDatabaseModel
{
    public function getMissingAssetsCount($type)
    {
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        switch ($type) {
            case 'articles':
                $query->select('COUNT(*)')
                    ->from($db->quoteName('#__content', 'a'))
                    ->leftJoin(
                        $db->quoteName('#__assets', 'ast') . ' ON ast.id = a.asset_id'
                    )
                    ->where('(a.asset_id = 0 OR a.asset_id IS NULL OR ast.id IS NULL)');
                break;

            case 'categories':
                $query->select('COUNT(*)')
                    ->from($db->quoteName('#__categories', 'a'))
                    ->leftJoin(
                        $db->quoteName('#__assets', 'ast') . ' ON ast.id = a.asset_id'
                    )
                    ->where('(a.asset_id = 0 OR a.asset_id IS NULL OR ast.id IS NULL)');
                break;

            case 'modules':
                $query->select('COUNT(*)')
                    ->from($db->quoteName('#__modules', 'a'))
                    ->leftJoin(
                        $db->quoteName('#__assets', 'ast') . ' ON ast.id = a.asset_id'
                    )
                    ->where('(a.asset_id = 0 OR a.asset_id IS NULL OR ast.id IS NULL)');
                break;

            case 'plugins':
                $query->select('COUNT(*)')
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
                break;

            default:
                return 0;
        }

        $db->setQuery($query);
        return (int) $db->loadResult();
    }
}