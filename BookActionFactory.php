<?php

declare(strict_types=1);

namespace Book\Action;

use Interop\Container\ContainerInterface;
use Log\Action\LogListener;
use Zend\EventManager\EventManager;
use Zend\EventManager\LazyListener;
use Zend\Expressive\Hal\HalResponseFactory;
use Zend\Expressive\Hal\ResourceGenerator;

class BookActionFactory
{
    public function __invoke(ContainerInterface $container) : BookAction
    {
        $bookAction = new BookAction($container->get(ResourceGenerator::class),
            $container->get(HalResponseFactory::class));
        $bookAction->setEventManager(new EventManager());
        $listener = new LazyListener([
            'listener' => LogListener::class,
            'method' => 'log'
        ], $container);
        $bookAction->getEventManager()->attach('getBook', $listener);
        return $bookAction;
    }
}
