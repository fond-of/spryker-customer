<?php

namespace FondOfSpryker\Zed\Customer\Business\Customer;

use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\Customer\Business\Customer\Customer as SprykerCustomer;

class Customer extends SprykerCustomer
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return bool
     */
    protected function sendRegistrationToken(CustomerTransfer $customerTransfer)
    {
        if ($this->customerConfig->isRegistrationMailEnabled() && $customerTransfer->getForcedRegister() !== true) {
            return parent::sendRegistrationToken($customerTransfer);
        }

        return true;
    }
}
