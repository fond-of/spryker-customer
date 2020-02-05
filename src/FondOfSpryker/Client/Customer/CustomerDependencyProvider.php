<?php

namespace FondOfSpryker\Client\Customer;

use Spryker\Client\Customer\CustomerDependencyProvider as SprykerCustomerDependencyProvider;
use Spryker\Client\Kernel\Container;

class CustomerDependencyProvider extends SprykerCustomerDependencyProvider
{
    public const CART_CLIENT = 'cart client';

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    public function provideServiceLayerDependencies(Container $container)
    {
        $container = parent::provideServiceLayerDependencies($container);

        $container[self::CART_CLIENT] = function (Container $container) {
            return $container->getLocator()->cart()->client();
        };

        return $container;
    }
}
