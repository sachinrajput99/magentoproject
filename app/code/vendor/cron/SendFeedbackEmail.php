<?php
namespace Vendor\FeedbackEmail\Cron;

use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Sales\Api\OrderRepositoryInterface;
use Psr\Log\LoggerInterface;

class SendFeedbackEmail
{
    protected $transportBuilder;
    protected $orderRepository;
    protected $logger;

    public function __construct(
        TransportBuilder $transportBuilder,
        OrderRepositoryInterface $orderRepository,
        LoggerInterface $logger
    ) {
        $this->transportBuilder = $transportBuilder;
        $this->orderRepository = $orderRepository;
        $this->logger = $logger;
    }

    public function execute()
    {
        try {
            $date = new \DateTime();
            $date->modify('-7 days');
            $searchCriteria = $this->orderRepository->getList(
                $this->orderRepository->create()->addFieldToFilter('created_at', ['gteq' => $date->format('Y-m-d H:i:s')])
                ->addFieldToFilter('status', 'complete')
            );

            foreach ($searchCriteria->getItems() as $order) {
                $this->sendEmail($order);
            }
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }

        return $this;
    }

    protected function sendEmail($order)
    {
        try {
            $customerEmail = $order->getCustomerEmail();
            $customerName = $order->getCustomerFirstname() . ' ' . $order->getCustomerLastname();

            $transport = $this->transportBuilder
                ->setTemplateIdentifier('feedback_request_email_template') // Adjust if necessary
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => $order->getStoreId()
                    ]
                )
                ->setTemplateVars(['order' => $order, 'customer' => $order->getCustomer()])
                ->setFrom('general')
                ->addTo($customerEmail, $customerName)
                ->getTransport();

            $transport->sendMessage();
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }
}
