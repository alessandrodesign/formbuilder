<?php

namespace AlessandroDesign\FormBuilder\Entities;

use AlessandroDesign\FormBuilder\Enums\ButtonTypeEnum;
use AlessandroDesign\FormBuilder\Enums\EnctypeEnum;
use AlessandroDesign\FormBuilder\Enums\MethodEnum;
use AlessandroDesign\FormBuilder\Enums\PopovertargetactionEnum;
use AlessandroDesign\FormBuilder\Enums\TargetEnum;
use AlessandroDesign\FormBuilder\Traits\HTMLGlobalAttributesTrait;
use AlessandroDesign\FormBuilder\Traits\SupportFormTrait;
use DOMDocument;
use DOMElement;
use DOMException;
use ReflectionClass;
use ReflectionProperty;
use UnitEnum;

class Button
{
    use HTMLGlobalAttributesTrait, SupportFormTrait;

    /**
     * @param string|null $text
     * @param string|null $name Especifica um nome para o botão
     * @param ButtonTypeEnum|string|null $type Especifica o tipo de botão
     * @param string|bool|null $disabled Especifica que um botão deve ser desabilitado
     * @param string|null $value Especifica um valor inicial para o botão
     * @param string|null $autofocus Especifica que um botão deve receber foco automaticamente quando a página for carregada
     * @param string|null $form Especifica a qual formulário o botão pertence
     * @param string|null $formaction Especifica para onde enviar os dados do formulário quando um formulário é enviado. Somente para type="enviar"
     * @param EnctypeEnum|string|null $formenctype Especifica como os dados do formulário devem ser codificados antes de serem enviados para um servidor. Somente para type="enviar"
     * @param MethodEnum|string|null $formmethod Especifica como enviar os dados do formulário (qual método HTTP usar). Somente para type="enviar"
     * @param string|null $formnovalidate Especifica que os dados do formulário não devem ser validados no envio. Somente para type="enviar"
     * @param TargetEnum|string|null $formtarget Especifica onde exibir a resposta após enviar o formulário. Somente para type="enviar"
     * @param string|null $popovertarget Especifica qual elemento popover invocar
     * @param PopovertargetactionEnum|string|null $popovertargetaction Especifica o que acontece com o elemento popover quando o botão é clicado
     */
    public function __construct(
        protected string|null                         $text = null,
        protected string|null                         $name = null,
        protected ButtonTypeEnum|string|null          $type = ButtonTypeEnum::SUBMIT,
        protected string|bool|null                    $disabled = null,
        protected string|null                         $value = null,
        protected string|null                         $autofocus = null,
        protected string|null                         $form = null,
        protected string|null                         $formaction = null,
        protected EnctypeEnum|string|null             $formenctype = null,
        protected MethodEnum|string|null              $formmethod = null,
        protected string|null                         $formnovalidate = null,
        protected TargetEnum|string|null              $formtarget = null,
        protected string|null                         $popovertarget = null,
        protected PopovertargetactionEnum|string|null $popovertargetaction = null,
    )
    {
    }

