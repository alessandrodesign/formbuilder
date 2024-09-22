<?php

namespace AlessandroDesign\FormBuilder\Entities;

use AlessandroDesign\FormBuilder\Traits\HTMLGlobalAttributesTrait;
use AlessandroDesign\FormBuilder\Traits\SupportFormTrait;
use DOMDocument;
use DOMElement;
use DOMException;
use ReflectionClass;
use ReflectionProperty;
use UnitEnum;

class Option
{
    use HTMLGlobalAttributesTrait, SupportFormTrait;

    /**
     * @param string|null $text
     * @param string|null $value Especifica o valor a ser enviado para um servidor
     * @param string|bool|null $selected Especifica que uma opção deve ser pré-selecionada quando a página for carregada
     * @param string|bool|null $disabled Especifica que uma opção deve ser desabilitada
     * @param string|null $label Especifica um rótulo mais curto para uma opção
     */
    public function __construct(
        protected string|null      $text = null,
        protected string|null      $value = null,
        protected string|bool|null $selected = null,
        protected string|bool|null $disabled = null,
        protected string|null      $label = null,
    )
    {
    }

    /**
     * @param string|null $text
     * @param string|null $value Especifica o valor a ser enviado para um servidor
     * @param string|bool|null $selected Especifica que uma opção deve ser pré-selecionada quando a página for carregada
     * @param string|bool|null $disabled Especifica que uma opção deve ser desabilitada
     * @param string|null $label Especifica um rótulo mais curto para uma opção
     * @return $this
     */
    public static function create(
        string|null      $text = null,
        string|null      $value = null,
        string|bool|null $selected = null,
        string|bool|null $disabled = null,
        string|null      $label = null,
    ): self
    {
        return new self(
            $text,
            $value,
            $selected,
            $disabled,
            $label
        );
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text):self
    {
        $this->text = $text;
        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value):self
    {
        $this->value = $value;
        return $this;
    }

    public function getSelected(): bool|string|null
    {
        return $this->selected;
    }

    public function setSelected(bool|string|null $selected):self
    {
        $this->selected = $selected;
        return $this;
    }

    public function getDisabled(): bool|string|null
    {
        return $this->disabled;
    }

    public function setDisabled(bool|string|null $disabled):self
    {
        $this->disabled = $disabled;
        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label):self
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @param DOMDocument $dom
     * @param string $tagName
     * @return DOMElement
     * @throws DOMException
     */
    public function element(DOMDocument &$dom, string $tagName): DOMElement
    {
        $element = $dom->createElement($tagName);
        $myClass = new ReflectionClass($this);
        $protectedProperties = $myClass->getProperties(ReflectionProperty::IS_PROTECTED);
        foreach ($protectedProperties as $property) {
            $value = $property->getValue($this);
            if ($property->getName() === 'text') {
                $element->appendChild($dom->createTextNode($value));
            } elseif ($value !== null) {
                $value = $value instanceof UnitEnum ? $value->value : $value;
                $element->setAttribute($property->getName(), $value);
            }
        }

        return $element;
    }
}