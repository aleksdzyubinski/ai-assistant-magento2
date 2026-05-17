<?php
declare(strict_types=1);

namespace Comerix\AiAssistant\Model\ViewedProducts;

use Magento\Reports\Model\ResourceModel\Product\Index\Viewed\CollectionFactory;

class Customer
{
    /**
     * @param CollectionFactory $viewedCollectionFactory
     */
    public function __construct(
        private readonly CollectionFactory $viewedCollectionFactory
    ) {}

    /**
     * @param int $customerId
     * @param int $limit
     * @return array
     */
    public function getList(int $customerId, int $limit = 5): array
    {
        if (!$customerId) {
            return [];
        }

        $collection = $this->viewedCollectionFactory->create()
            ->addCustomerIdFilter($customerId)
            ->addAttributeToSelect(['name', 'sku', 'price', 'url_key'])
            ->setPageSize($limit)
            ->setCurPage(1);

        $result = [];
        foreach ($collection as $item) {
            $result[] = [
                'sku' => $item->getSku(),
                'name' => $item->getName(),
                'price' => (float) $item->getPrice(),
            ];
        }

        return $result;
    }
}
