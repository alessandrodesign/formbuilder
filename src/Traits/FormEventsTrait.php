<?php

namespace AlessandroDesign\FormBuilder\Traits;

trait FormEventsTrait
{
    /**
     * @var string|null $onblur Dispara no momento em que o elemento perde o foco
     */
    protected string|null $onblur = null;

    /**
     * @var string|null $onchange Dispara no momento em que o valor do elemento é alterado
     */
    protected string|null $onchange = null;

    /**
     * @var string|null $oncontextmenu Script a ser executado quando um menu de contexto é acionado
     */
    protected string|null $oncontextmenu = null;

    /**
     * @var string|null $onfocus Dispara no momento em que o elemento ganha foco
     */
    protected string|null $onfocus = null;

    /**
     * @var string|null $oninput Script a ser executado quando um elemento recebe entrada do usuário
     */
    protected string|null $oninput = null;

    /**
     * @var string|null $oninvalid Script a ser executado quando um elemento é inválido
     */
    protected string|null $oninvalid = null;

    /**
     * @var string|null $onreset Dispara quando o botão de Reset em um formulário é clicado
     */
    protected string|null $onreset = null;

    /**
     * @var string|null $onsearch Dispara quando o usuário digita algo em um campo de pesquisa (para <input type="search">)
     */
    protected string|null $onsearch = null;

    /**
     * @var string|null $onselect Dispara após algum texto ter sido selecionado em um elemento
     */
    protected string|null $onselect = null;

    /**
     * @var string|null $onsubmit Dispara quando um formulário é enviado
     */
    protected string|null $onsubmit = null;

    public function getOnblur(): ?string
    {
        return $this->onblur;
    }

    public function setOnblur(?string $onblur): self
    {
        $this->onblur = $onblur;
        return $this;
    }

    public function getOnchange(): ?string
    {
        return $this->onchange;
    }

    public function setOnchange(?string $onchange): self
    {
        $this->onchange = $onchange;
        return $this;
    }

    public function getOncontextmenu(): ?string
    {
        return $this->oncontextmenu;
    }

    public function setOncontextmenu(?string $oncontextmenu): self
    {
        $this->oncontextmenu = $oncontextmenu;
        return $this;
    }

    public function getOnfocus(): ?string
    {
        return $this->onfocus;
    }

    public function setOnfocus(?string $onfocus): self
    {
        $this->onfocus = $onfocus;
        return $this;
    }

    public function getOninput(): ?string
    {
        return $this->oninput;
    }

    public function setOninput(?string $oninput): self
    {
        $this->oninput = $oninput;
        return $this;
    }

    public function getOninvalid(): ?string
    {
        return $this->oninvalid;
    }

    public function setOninvalid(?string $oninvalid): self
    {
        $this->oninvalid = $oninvalid;
        return $this;
    }

    public function getOnreset(): ?string
    {
        return $this->onreset;
    }

    public function setOnreset(?string $onreset): self
    {
        $this->onreset = $onreset;
        return $this;
    }

    public function getOnsearch(): ?string
    {
        return $this->onsearch;
    }

    public function setOnsearch(?string $onsearch): self
    {
        $this->onsearch = $onsearch;
        return $this;
    }

    public function getOnselect(): ?string
    {
        return $this->onselect;
    }

    public function setOnselect(?string $onselect): self
    {
        $this->onselect = $onselect;
        return $this;
    }

    public function getOnsubmit(): ?string
    {
        return $this->onsubmit;
    }

    public function setOnsubmit(?string $onsubmit): self
    {
        $this->onsubmit = $onsubmit;
        return $this;
    }

}