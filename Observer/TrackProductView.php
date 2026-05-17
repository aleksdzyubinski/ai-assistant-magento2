<?php
declare(strict_types=1);

namespace Comerix\AiAssistant\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Comerix\AiAssistant\Model\ViewedProducts\Guest as ViewedProductsGuest;

class TrackProductView implements ObserverInterface
{
    /**
     * @param ViewedProductsGuest $viewedProductsGuest
     */
    public function __construct(
        private readonly ViewedProductsGuest $viewedProductsGuest
    ) {}

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        /** @var \Magento\Catalog\Model\Product $product */
        $product = $observer->getEvent()->getProduct();
        if (!$product || !$product->getId()) {
            return;
        }

        $data = [
            'sku' => $product->getSku(),
            'name' => $product->getName(),
            'price' => $product->getFinalPrice(),
        ];

        $this->viewedProductsGuest->saveData($data);
    }
}