    /**
     * @param string|null $text
     * @param string|null $name Especifica um nome para o botão
     * @param ButtonTypeEnum|string|null $type Especifica o tipo de botão
     * @param string|bool|null $disabled Especifica que um botão deve ser desabilitado
     * @param string|null $value Especifica um valor inicial para o botão
     * @param string|null $autofocus Especifica que um botão deve receber foco automaticamente quando a página for carregada
     * @param string|null $form Especifica a qual formulário o botão pertence
     * @param string|null $formaction Especifica para onde enviar os dados do formulário quando um formulário é enviado. Somente para type="enviar"
     * @param EnctypeEnum|string|null $formenctype Especifica como os dados do formulário devem ser codificados antes de serem enviados para um servidor. Somente para type="enviar"
     * @param MethodEnum|string|null $formmethod Especifica como enviar os dados do formulário (qual método HTTP usar). Somente para type="enviar"
     * @param string|null $formnovalidate Especifica que os dados do formulário não devem ser validados no envio. Somente para type="enviar"
     * @param TargetEnum|string|null $formtarget Especifica onde exibir a resposta após enviar o formulário. Somente para type="enviar"
     * @param string|null $popovertarget Especifica qual elemento popover invocar
     * @param PopovertargetactionEnum|string|null $popovertargetaction Especifica o que acontece com o elemento popover quando o botão é clicado
     * @return Button
     */
    public static function create(
        string|null                         $text = null,
        string|null                         $name = null,
        ButtonTypeEnum|string|null          $type = ButtonTypeEnum::SUBMIT,
        string|bool|null                    $disabled = null,
        string|null                         $value = null,
        string|null                         $autofocus = null,
        string|null                         $form = null,
        string|null                         $formaction = null,
        EnctypeEnum|string|null             $formenctype = null,
        MethodEnum|string|null              $formmethod = null,
        string|null                         $formnovalidate = null,
        TargetEnum|string|null              $formtarget = null,
        string|null                         $popovertarget = null,
        PopovertargetactionEnum|string|null $popovertargetaction = null
    ): self
    {
        return new self(
            $text,
            $name,
            $type,
            $disabled,
            $value,
            $autofocus,
            $form,
            $formaction,
            $formenctype,
            $formmethod,
            $formnovalidate,
            $formtarget,
            $popovertarget,
            $popovertargetaction
        );
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
            } elseif ($value !== null && $value !== false) {
                $value = $value instanceof UnitEnum ? $value->value : $value;
                $element->setAttribute($property->getName(), $value);
            }
        }

        return $element;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getType(): ButtonTypeEnum|string|null
    {
        return $this->type;
    }

    public function setType(ButtonTypeEnum|string|null $type): self
    {
        $this->type = $type;
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

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;
        return $this;
    }

    public function getAutofocus(): ?string
    {
        return $this->autofocus;
    }

    public function setAutofocus(?string $autofocus): self
    {
        $this->autofocus = $autofocus;
        return $this;
    }

    public function getForm(): ?string
    {
        return $this->form;
    }

    public function setForm(?string $form): self
    {
        $this->form = $form;
        return $this;
    }

    public function getFormaction(): ?string
    {
        return $this->formaction;
    }

    public function setFormaction(?string $formaction): self
    {
        $this->formaction = $formaction;
        return $this;
    }

    public function getFormenctype(): EnctypeEnum|string|null
    {
        return $this->formenctype;
    }

    public function setFormenctype(EnctypeEnum|string|null $formenctype): self
    {
        $this->formenctype = $formenctype;
        return $this;
    }

    public function getFormmethod(): string|MethodEnum|null
    {
        return $this->formmethod;
    }

    public function setFormmethod(string|MethodEnum|null $formmethod): self
    {
        $this->formmethod = $formmethod;
        return $this;
    }

    public function getFormnovalidate(): ?string
    {
        return $this->formnovalidate;
    }

    public function setFormnovalidate(?string $formnovalidate): self
    {
        $this->formnovalidate = $formnovalidate;
        return $this;
    }

    public function getFormtarget(): string|TargetEnum|null
    {
        return $this->formtarget;
    }

    public function setFormtarget(string|TargetEnum|null $formtarget): self
    {
        $this->formtarget = $formtarget;
        return $this;
    }

    public function getPopovertarget(): ?string
    {
        return $this->popovertarget;
    }

    public function setPopovertarget(?string $popovertarget): self
    {
        $this->popovertarget = $popovertarget;
        return $this;
    }

    public function getPopovertargetaction(): PopovertargetactionEnum|string|null
    {
        return $this->popovertargetaction;
    }

    public function setPopovertargetaction(PopovertargetactionEnum|string|null $popovertargetaction): self
    {
        $this->popovertargetaction = $popovertargetaction;
        return $this;
    }
}