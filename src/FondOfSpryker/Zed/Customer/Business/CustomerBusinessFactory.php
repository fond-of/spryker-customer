<?php

namespace FondOfSpryker\Zed\Customer\Business;

use FondOfSpryker\Zed\Customer\Business\Checkout\CustomerOrderSaver;
use Spryker\Zed\Customer\Business\CustomerBusinessFactory as SprykerCustomerBusinessFactory;

/**
 * @method \Spryker\Zed\Customer\CustomerConfig getConfig()
 * @method \Spryker\Zed\Customer\Persistence\CustomerQueryContainerInterface getQueryContainer()
 */
class CustomerBusinessFactory extends SprykerCustomerBusinessFactory
{
    /**
     * @return \Spryker\Zed\Customer\Business\Checkout\CustomerOrderSaverInterface
     */
    public function createCheckoutCustomerOrderSaver()
    {
        return new CustomerOrderSaver($this->createCustomer(), $this->createAddress());
    }
}
