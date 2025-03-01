<?php
declare(strict_types=1);

/**
 * @package     Joomla.Administrator
 * @subpackage  com_fixassets
 *
 * @copyright   Copyright (C) 2023 RIP Graphics. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace RipGraphics\Component\Fixassets\Administrator\Helper;

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\Database\DatabaseInterface;
use Joomla\CMS\Log\Log;

/**
 * Asset Fixer Helper class for the Fix Assets component.
 *
 * @since  1.0.0
 */
class AssetFixerHelper
{
    /**
     * Fix missing or broken assets
     *
     * @param   array  $issues  Array of issues to fix
     *
     * @return  array  Array of results
     *
     * @since   1.0.0
     */
    public static function fixAssets($issues)
    {
        $db = Factory::getContainer()->get(DatabaseInterface::class);
        $results = array();

        // Start logging
        Log::addLogger(
            array('text_file' => 'com_fixassets.log.php'),
            Log::ALL,
            array('com_fixassets')
        );

        try {
            // Fix missing assets
            if (!empty($issues['missing'])) {
                foreach ($issues['missing'] as $assetName) {
                    $result = self::fixAssetHierarchy($assetName);
                    $results['fixed'][] = $assetName;
                    
                    Log::add(
                        sprintf('Fixed missing asset: %s', $assetName),
                        Log::INFO,
                        'com_fixassets'
                    );
                }
            }

            // Fix orphaned assets
            if (!empty($issues['orphaned'])) {
                foreach ($issues['orphaned'] as $asset) {
                    $result = self::fixOrphanedAsset($asset);
                    $results['fixed'][] = $asset['name'];
                    
                    Log::add(
                        sprintf('Fixed orphaned asset: %s', $asset['name']),
                        Log::INFO,
                        'com_fixassets'
                    );
                }
            }
        } catch (\Exception $e) {
            Log::add($e->getMessage(), Log::ERROR, 'com_fixassets');
            $results['error'] = $e->getMessage();
        }

        return $results;
    }

    /**
     * Fix asset hierarchy for a specific asset
     *
     * @param   string  $assetName  The name of the asset to fix
     *
     * @return  boolean
     *
     * @since   1.0.0
     */
    protected static function fixAssetHierarchy($assetName)
    {
        $db = Factory::getContainer()->get(DatabaseInterface::class);
        
        // Get component from asset name
        $parts = explode('.', $assetName);
        $component = $parts[0];

        // Get or create component asset
        $query = $db->getQuery(true)
            ->select($db->quoteName('id'))
            ->from($db->quoteName('#__assets'))
            ->where($db->quoteName('name') . ' = :component')
            ->bind(':component', $component);

        $db->setQuery($query);
        $parentId = $db->loadResult();

        if (!$parentId) {
            $columns = array('parent_id', 'name', 'title', 'rules');
            $values = array(1, $component, ucfirst(substr($component, 4)), '{}');
            
            $query = $db->getQuery(true)
                ->insert($db->quoteName('#__assets'))
                ->columns($db->quoteName($columns))
                ->values(implode(',', $values));
                
            $db->setQuery($query);
            $db->execute();
            $parentId = $db->insertid();
        }

        // Update the asset parent
        $query = $db->getQuery(true)
            ->update($db->quoteName('#__assets'))
            ->set($db->quoteName('parent_id') . ' = :parentId')
            ->where($db->quoteName('name') . ' = :assetName')
            ->bind(':parentId', $parentId, \PDO::PARAM_INT)
            ->bind(':assetName', $assetName);

        $db->setQuery($query);
        return $db->execute();
    }

    /**
     * Fix an orphaned asset
     *
     * @param   array  $asset  The asset to fix
     *
     * @return  boolean
     *
     * @since   1.0.0
     */
    protected static function fixOrphanedAsset($asset)
    {
        $db = Factory::getContainer()->get(DatabaseInterface::class);
        
        // Set parent_id to root if no valid parent found
        $query = $db->getQuery(true)
            ->update($db->quoteName('#__assets'))
            ->set($db->quoteName('parent_id') . ' = 1')
            ->where($db->quoteName('id') . ' = :id')
            ->bind(':id', $asset['id'], \PDO::PARAM_INT);

        $db->setQuery($query);
        return $db->execute();
    }
}