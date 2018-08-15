<?php

namespace FondOfSpryker\Zed\Customer\Business\Customer;

use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\Customer\Business\Customer\CustomerInterface as SprykerCustomerInterface;

interface CustomerInterface extends SprykerCustomerInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerResponseTransfer
     */
    public function confirmOrder(CustomerTransfer $customerTransfer);
}
