<?php

namespace Authorization\Middleware;


use Interop\Container\ContainerInterface;
use Utils\Entity\ErrorJsonResponse;
use Utils\Presenter\HalErrorPresenter;
use Utils\Traits\UrlTrait;
use Utils\UrlBuilder;
use Zend\ServiceManager\Factory\FactoryInterface;

class AuthorizationMiddlewareFactory implements FactoryInterface
{
    use UrlTrait;

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $urlBuilder = $container->get(UrlBuilder::class);
        $authPresenter = new HalErrorPresenter($this->getHalResource($urlBuilder));
        $errorJSONResponse = new ErrorJsonResponse($authPresenter);
        return new AuthorizationMiddleware($errorJSONResponse);
    }
}