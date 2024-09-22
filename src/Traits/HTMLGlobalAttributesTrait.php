<?php

namespace AlessandroDesign\FormBuilder\Traits;

use AlessandroDesign\FormBuilder\Enums\DirEnum;
use AlessandroDesign\FormBuilder\Enums\DraggableEnum;
use AlessandroDesign\FormBuilder\Enums\EnterkeyhintEnum;
use AlessandroDesign\FormBuilder\Enums\InputmodeEnum;
use AlessandroDesign\FormBuilder\Enums\SpellcheckEnum;
use AlessandroDesign\FormBuilder\Enums\TranslateEnum;
use ReflectionClass;
use ReflectionProperty;

/**
 * Atributos Globais HTML
 * Os atributos globais são atributos que podem ser usados com todos os elementos HTML.
 */
trait HTMLGlobalAttributesTrait
{
    /**
     * @var string|null $accesskey Especifica uma tecla de atalho para ativar/focar um elemento
     */
    protected string|null $accesskey = null;

    /**
     * @var string|null $class Especifica um ou mais nomes de classe para um elemento (refere-se a uma classe em uma folha de estilo)
     */
    protected string|null $class = null;

    /**
     * @var string|null $contenteditable Especifica se o conteúdo de um elemento é editável ou não
     */
    protected null|string $contenteditable = null;

    /**
     * @var array|null $data Especifica dados personalizados privados para a página ou aplicação
     */
    protected array|null $data = null;

    /**
     * @var DirEnum|string|null $dir Especifica a direção do texto para o conteúdo de um elemento
     */
    protected DirEnum|string|null $dir = null;

    /**
     * @var DraggableEnum|bool|null $draggable Especifica se um elemento pode ser arrastado ou não
     */
    protected DraggableEnum|bool|null $draggable = null;

    /**
     * @var EnterkeyhintEnum|string|null $enterkeyhint Especifica o texto da tecla "enter" em um teclado virtual
     */
    protected EnterkeyhintEnum|string|null $enterkeyhint = null;

    /**
     * @var bool|null $hidden Especifica que um elemento ainda não é, ou não é mais, relevante
     */
    protected bool|null $hidden = null;

    /**
     * @var string|null $id Especifica um identificador único para um elemento
     */
    protected string|null $id = null;

    /**
     * @var bool|null $inert Especifica que o navegador deve ignorar esta seção
     */
    protected bool|null $inert = null;

    /**
     * @var InputmodeEnum|string|null $inputmode Especifica o modo de um teclado virtual
     */
    protected InputmodeEnum|string|null $inputmode = null;

    /**
     * @var string|null $lang Especifica o idioma do conteúdo do elemento
     */
    protected string|null $lang = null;

    /**
     * @var bool|null $popover Especifica um elemento popover
     */
    protected bool|null $popover = null;

    /**
     * @var SpellcheckEnum|string|null $spellcheck Especifica se o elemento deve ter sua ortografia e gramática verificadas ou não
     */
    protected SpellcheckEnum|string|null $spellcheck = null;

    /**
     * @var string|null $style Especifica um estilo CSS inline para um elemento
     */
    protected string|null $style = null;

    /**
     * @var int|null $tabindex Especifica a ordem de tabulação de um elemento
     */
    protected int|null $tabindex = null;

    /**
     * @var string|null $title Especifica informações adicionais sobre um elemento
     */
    protected string|null $title = null;

    /**
     * @var TranslateEnum|string|null $translate Especifica se o conteúdo de um elemento deve ser traduzido ou não
     */
    protected TranslateEnum|string|null $translate = null;

    public function populateAttributes(array|null $attributes = null): self
    {
        if (is_array($attributes)) {
            $myClass = new ReflectionClass($this);
            $protectedProperties = $myClass->getProperties(ReflectionProperty::IS_PROTECTED);

            foreach ($protectedProperties as $property) {
                if (key_exists($property->getName(), $attributes)) {
                    if ($attributes[$property->getName()] !== null) {
                        $prop = $property->getName();
                        $this->$prop = $attributes[$property->getName()];
                    }
                }
            }
        }

        return $this;
    }

