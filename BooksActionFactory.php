<?php

declare(strict_types=1);

namespace Book\Action;

use Psr\Container\ContainerInterface;
use Zend\Expressive\Hal\HalResponseFactory;
use Zend\Expressive\Hal\ResourceGenerator;

class BooksActionFactory
{
    public function __invoke(ContainerInterface $container) : BooksAction
    {
        return new BooksAction($container->get(ResourceGenerator::class), $container->get(HalResponseFactory::class));
    }
}
