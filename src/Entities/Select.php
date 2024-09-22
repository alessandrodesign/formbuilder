<?php

namespace AlessandroDesign\FormBuilder\Entities;

use AlessandroDesign\FormBuilder\Traits\HTMLGlobalAttributesTrait;
use AlessandroDesign\FormBuilder\Traits\SupportElementTrait;
use AlessandroDesign\FormBuilder\Traits\SupportFormTrait;

class Select
{
    use HTMLGlobalAttributesTrait, SupportFormTrait, SupportElementTrait;

    /**
     * @param string|null $name Define um nome para a lista suspensa
     * @param string|bool|null $required Especifica que o usuário deve selecionar um valor antes de enviar o formulário
     * @param string|bool|null $disabled Especifica que uma lista suspensa deve ser desativada
     * @param string|bool|null $multiple Especifica que múltiplas opções podem ser selecionadas de uma só vez
     * @param string|int|null $size Define o número de opções visíveis em uma lista suspensa
     * @param string|bool|null $autofocus Especifica que a lista suspensa deve receber foco automaticamente quando a página for carregada
     * @param string|null $form Define a qual formulário a lista suspensa pertence
     */
    public function __construct(
        protected string|null      $name = null,
        protected string|bool|null $required = null,
        protected string|bool|null $disabled = null,
        protected string|bool|null $multiple = null,
        protected string|int|null  $size = null,
        protected string|bool|null $autofocus = null,
        protected string|null      $form = null,
    )
    {
    }

    /**
     * @param string|null $name Define um nome para a lista suspensa
     * @param string|bool|null $required Especifica que o usuário deve selecionar um valor antes de enviar o formulário
     * @param string|bool|null $disabled Especifica que uma lista suspensa deve ser desativada
     * @param string|bool|null $multiple Especifica que múltiplas opções podem ser selecionadas de uma só vez
     * @param string|int|null $size Define o número de opções visíveis em uma lista suspensa
     * @param string|bool|null $autofocus Especifica que a lista suspensa deve receber foco automaticamente quando a página for carregada
     * @param string|null $form Define a qual formulário a lista suspensa pertence
     */
    public static function create(
        string|null      $name = null,
        string|bool|null $required = null,
        string|bool|null $disabled = null,
        string|bool|null $multiple = null,
        string|int|null  $size = null,
        string|bool|null $autofocus = null,
        string|null      $form = null
    ): self
    {
        return new self(
            $name,
            $required,
            $disabled,
            $multiple,
            $size,
            $autofocus,
            $form
        );
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

    public function getRequired(): bool|string|null
    {
        return $this->required;
    }

    public function setRequired(bool|string|null $required): self
    {
        $this->required = $required;
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

    public function getMultiple(): bool|string|null
    {
        return $this->multiple;
    }

    public function setMultiple(bool|string|null $multiple): self
    {
        $this->multiple = $multiple;
        return $this;
    }

    public function getSize(): int|string|null
    {
        return $this->size;
    }

    public function setSize(int|string|null $size): self
    {
        $this->size = $size;
        return $this;
    }

    public function getAutofocus(): bool|string|null
    {
        return $this->autofocus;
    }

    public function setAutofocus(bool|string|null $autofocus): self
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

}