<?php

declare(strict_types=1);

namespace Comerix\AiAssistant\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Position implements OptionSourceInterface
{
    public const RIGHT = 'right';
    public const LEFT = 'left';

    /**
     * Position config options
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => self::RIGHT, 'label' => __('Right')],
            ['value' => self::LEFT, 'label' => __('Left')],
        ];
    }
}
