<?php

namespace AlessandroDesign\FormBuilder\Traits;

use DOMElement;
use ReflectionClass;
use ReflectionProperty;
use UnitEnum;

trait SupportFormTrait
{
    protected function reflection(DOMElement &$element, bool $allowFalseValue = false): void
    {
        $myClass = new ReflectionClass($this);
        $protectedProperties = $myClass->getProperties(ReflectionProperty::IS_PROTECTED);

        foreach ($protectedProperties as $property) {
            $value = $property->getValue($this);
            if ($value !== null) {
                $value = $value instanceof UnitEnum ? $value->value : $value;
                if ($allowFalseValue) {
                    $element->setAttribute($property->getName(), $value);
                } elseif ($value) {
                    $element->setAttribute($property->getName(), $value);
                }
            }
        }
    }
}