<?php

namespace FondOfSpryker\Zed\Customer\Business\Checkout;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use Spryker\Zed\Customer\Business\Checkout\CustomerOrderSaverWithMultiShippingAddress as SprykerCustomerOrderSaverWithMultiShippingAddress;

/**
 * @method \Spryker\Zed\Customer\Business\CustomerBusinessFactory getFactory()
 */
class CustomerOrderSaverWithMultiShippingAddress extends SprykerCustomerOrderSaverWithMultiShippingAddress
{
    public const GENDER_MAPPING = [
        'male' => 'Male',
        'female' => 'Female',
        'unknown' => null,
        'diverse' => 'Diverse',
    ];

    public const SALUTATION_TO_GENDER_MAPPING = [
        'Mr' => 'male',
        'Ms' => 'female',
        'Mrs' => 'female',
        'Dr' => 'unknown',
        'Diverse' => 'diverse',
    ];

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     *
     * @return void
     */
    public function saveOrderCustomer(QuoteTransfer $quoteTransfer, SaveOrderTransfer $saveOrderTransfer)
    {
        $this->assertCustomerRequirements($quoteTransfer);

        $customerTransfer = $quoteTransfer->getCustomer();

        if ($customerTransfer->getIsGuest() === true) {
            return;
        }

        $customerTransfer = $this->updateCurrentCustomerData($customerTransfer);

        if ($this->isNewCustomer($customerTransfer)) {
            $this->createNewCustomer($quoteTransfer, $customerTransfer);
        } else {
            $this->customer->update($customerTransfer);
        }

        $this->persistAddresses($quoteTransfer, $customerTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    protected function updateCurrentCustomerData(CustomerTransfer $customerTransfer): CustomerTransfer
    {
        $customerTransfer
            ->setSalutation($this->getSalutation($customerTransfer->getSalutation()))
            ->setGender($this->getGender($this->getGenderBySalutation($customerTransfer->getSalutation())));

        return $customerTransfer;
    }

    /**
     * @param string|null $salutation
     *
     * @return string|null
     */
    protected function getGenderBySalutation(?string $salutation): ?string
    {
        if (array_key_exists(ucfirst(strtolower($salutation)), self::SALUTATION_TO_GENDER_MAPPING)) {
            return self::SALUTATION_TO_GENDER_MAPPING[ucfirst(strtolower($salutation))];
        }

        return null;
    }

    /**
     * @param string|null $gender
     *
     * @return string|null
     */
    protected function getGender(?string $gender): ?string
    {
        if (array_key_exists(strtolower($gender), self::GENDER_MAPPING)) {
            return self::GENDER_MAPPING[strtolower($gender)];
        }

        return null;
    }

    /**
     * @param string|null $salutation
     *
     * @return string|null
     */
    protected function getSalutation(?string $salutation): ?string
    {
        $salutation = ucfirst(strtolower($salutation));
        if (array_key_exists($salutation, self::SALUTATION_TO_GENDER_MAPPING)) {
            return $salutation;
        }

        return null;
    }
}