    public function getAccesskey(): ?string
    {
        return $this->accesskey;
    }

    public function setAccesskey(?string $accesskey): self
    {
        $this->accesskey = $accesskey;
        return $this;
    }

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function setClass(?string $class): self
    {
        $this->class = $class;
        return $this;
    }

    public function getContenteditable(): ?string
    {
        return $this->contenteditable;
    }

    public function setContenteditable(?string $contenteditable): self
    {
        $this->contenteditable = $contenteditable;
        return $this;
    }

    public function getData(): ?array
    {
        return $this->data;
    }

    public function setData(?array $data): self
    {
        $this->data = array_merge($this->data, $data);
        return $this;
    }

    public function addData(string $key, mixed $value = null): self
    {
        $this->data[$key] = $value;
        return $this;
    }

    public function getDir(): DirEnum|string|null
    {
        return $this->dir instanceof DirEnum ? $this->dir->value : $this->dir;
    }

    public function setDir(DirEnum|string|null $dir): self
    {
        $this->dir = $dir;
        return $this;
    }

    public function getDraggable(): DraggableEnum|bool|null
    {
        return $this->draggable instanceof DraggableEnum ? $this->draggable->value : ($this->draggable ? 'true' : 'false');
    }

    public function setDraggable(DraggableEnum|bool|null $draggable): self
    {
        $this->draggable = $draggable;
        return $this;
    }

    public function getEnterkeyhint(): EnterkeyhintEnum|string|null
    {
        return $this->enterkeyhint instanceof EnterkeyhintEnum ? $this->enterkeyhint->value : $this->enterkeyhint;
    }

    public function setEnterkeyhint(EnterkeyhintEnum|string|null $enterkeyhint): self
    {
        $this->enterkeyhint = $enterkeyhint;
        return $this;
    }

    public function getHidden(): ?bool
    {
        return $this->hidden;
    }

    public function setHidden(?bool $hidden): self
    {
        $this->hidden = $hidden;
        return $this;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getInert(): ?bool
    {
        return $this->inert;
    }

    public function setInert(?bool $inert): self
    {
        $this->inert = $inert;
        return $this;
    }

    public function getInputmode(): string|InputmodeEnum|null
    {
        return $this->inputmode instanceof InputmodeEnum ? $this->inputmode->value : $this->inputmode;
    }

    public function setInputmode(string|InputmodeEnum|null $inputmode): self
    {
        $this->inputmode = $inputmode;
        return $this;
    }

    public function getLang(): ?string
    {
        return $this->lang;
    }

    public function setLang(?string $lang): self
    {
        $this->lang = $lang;
        return $this;
    }

    public function getPopover(): ?bool
    {
        return $this->popover;
    }

    public function setPopover(?bool $popover): self
    {
        $this->popover = $popover;
        return $this;
    }

    public function getSpellcheck(): string|SpellcheckEnum|null
    {
        return $this->spellcheck instanceof SpellcheckEnum ? $this->spellcheck->value : $this->spellcheck;
    }

    public function setSpellcheck(string|SpellcheckEnum|null $spellcheck): self
    {
        $this->spellcheck = $spellcheck;
        return $this;
    }

    public function getStyle(): ?string
    {
        return $this->style;
    }

    public function setStyle(?string $style): self
    {
        $this->style = $style;
        return $this;
    }

    public function getTabindex(): ?int
    {
        return $this->tabindex;
    }

    public function setTabindex(?int $tabindex): self
    {
        $this->tabindex = $tabindex;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getTranslate(): TranslateEnum|string|null
    {
        return $this->translate instanceof TranslateEnum ? $this->translate->value : $this->translate;
    }

    public function setTranslate(TranslateEnum|string|null $translate): self
    {
        $this->translate = $translate;
        return $this;
    }
}