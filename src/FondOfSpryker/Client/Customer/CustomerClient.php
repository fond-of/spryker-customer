<?php

namespace FondOfSpryker\Client\Customer;

use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\CustomerOverviewRequestTransfer;
use Generated\Shared\Transfer\CustomerOverviewResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Client\Customer\CustomerClient as SprykerCustomerClient;

/**
 * @method \FondOfSpryker\Client\Customer\CustomerFactory getFactory()
 */
class CustomerClient extends SprykerCustomerClient implements CustomerClientInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerOverviewRequestTransfer $overviewRequest
     *
     * @return \Generated\Shared\Transfer\CustomerOverviewResponseTransfer
     */
    public function getCustomerOverview(CustomerOverviewRequestTransfer $overviewRequest): CustomerOverviewResponseTransfer
    {
        return $this->getFactory()
            ->createZedCustomerStub()
            ->getCustomerOverview($overviewRequest);
    }

    /**
     * @param \Generated\Shared\Transfer\AddressTransfer $addressTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function createAddressAndUpdateCustomerDefaultAddresses(AddressTransfer $addressTransfer): CustomerTransfer
    {
        $customerTransfer = parent::createAddressAndUpdateCustomerDefaultAddresses($addressTransfer);
        $this->setCustomer($customerTransfer);

        return $customerTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\AddressTransfer $addressTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function updateAddressAndCustomerDefaultAddresses(AddressTransfer $addressTransfer): CustomerTransfer
    {
        $customerTransfer = parent::updateAddressAndCustomerDefaultAddresses($addressTransfer);
        $this->setCustomer($customerTransfer);

        return $customerTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function setCustomer(CustomerTransfer $customerTransfer): CustomerTransfer
    {
        parent::setCustomer($customerTransfer);

        $cartClient = $this->getFactory()->getCartClient();

        $quoteTransfer = $cartClient->getQuote();
        $quoteTransfer->setCustomer($customerTransfer);
        $cartClient->storeQuote($quoteTransfer);

        return $customerTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function getCustomer(): ?CustomerTransfer
    {
        $customerTransfer = parent::getCustomer();

        if ($customerTransfer && $customerTransfer->getIsDirty()) {
            $customerTransfer = $this->getCustomerById($customerTransfer->getIdCustomer());
            $this->setCustomer($customerTransfer);
        }

        return $customerTransfer;
    }

    /**
     * @return void
     */
    public function markCustomerAsDirty(): void
    {
        if ($this->isLoggedIn() !== false) {
            $this->getCustomer()->setIsDirty(true);
        }
    }
}
