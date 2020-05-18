<?php

namespace FondOfSpryker\Zed\Customer\Business;

use FondOfSpryker\Zed\Customer\Business\Checkout\CustomerOrderSaverWithMultiShippingAddress;
use FondOfSpryker\Zed\Customer\Business\Customer\Customer;
use Spryker\Zed\Customer\Business\Checkout\CustomerOrderSaverInterface;
use Spryker\Zed\Customer\Business\Customer\CustomerInterface;
use Spryker\Zed\Customer\Business\CustomerBusinessFactory as SprykerCustomerBusinessFactory;
use Spryker\Zed\Customer\Business\ReferenceGenerator\CustomerReferenceGenerator;

/**
 * @method \FondOfSpryker\Zed\Customer\CustomerConfig getConfig()
 * @method \Spryker\Zed\Customer\Persistence\CustomerQueryContainerInterface getQueryContainer()
 */
class CustomerBusinessFactory extends SprykerCustomerBusinessFactory
{
    /**
     * @return \Spryker\Zed\Customer\Business\Customer\CustomerInterface
     */
    public function createCustomer(): CustomerInterface
    {
        $config = $this->getConfig();

        return new Customer(
            $this->getQueryContainer(),
            $this->createCustomerReferenceGenerator(),
            $config,
            $this->createEmailValidator(),
            $this->getMailFacade(),
            $this->getLocaleQueryContainer(),
            $this->getStore(),
            $this->createCustomerExpander(),
            $this->getPostCustomerRegistrationPlugins()
        );
    }

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
