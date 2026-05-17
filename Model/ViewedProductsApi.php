<?php
declare(strict_types=1);

namespace Comerix\AiAssistant\Model;

use Comerix\AiAssistant\Api\ViewedProductsInterface;

class ViewedProductsApi implements ViewedProductsInterface
{
    /**
     * @param ViewedProducts $viewedProducts
     */
    public function __construct(
        private readonly ViewedProducts $viewedProducts
    ) {}

    /**
     * @param int|null $customerId
     * @return mixed[]
     */
    public function get(?int $customerId = null): array
    {
        return $this->viewedProducts->getViewedProducts($customerId);
    }
}
