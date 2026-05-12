<?php

declare(strict_types=1);

namespace MageCloud\AiAssistant\Controller\Adminhtml\Reindex;

use MageCloud\AiAssistant\Service\Config;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\HTTP\Client\Curl;
use Psr\Log\LoggerInterface;

class Products extends Action
{
    public const ADMIN_RESOURCE = 'MageCloud_AiAssistant::config';

    /**
     * @param Context $context
     * @param Config $config
     * @param Curl $curl
     * @param JsonFactory $jsonFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        private readonly Config $config,
        private readonly Curl $curl,
        private readonly JsonFactory $jsonFactory,
        private readonly LoggerInterface $logger
    ) {
        parent::__construct($context);
    }

    /**
     * @return Json
     */
    public function execute(): Json
    {
        $result = $this->jsonFactory->create();

        $serverUrl = $this->config->getChatServerUrl();
        $secret = $this->config->getReindexSecret();

        if (!$serverUrl || !$secret) {
            return $result->setData(['success' => false, 'message' => 'Chat Server URL or Reindex Secret is not configured.']);
        }

        try {
            $this->curl->addHeader('Content-Type', 'application/json');
            $this->curl->addHeader('Authorization', 'Bearer ' . $secret);
            $this->curl->post(
                $serverUrl . '/api/reindex-all',
                (string) json_encode(['secret' => $secret])
            );

            $status = $this->curl->getStatus();

            if ($status < 200 || $status >= 300) {
                $this->logger->warning('MageCloud_AiAssistant: reindex-all request failed.', ['status' => $status]);
                return $result->setData(['success' => false, 'message' => sprintf('Request failed with status %d.', $status)]);
            }

            return $result->setData(['success' => true, 'message' => 'Reindex completed successfully.']);
        } catch (\Exception $e) {
            $this->logger->error('MageCloud_AiAssistant: reindex-all exception: ' . $e->getMessage());
            return $result->setData(['success' => false, 'message' => 'An error occurred. Please check the logs.']);
        }
    }
}