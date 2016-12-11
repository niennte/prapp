<?php
namespace Application\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Service\TimeKeepingService;
use Application\Controller\IndexController;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $timeKeepingService = $container->get(TimeKeepingService::class);

        // Instantiate the controller and inject dependencies
        return new IndexController($timeKeepingService);
    }

}