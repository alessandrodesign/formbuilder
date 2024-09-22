<?php

namespace AlessandroDesign\FormBuilder\Entities;

use AlessandroDesign\FormBuilder\Enums\TagEnum;
use AlessandroDesign\FormBuilder\Traits\HTMLGlobalAttributesTrait;
use AlessandroDesign\FormBuilder\Traits\SupportFormTrait;
use DOMDocument;
use DOMElement;
use DOMException;
use ReflectionClass;
use ReflectionProperty;
use UnitEnum;

class OptGroup
{
    use HTMLGlobalAttributesTrait, SupportFormTrait;

    /**
     * @param string|null $label Especifica um rótulo para um grupo de opções
     * @param string|bool|null $disabled Especifica que um grupo de opções deve ser desabilitado
     * @param Option[]|null $options
     */
    public function __construct(
        protected string|null      $label = null,
        protected string|bool|null $disabled = null,
        protected array|null       $options = null
    )
    {
    }

    /**
     * @param string|null $label Especifica um rótulo para um grupo de opções
     * @param string|bool|null $disabled Especifica que um grupo de opções deve ser desabilitado
     * @param Option[]|null $options
     * @return OptGroup
     */
    public static function create(
        string|null      $label = null,
        string|bool|null $disabled = null,
        array|null       $options = null
    ): self
    {
        return new self($label, $disabled, $options);
    }

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
                if (is_array($value) || is_object($value)) {
                    foreach ($value as $subValue) {
                        $element->appendChild($subValue->element($dom, TagEnum::Option->value));
                    }
                } else {
                    $value = $value instanceof UnitEnum ? $value->value : $value;
                    $element->setAttribute($property->getName(), $value);
                }
            }
        }

        return $element;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): self
    {
        $this->label = $label;
        return $this;
    }

    public function getDisabled(): bool|string|null
    {
        return $this->disabled;
    }

    public function setDisabled(bool|string|null $disabled): self
    {
        $this->disabled = $disabled;
        return $this;
    }

    public function getOptions(): ?array
    {
        return $this->options;
    }

    public function setOptions(?array $options): self
    {
        $this->options = $options;
        return $this;
    }
}