<?php

namespace AlessandroDesign\FormBuilder\Traits;

use DOMDocument;
use DOMElement;
use DOMException;
use ReflectionClass;
use ReflectionProperty;
use UnitEnum;

trait SupportElementTrait
{
    /**
     * @throws DOMException
     */
    public function element(DOMDocument &$dom, string $tagName): DOMElement
    {
        $element = $dom->createElement($tagName);
        $myClass = new ReflectionClass($this);
        $protectedProperties = $myClass->getProperties(ReflectionProperty::IS_PROTECTED);

        foreach ($protectedProperties as $property) {
            $value = $property->getValue($this);
            if ($value !== null) {
                $value = $value instanceof UnitEnum ? $value->value : $value;
                $element->setAttribute($property->getName(), $value);
            }
        }

        return $element;
    }
}