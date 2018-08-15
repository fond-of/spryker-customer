<?php

namespace FondOfSpryker\Zed\Customer;

use Generated\Shared\Transfer\SequenceNumberSettingsTransfer;
use FondOfSpryker\Shared\Customer\CustomerConstants;
use Spryker\Zed\Customer\CustomerConfig as BaseCustomerConfig;

class CustomerConfig extends BaseCustomerConfig
{

    /**
     * @return \Generated\Shared\Transfer\SequenceNumberSettingsTransfer
     */
    public function getCustomerReferenceDefaults()
    {
        $sequenceNumberSettingsTransfer = new SequenceNumberSettingsTransfer();

        $sequenceNumberSettingsTransfer->setName(CustomerConstants::NAME_CUSTOMER_REFERENCE);

        $sequenceNumberPrefixParts = [];
        $sequenceNumberPrefixParts[] = $this->get(CustomerConstants::CUSTOMER_REFERENCE_PREFIX);
        $prefix = implode($this->getUniqueIdentifierSeparator(), $sequenceNumberPrefixParts) . $this->getUniqueIdentifierSeparator();
        $sequenceNumberSettingsTransfer->setPrefix($prefix);
        $sequenceNumberSettingsTransfer->setOffset($this->get(CustomerConstants::CUSTOMER_REFERENCE_OFFSET));

        return $sequenceNumberSettingsTransfer;
    }

    /*
     * {@inheritdoc}
     *
     * @return array
     */
    /*public function getCustomerDetailExternalBlocksUrls()
    {
        return [
            'sales' => '/sales/customer/customer-orders',
            'notes' => '/customer-note-gui/index/index',
        ] + parent::getCustomerDetailExternalBlocksUrls();
    }*/
}
