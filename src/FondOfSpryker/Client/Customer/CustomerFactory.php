<?php

namespace FondOfSpryker\Client\Customer;

use FondOfSpryker\Client\Customer\Zed\CustomerStub;
use Spryker\Client\Customer\CustomerFactory as SprykerCustomerFactory;

class CustomerFactory extends SprykerCustomerFactory
{
    /**
     * @return \FondOfSpryker\Client\Customer\Zed\CustomerStubInterface
     */
    public function createZedCustomerStub()
    {
        return new CustomerStub(
            $this->getProvidedDependency(CustomerDependencyProvider::SERVICE_ZED)
        );
    }

    /**
     * @return \Spryker\Client\Cart\CartClientInterface
     */
    public function getCartClient()
    {
        return $this->getProvidedDependency(CustomerDependencyProvider::CART_CLIENT);
    }
}
