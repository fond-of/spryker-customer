<?php

namespace FondOfSpryker\Shared\Customer;

use Spryker\Shared\Customer\CustomerConstants as BaseCustomerConstants;

interface CustomerConstants extends BaseCustomerConstants
{
    const CUSTOMER_REFERENCE_PREFIX = 'CUSTOMER_REFERENCE_PREFIX';
    const CUSTOMER_REFERENCE_OFFSET = 'CUSTOMER_REFERENCE_OFFSET';
    const COUNTRIES_IN_EU = [
        "AT", "BE", "BG", "CY", "CZ", "DE", "DK", "EE", "ES", "FI", "FR", "GB", "GR", "HR",
        "HU", "IE", "IT", "LT", "LU", "LV", "MT", "NL", "PL", "PT", "RO", "SE", "SI", "SK"
    ];
}