<?php

namespace FondOfSpryker\Zed\Customer\Business\Checkout;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use Spryker\Zed\Customer\Business\Checkout\CustomerOrderSaver as SprykerCustomerOrderSaver;
use Spryker\Zed\Customer\Business\Exception\CustomerNotFoundException;

class CustomerOrderSaver extends SprykerCustomerOrderSaver
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

        try {
            $customerFromCheckout = clone $quoteTransfer->getCustomer();
            $customerTransfer = $this->customer->get($quoteTransfer->getCustomer());
        } catch (CustomerNotFoundException $e) {
            $customerResponse = $this->customer->register($quoteTransfer->getCustomer());
            $customerTransfer = $customerResponse->getCustomerTransfer();
        }

        if (isset($customerFromCheckout) && $customerTransfer->getIdCustomer()) {
            $this->updateCurrentCustomerData($customerFromCheckout, $customerTransfer);
            $this->customer->update($customerTransfer);
        }

        $this->persistAddresses($quoteTransfer, $customerTransfer);
    }

    /**
     * @return void
     */
    protected function updateCurrentCustomerData(
        CustomerTransfer $checkoutCustomerTransfer,
        CustomerTransfer $databaseCustomerTransfer
    ): void {
        $databaseCustomerTransfer
            ->setFirstName($checkoutCustomerTransfer->getFirstName())
            ->setLastName($checkoutCustomerTransfer->getLastName())
            ->setSalutation($this->getSalutation($checkoutCustomerTransfer->getSalutation()))
            ->setGender($this->getGender($this->getGenderBySalutation($checkoutCustomerTransfer->getSalutation())));
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
