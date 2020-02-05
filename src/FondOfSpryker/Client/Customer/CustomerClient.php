<?php

namespace FondOfSpryker\Client\Customer;

use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\CustomerOverviewRequestTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Client\Customer\CustomerClient as SprykerCustomerClient;

/**
 * @method \FondOfSpryker\Client\Customer\CustomerFactory getFactory()
 */
class CustomerClient extends SprykerCustomerClient implements CustomerClientInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerOverviewRequestTransfer $overviewRequest
     *
     * @return \Generated\Shared\Transfer\CustomerOverviewResponseTransfer
     */
    public function getCustomerOverview(CustomerOverviewRequestTransfer $overviewRequest)
    {
        return $this->getFactory()
            ->createZedCustomerStub()
            ->getCustomerOverview($overviewRequest);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\AddressTransfer $addressTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function createAddressAndUpdateCustomerDefaultAddresses(AddressTransfer $addressTransfer)
    {
        $customerTransfer = parent::createAddressAndUpdateCustomerDefaultAddresses($addressTransfer);
        $this->setCustomer($customerTransfer);

        return $customerTransfer;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\AddressTransfer $addressTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function updateAddressAndCustomerDefaultAddresses(AddressTransfer $addressTransfer)
    {
        $customerTransfer = parent::updateAddressAndCustomerDefaultAddresses($addressTransfer);
        $this->setCustomer($customerTransfer);

        return $customerTransfer;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function setCustomer(CustomerTransfer $customerTransfer)
    {
        parent::setCustomer($customerTransfer);
        $cartClient = $this->getFactory()->getCartClient();
        $quoteTransfer = $cartClient->getQuote();
        $quoteTransfer->setCustomer($customerTransfer);
        $cartClient->storeQuote($quoteTransfer);

        return $customerTransfer;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function getCustomer()
    {
        $customerTransfer = parent::getCustomer();
        if ($customerTransfer && $customerTransfer->getIsDirty()) {
            $customerTransfer = $this->getCustomerById($customerTransfer->getIdCustomer());
            $this->setCustomer($customerTransfer);
        }

        return $customerTransfer;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return void
     */
    public function markCustomerAsDirty()
    {
        if ($this->isLoggedIn() !== false) {
            $this->getCustomer()->setIsDirty(true);
        }
    }
}
