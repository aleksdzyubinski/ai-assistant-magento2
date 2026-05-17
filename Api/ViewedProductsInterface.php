<?php

declare(strict_types=1);

namespace Comerix\AiAssistant\Api;

interface ViewedProductsInterface
{
    /**
     * Returns recently viewed products for the given customer or the current session.
     *
     * @param int|null $customerId Explicit customer ID for API callers; null falls back to session.
     * @return mixed[]
     */
    public function get(?int $customerId = null): array;
}
