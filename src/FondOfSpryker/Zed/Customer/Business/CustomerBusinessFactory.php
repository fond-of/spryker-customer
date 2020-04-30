<?php

namespace FondOfSpryker\Zed\Customer\Business;

use FondOfSpryker\Zed\Customer\Business\Checkout\CustomerOrderSaverWithMultiShippingAddress;
use Spryker\Zed\Customer\Business\Checkout\CustomerOrderSaverInterface;
use Spryker\Zed\Customer\Business\CustomerBusinessFactory as SprykerCustomerBusinessFactory;
use Spryker\Zed\Customer\Business\ReferenceGenerator\CustomerReferenceGenerator;

/**
 * @method \FondOfSpryker\Zed\Customer\CustomerConfig getConfig()
 * @method \Spryker\Zed\Customer\Persistence\CustomerQueryContainerInterface getQueryContainer()
 */
class CustomerBusinessFactory extends SprykerCustomerBusinessFactory
{
    /**
     * @return \Spryker\Zed\Customer\Business\ReferenceGenerator\CustomerReferenceGeneratorInterface
     */
    protected function createCustomerReferenceGenerator()
    {
        return new CustomerReferenceGenerator(
            $this->getSequenceNumberFacade(),
            $this->getConfig()->getCustomerReferenceDefaults()
        );
    }

    /**
     * @return \Spryker\Zed\Customer\Business\Checkout\CustomerOrderSaverInterface
     */
    public function createCheckoutCustomerOrderSaverWithMultiShippingAddress(): CustomerOrderSaverInterface
    {
        return new CustomerOrderSaverWithMultiShippingAddress(
            $this->createCustomer(),
            $this->createAddress(),
            $this->getCustomerService()
        );
    }
}
