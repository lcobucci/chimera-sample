<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Lcobucci\Chimera\Bus\Tactician\DependencyInjection as Bus;
use Lcobucci\Chimera\Routing\Expressive\DependencyInjection as Routing;
use Lcobucci\DependencyInjection\ContainerBuilder;
use Zend\Expressive\Router\FastRouteRouter;

$builder = new ContainerBuilder();
$devMode = getenv('APPLICATION_MODE') === 'dev';

if ($devMode) {
    $builder->useDevelopmentMode();
}

$cacheDir = realpath(dirname(__DIR__) . '/tmp/cache');

return $builder->setParameter('app.basedir', realpath(dirname(__DIR__)) . '/')
               ->addFile(__DIR__ . '/../src/services.xml')
               ->setDumpDir($cacheDir)
               ->addPass(new Bus\RegisterServices('bus.command', 'bus.query'))
               ->addPass(
                   new Routing\RegisterServices(
                       'my-api',
                       'bus.command',
                       'bus.query',
                       [
                           'router_config' => [
                               FastRouteRouter::CONFIG_CACHE_ENABLED => ! $devMode,
                               FastRouteRouter::CONFIG_CACHE_FILE => $cacheDir . '/router.cache.php',
                           ],
                       ]
                   )
               )->getContainer();
