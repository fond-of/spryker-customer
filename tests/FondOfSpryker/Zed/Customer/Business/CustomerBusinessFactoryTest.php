<?php

namespace FondOfSpryker\Zed\Customer\Business;

use Codeception\Test\Unit;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\Customer\Business\Customer\Customer as SprykerCustomer;
use Spryker\Zed\Customer\Business\Customer\CustomerInterface;
use Spryker\Zed\Customer\Business\Customer\EmailValidatorInterface;
use Spryker\Zed\Customer\Business\CustomerExpander\CustomerExpanderInterface;
use Spryker\Zed\Customer\Business\ReferenceGenerator\CustomerReferenceGeneratorInterface;
use Spryker\Zed\Customer\CustomerConfig;
use Spryker\Zed\Customer\Dependency\Facade\CustomerToMailInterface;
use Spryker\Zed\Customer\Persistence\CustomerQueryContainerInterface;
use Spryker\Zed\Locale\Persistence\LocaleQueryContainerInterface;

class CustomerBusinessFactoryTest extends Unit
{
    /**
     * @return void
     */
    public function testCreateCustomer()
    {
        $queryContainer = $this->createMock(CustomerQueryContainerInterface::class);
        $customerReferenceGenerator = $this->createMock(CustomerReferenceGeneratorInterface::class);
        $customerConfig = $this->createMock(CustomerConfig::class);
        $emailValidator = $this->createMock(EmailValidatorInterface::class);
        $mailFacade = $this->createMock(CustomerToMailInterface::class);
        $localeQueryContainer = $this->createMock(LocaleQueryContainerInterface::class);
        $store = $this->createMock(Store::class);
        $customerExpander = $this->createMock(CustomerExpanderInterface::class);
        $postCustomerRegistrationPlugins = [];

        $customer = new SprykerCustomer(
            $queryContainer,
            $customerReferenceGenerator,
            $customerConfig,
            $emailValidator,
            $mailFacade,
            $localeQueryContainer,
            $store,
            $customerExpander,
            $postCustomerRegistrationPlugins
        );

        $this->assertInstanceOf(CustomerInterface::class, $customer);
    }
}
