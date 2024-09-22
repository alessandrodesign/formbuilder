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

class Label
{
    use HTMLGlobalAttributesTrait, SupportFormTrait;

    /**
     * @param string $text
     * @param string|null $for Especifica o id do elemento do formulário ao qual o rótulo deve estar vinculado
     * @param string|null $form Especifica a qual formulário o rótulo pertence
     */
    public function __construct(
        protected string      $text,
        protected string|null $for = null,
        protected string|null $form = null,
    )
    {
    }

    /**
     * @param string $text
     * @param string|null $for Especifica o id do elemento do formulário ao qual o rótulo deve estar vinculado
     * @param string|null $form Especifica a qual formulário o rótulo pertence
     * @return Label
     */
    public static function create(string $text, string|null $for = null, string|null $form = null): self
    {
        return new self($text, $for, $form);
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text):self
    {
        $this->text = $text;
        return $this;
    }

    public function getFor(): ?string
    {
        return $this->for;
    }

    public function setFor(?string $for):self
    {
        $this->for = $for;
        return $this;
    }

    public function getForm(): ?string
    {
        return $this->form;
    }

    public function setForm(?string $form):self
    {
        $this->form = $form;
        return $this;
    }

    /**
     * @param DOMDocument $dom
     * @param string $tagName
     * @param bool $existsAnotherLabel
     * @return DOMElement
     * @throws DOMException
     */
    public function element(DOMDocument &$dom, string $tagName, bool $existsAnotherLabel = false): DOMElement
    {
        if ($existsAnotherLabel) {
            $this->for = $this->getFor() . "_label";
        }
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