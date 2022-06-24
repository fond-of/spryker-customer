<?php

namespace FondOfSpryker\Zed\Customer;

use Spryker\Zed\Customer\CustomerDependencyProvider as SprykerCustomerDependencyProvider;
use Spryker\Zed\Kernel\Container;

class CustomerDependencyProvider extends SprykerCustomerDependencyProvider
{
    public const SALES_FACADE = 'sales facade';
    public const NEWSLETTER_FACADE = 'newsletter facade';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container)
    {
        $container = parent::provideCommunicationLayerDependencies($container);

        $container[self::SALES_FACADE] = function (Container $container) {
            return $container->getLocator()->sales()->facade();
        };

        return $container;
    }
}
