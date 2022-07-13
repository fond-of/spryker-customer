<?php

namespace FondOfSpryker\Zed\Customer;

use FondOfSpryker\Shared\Customer\CustomerConstants;
use Generated\Shared\Transfer\SequenceNumberSettingsTransfer;
use Spryker\Shared\SequenceNumber\SequenceNumberConstants;
use Spryker\Zed\Customer\CustomerConfig as SprykerCustomerConfig;

class CustomerConfig extends SprykerCustomerConfig
{
    /**
     * @api
     *
     * @param string|null $storeName
     *
     * @return \Generated\Shared\Transfer\SequenceNumberSettingsTransfer
     */
    public function getCustomerReferenceDefaults(?string $storeName = null)
    {
        //ToDo: 2022 Spryker Upgrade evaluate => this function could be dropped since the store will be set default as ref
        if (!$storeName) {
            $storeName = $this->getStoreName();
        }

        $sequenceNumberSettingsTransfer = new SequenceNumberSettingsTransfer();

        $sequenceNumberSettingsTransfer->setName(CustomerConstants::NAME_CUSTOMER_REFERENCE);

        $sequenceNumberPrefixParts = [];
        $sequenceNumberPrefixParts[] = $this->get(CustomerConstants::CUSTOMER_REFERENCE_PREFIX, $storeName);

        if ($this->get(SequenceNumberConstants::ENVIRONMENT_PREFIX) !== '') {
            $sequenceNumberPrefixParts[] = $this->get(SequenceNumberConstants::ENVIRONMENT_PREFIX);
        }

        $prefix = implode($this->getUniqueIdentifierSeparator(), $sequenceNumberPrefixParts) . $this->getUniqueIdentifierSeparator();

        $sequenceNumberSettingsTransfer->setPrefix($prefix);

        if ($offset = $this->get(CustomerConstants::CUSTOMER_REFERENCE_OFFSET)) {
            $sequenceNumberSettingsTransfer->setOffset($this->get(CustomerConstants::CUSTOMER_REFERENCE_OFFSET));
        }

        return $sequenceNumberSettingsTransfer;
    }

    /**
     * @return bool
     */
    public function isRegistrationMailEnabled(): bool
    {
        return $this->get(CustomerConstants::CUSTOMER_REGISTRATION_MAIL_ENABLED, true);
    }
}
