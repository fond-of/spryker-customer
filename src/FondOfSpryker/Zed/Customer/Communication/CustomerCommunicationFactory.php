<?php

namespace FondOfSpryker\Zed\Customer\Communication;

use FondOfSpryker\Zed\Customer\CustomerDependencyProvider;
use Spryker\Zed\Customer\Communication\CustomerCommunicationFactory as SprykerCustomerCommunicationFactory;

/**
 * @method \FondOfSpryker\Zed\Customer\CustomerConfig getConfig()
 */
class CustomerCommunicationFactory extends SprykerCustomerCommunicationFactory
{
    /**
     * @return \Spryker\Zed\Sales\Business\SalesFacade
     */
    public function getSalesFacade()
    {
        return $this->getProvidedDependency(CustomerDependencyProvider::SALES_FACADE);
    }

    /**
     * @return \Spryker\Zed\Newsletter\Business\NewsletterFacade
     */
    public function getNewsletterFacade()
    {
        return $this->getProvidedDependency(CustomerDependencyProvider::NEWSLETTER_FACADE);
    }
}
