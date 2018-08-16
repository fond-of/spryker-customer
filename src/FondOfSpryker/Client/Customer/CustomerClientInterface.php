<?php

namespace FondOfSpryker\Client\Customer;

use Generated\Shared\Transfer\CustomerOverviewRequestTransfer;
use Spryker\Client\Customer\CustomerClientInterface as SprykerCustomerClientInterface;

interface CustomerClientInterface extends SprykerCustomerClientInterface
{
    /**
     * Specification:
     * - Loads information about e.g. orders and newsletter subscriptions.
     * - Returns a CustomerOverviewResponseTransfer.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerOverviewRequestTransfer $overviewRequest
     *
     * @return \Generated\Shared\Transfer\CustomerOverviewResponseTransfer
     */
    public function getCustomerOverview(CustomerOverviewRequestTransfer $overviewRequest);

    /**
     * Specification:
     * - Marks a customer as dirty.
     * - Customer will be reloaded from Zed with next request.
     *
     * @api
     *
     * @return void
     */
    public function markCustomerAsDirty();
}
