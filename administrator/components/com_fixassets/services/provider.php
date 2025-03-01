<?php
declare(strict_types=1);

/**
 * @package     Joomla.Administrator
 * @subpackage  com_fixassets
 */

namespace RipGraphics\Component\Fixassets\Administrator\Service\Provider;

use Joomla\DI\ServiceProviderInterface;
use Joomla\DI\Container;
use Joomla\CMS\Extension\Service\Provider\ComponentDispatcherFactory;
use Joomla\CMS\Extension\Service\Provider\MVCFactory;
use Joomla\CMS\HTML\Registry;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container): void
    {
        $container->registerServiceProvider(new MVCFactory('\\RipGraphics\\Component\\Fixassets'));
        $container->registerServiceProvider(new ComponentDispatcherFactory('\\RipGraphics\\Component\\Fixassets'));
        
        $container->set(
            Registry::class,
            function (Container $container) {
                return new Registry;
            }
        );
    }
}