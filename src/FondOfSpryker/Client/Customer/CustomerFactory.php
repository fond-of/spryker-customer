<?php

namespace FondOfSpryker\Client\Customer;

use FondOfSpryker\Client\Customer\Zed\CustomerStub;
use Spryker\Client\Cart\CartClientInterface;
use Spryker\Client\Customer\CustomerFactory as SprykerCustomerFactory;
use Spryker\Client\Customer\Zed\CustomerStubInterface;

class CustomerFactory extends SprykerCustomerFactory
{
    /**
     * @return \Spryker\Client\Customer\Zed\CustomerStubInterface
     */
    public function createZedCustomerStub(): CustomerStubInterface
    {
        return new CustomerStub(
            $this->getProvidedDependency(CustomerDependencyProvider::SERVICE_ZED)
        );
    }

    /**
     * @return \Spryker\Client\Cart\CartClientInterface
     */
    public function getCartClient(): CartClientInterface
    {
        return $this->getProvidedDependency(CustomerDependencyProvider::CART_CLIENT);
    }
}
