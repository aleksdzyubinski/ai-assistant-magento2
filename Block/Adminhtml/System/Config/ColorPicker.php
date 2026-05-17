<?php

declare(strict_types=1);

namespace Comerix\AiAssistant\Block\Adminhtml\System\Config;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class ColorPicker extends Field
{
    /**
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        $value = $element->getEscapedValue() ?: '#000000';
        $htmlId = $element->getHtmlId();
        $name = $element->getName();

        return sprintf(
            '<input type="color" id="%s" name="%s" value="%s"'
            . ' onchange="document.getElementById(\'%s_hex\').value = this.value"/>'
            . '<input type="text" id="%s_hex" value="%s"'
            . ' style="width:80px;margin-left:8px;vertical-align:middle;"'
            . ' oninput="var v=this.value;if(/^#[0-9a-fA-F]{6}$/.test(v)){document.getElementById(\'%s\').value=v;}"/>',
            $htmlId, $name, $value, $htmlId,
            $htmlId, $value,
            $htmlId
        );
    }
}