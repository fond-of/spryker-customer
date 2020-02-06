<?php
// SprykerUpgradeToDo Check if this class is still needed
namespace FondOfSpryker\Zed\Customer\Communication\Controller;

use FondOfSpryker\Shared\Newsletter\NewsletterConstants;
use Generated\Shared\Transfer\CustomerOverviewRequestTransfer;
use Generated\Shared\Transfer\CustomerOverviewResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\NewsletterSubscriberTransfer;
use Generated\Shared\Transfer\NewsletterSubscriptionRequestTransfer;
use Generated\Shared\Transfer\NewsletterTypeTransfer;
use Spryker\Zed\Customer\Communication\Controller\GatewayController as SprykerGatewayController;

/**
 * @method \FondOfSpryker\Zed\Customer\Communication\CustomerCommunicationFactory getFactory()
 */
class GatewayController extends SprykerGatewayController
{
    /**
     * @param \Generated\Shared\Transfer\CustomerOverviewRequestTransfer $overviewRequest
     *
     * @return \Generated\Shared\Transfer\CustomerOverviewResponseTransfer
     */
    public function getCustomerOverviewAction(CustomerOverviewRequestTransfer $overviewRequest)
    {
        $overviewResponseTransfer = new CustomerOverviewResponseTransfer();

        $orderListTransfer = $this->getOrderList($overviewRequest);
        $overviewResponseTransfer->setOrderList($orderListTransfer);

        $subscriptionResponseTransfer = $this->getIsSubscribed($overviewRequest->getCustomer());
        $overviewResponseTransfer->setIsSubscribed($subscriptionResponseTransfer->getSubscriptionResults()[0]->getIsSuccess());

        return $overviewResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerOverviewRequestTransfer $overviewRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OrderListTransfer
     */
    protected function getOrderList(CustomerOverviewRequestTransfer $overviewRequestTransfer)
    {
        $orderListTransfer = $this->getFactory()
            ->getSalesFacade()
            ->getCustomerOrders(
                $overviewRequestTransfer->getOrderList(),
                $overviewRequestTransfer->getCustomer()->getIdCustomer()
            );

        return $orderListTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\NewsletterSubscriptionResponseTransfer
     */
    protected function getIsSubscribed(CustomerTransfer $customerTransfer)
    {
        $subscriptionRequestTransfer = new NewsletterSubscriptionRequestTransfer();

        $subscriberTransfer = new NewsletterSubscriberTransfer();
        $subscriberTransfer->setFkCustomer($customerTransfer->getIdCustomer());
        $subscriberTransfer->setEmail($customerTransfer->getEmail());
        $subscriptionRequestTransfer->setNewsletterSubscriber($subscriberTransfer);

        $newsletterTypeTransfer = new NewsletterTypeTransfer();
        $newsletterTypeTransfer->setName(NewsletterConstants::EDITORIAL_NEWSLETTER);

        $subscriptionRequestTransfer->addSubscriptionType($newsletterTypeTransfer);

        $subscriptionResponseTransfer = $this->getFactory()
            ->getNewsletterFacade()
            ->checkSubscription($subscriptionRequestTransfer);

        return $subscriptionResponseTransfer;
    }
}
