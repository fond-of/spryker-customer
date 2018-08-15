<?php

namespace FondOfSpryker\Zed\Customer\Business;

use Generated\Shared\Transfer\CustomerTransfer;
use FondOfSpryker\Zed\Customer\Business\Customer\CustomerInterface;
use Spryker\Zed\Customer\Business\Customer\Customer as SprykerCustomer;

class Customer extends SprykerCustomer implements CustomerInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerResponseTransfer
     */
    public function confirmOrder(CustomerTransfer $customerTransfer)
    {
        $customerResponseTransfer = $this->add($customerTransfer);

        if (!$customerResponseTransfer->getIsSuccess()) {
            return $customerResponseTransfer;
        }

        $this->sendRegistrationToken($customerTransfer);

        if ($customerTransfer->getSendPasswordToken()) {
            $this->sendPasswordRestoreMail($customerTransfer);
        }

        return $customerResponseTransfer;
    }
}
