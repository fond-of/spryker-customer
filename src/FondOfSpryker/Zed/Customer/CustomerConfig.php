<?php

namespace FondOfSpryker\Zed\Customer;

use FondOfSpryker\Shared\Customer\CustomerConstants;
use Generated\Shared\Transfer\SequenceNumberSettingsTransfer;
use Spryker\Shared\Kernel\Store;
use Spryker\Shared\SequenceNumber\SequenceNumberConstants;
use Spryker\Zed\Customer\CustomerConfig as SprykerCustomerConfig;

class CustomerConfig extends SprykerCustomerConfig
{
    /**
     * @return \Generated\Shared\Transfer\SequenceNumberSettingsTransfer
     */
    public function getCustomerReferenceDefaults()
    {
        $sequenceNumberSettingsTransfer = new SequenceNumberSettingsTransfer();

        $sequenceNumberSettingsTransfer->setName(CustomerConstants::NAME_CUSTOMER_REFERENCE);

        $sequenceNumberPrefixParts = [];
        $sequenceNumberPrefixParts[] = $this->get(CustomerConstants::CUSTOMER_REFERENCE_PREFIX, Store::getInstance()->getStoreName());

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
}
