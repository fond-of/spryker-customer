<?php

namespace FondOfSpryker\Zed\Customer\Business\Checkout;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use Spryker\Zed\Customer\Business\Checkout\CustomerOrderSaver as SprykerCustomerOrderSaver;
use Spryker\Zed\Customer\Business\Exception\CustomerNotFoundException;

class CustomerOrderSaver extends SprykerCustomerOrderSaver
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     *
     * @return void
     */
    public function saveOrderCustomer(QuoteTransfer $quoteTransfer, SaveOrderTransfer $saveOrderTransfer)
    {
        $this->assertCustomerRequirements($quoteTransfer);

        try {
            $customerTransfer = $this->customer->get($quoteTransfer->getCustomer());
        } catch (CustomerNotFoundException $e) {
            $customerResponse = $this->customer->register($quoteTransfer->getCustomer());
            $customerTransfer = $customerResponse->getCustomerTransfer();
        }

        if ($customerTransfer->getIdCustomer()) {
            $this->customer->update($customerTransfer);
            $this->persistAddresses($quoteTransfer, $customerTransfer);
        }
    }
}
