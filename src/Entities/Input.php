<?php

namespace AlessandroDesign\FormBuilder\Entities;

use AlessandroDesign\FormBuilder\Enums\AutocompleteEnum;
use AlessandroDesign\FormBuilder\Enums\EnctypeEnum;
use AlessandroDesign\FormBuilder\Enums\InputTypeEnum;
use AlessandroDesign\FormBuilder\Enums\MethodEnum;
use AlessandroDesign\FormBuilder\Enums\PopovertargetactionEnum;
use AlessandroDesign\FormBuilder\Enums\TargetEnum;
use AlessandroDesign\FormBuilder\Traits\HTMLGlobalAttributesTrait;
use AlessandroDesign\FormBuilder\Traits\SupportElementTrait;
use AlessandroDesign\FormBuilder\Traits\SupportFormTrait;

class Input
{
    use HTMLGlobalAttributesTrait, SupportFormTrait, SupportElementTrait;

    /**
     * Construtor da classe Input
     * @param InputTypeEnum|string $type Especifica o tipo de elemento <input> a ser exibido
     * @param string|null $name Especifica o nome do elemento <input>
     * @param string|null $value Especifica o valor do elemento <input>
     * @param string|null $placeholder Especifica uma dica curta que descreve o valor esperado de um elemento <input>
     * @param bool $readonly Especifica que o campo de input é somente leitura
     * @param bool $required Especifica que o campo de input deve ser preenchido antes de submeter o formulário
     * @param bool $multiple Especifica que o usuário pode inserir mais de um valor em um elemento <input>
     * @param bool $disabled Especifica que o elemento <input> deve estar desabilitado
     * @param bool $checked Especifica que o elemento <input> deve ser pré-selecionado quando a página carregar (apenas para type="checkbox" ou type="radio")
     * @param string|null $accept Especifica um filtro para os tipos de arquivos que o usuário pode selecionar na caixa de diálogo de input (apenas para type="file")
     * @param string|null $alt Especifica um texto alternativo para imagens (apenas para type="image")
     * @param AutocompleteEnum|string|null $autocomplete Especifica se o elemento <input> deve ter o autocomplete habilitado (on | off)
     * @param bool $autofocus Especifica que o elemento <input> deve automaticamente receber o foco quando a página carregar
     * @param string|null $dirname Especifica que a direção do texto será enviada com o nome do campo
     * @param string|null $form Especifica o ID do formulário ao qual o elemento <input> pertence
     * @param string|null $formaction Especifica a URL do arquivo que processará o controle de input ao submeter o formulário (apenas para type="submit" e type="image")
     * @param EnctypeEnum|string|null $formenctype Especifica como os dados do formulário devem ser codificados ao submetê-los ao servidor (apenas para type="submit" e type="image")
     * @param MethodEnum|string|null $formmethod Define o método HTTP (GET ou POST) para enviar os dados para a URL de ação (apenas para type="submit" e type="image")
     * @param bool $formnovalidate Define que os elementos do formulário não devem ser validados ao serem submetidos
     * @param TargetEnum|string|null $formtarget Especifica onde exibir a resposta recebida após a submissão do formulário (apenas para type="submit" e type="image")
     * @param int|string|null $height Especifica a altura do elemento <input> (apenas para type="image")
     * @param string|null $list Refere-se a um elemento <datalist> que contém opções predefinidas para o elemento <input>
     * @param int|string|null $max Especifica o valor máximo para o elemento <input> (número ou data)
     * @param int|null $maxlength Especifica o número máximo de caracteres permitidos em um elemento <input>
     * @param int|string|null $min Especifica o valor mínimo para o elemento <input> (número ou data)
     * @param int|null $minlength Especifica o número mínimo de caracteres necessários em um elemento <input>
     * @param string|null $pattern Especifica uma expressão regular contra a qual o valor do <input> será validado
     * @param string|null $popovertarget Especifica o elemento popover a ser acionado (apenas para type="button")
     * @param PopovertargetactionEnum|string|null $popovertargetaction Especifica o que acontece com o popover quando o botão é clicado (esconder, mostrar ou alternar - apenas para type="button")
     * @param int|null $size Especifica a largura do elemento <input> em caracteres
     * @param string|null $src Especifica a URL da imagem a ser usada como botão de submissão (apenas para type="image")
     * @param int|string|null $step Especifica o intervalo entre valores válidos em um campo de input numérico
     * @param int|null $width Especifica a largura do elemento <input> (apenas para type="image")
     */
    public function __construct(
        protected InputTypeEnum|string                $type = InputTypeEnum::TEXT,
        protected string|null                         $name = null,
        protected string|null                         $value = null,
        protected string|null                         $placeholder = null,
        protected bool|string|null                    $readonly = null,
        protected bool|string|null                    $required = null,
        protected bool|string|null                    $multiple = null,
        protected bool|string|null                    $disabled = null,
        protected bool|string|null                    $checked = null,
        protected string|null                         $accept = null,
        protected string|null                         $alt = null,
        protected AutocompleteEnum|string|null        $autocomplete = null,
        protected bool|string|null                    $autofocus = null,
        protected string|null                         $dirname = null,
        protected string|null                         $form = null,
        protected string|null                         $formaction = null,
        protected EnctypeEnum|string|null             $formenctype = null,
        protected MethodEnum|string|null              $formmethod = null,
        protected bool|string|null                    $formnovalidate = null,
        protected TargetEnum|string|null              $formtarget = null,
        protected int|string|null                     $height = null,
        protected string|null                         $list = null,
        protected int|string|null                     $max = null,
        protected int|null                            $maxlength = null,
        protected int|string|null                     $min = null,
        protected int|null                            $minlength = null,
        protected string|null                         $pattern = null,
        protected string|null                         $popovertarget = null,
        protected PopovertargetactionEnum|string|null $popovertargetaction = null,
        protected int|null                            $size = null,
        protected string|null                         $src = null,
        protected int|string|null                     $step = null,
        protected int|null                            $width = null
    )
    {
        // Inicialização da classe
    }

    /**
     * Creator da classe Input
     * @param InputTypeEnum|string $type Especifica o tipo de elemento <input> a ser exibido
     * @param string|null $name Especifica o nome do elemento <input>
     * @param string|null $value Especifica o valor do elemento <input>
     * @param string|null $placeholder Especifica uma dica curta que descreve o valor esperado de um elemento <input>
     * @param bool $readonly Especifica que o campo de input é somente leitura
     * @param bool $required Especifica que o campo de input deve ser preenchido antes de submeter o formulário
     * @param bool $multiple Especifica que o usuário pode inserir mais de um valor em um elemento <input>
     * @param bool $disabled Especifica que o elemento <input> deve estar desabilitado
     * @param bool $checked Especifica que o elemento <input> deve ser pré-selecionado quando a página carregar (apenas para type="checkbox" ou type="radio")
     * @param string|null $accept Especifica um filtro para os tipos de arquivos que o usuário pode selecionar na caixa de diálogo de input (apenas para type="file")
     * @param string|null $alt Especifica um texto alternativo para imagens (apenas para type="image")
     * @param AutocompleteEnum|string|null $autocomplete Especifica se o elemento <input> deve ter o autocomplete habilitado (on | off)
     * @param bool $autofocus Especifica que o elemento <input> deve automaticamente receber o foco quando a página carregar
     * @param string|null $dirname Especifica que a direção do texto será enviada com o nome do campo
     * @param string|null $form Especifica o ID do formulário ao qual o elemento <input> pertence
     * @param string|null $formaction Especifica a URL do arquivo que processará o controle de input ao submeter o formulário (apenas para type="submit" e type="image")
     * @param EnctypeEnum|string|null $formenctype Especifica como os dados do formulário devem ser codificados ao submetê-los ao servidor (apenas para type="submit" e type="image")
     * @param MethodEnum|string|null $formmethod Define o método HTTP (GET ou POST) para enviar os dados para a URL de ação (apenas para type="submit" e type="image")
     * @param bool $formnovalidate Define que os elementos do formulário não devem ser validados ao serem submetidos
     * @param TargetEnum|string|null $formtarget Especifica onde exibir a resposta recebida após a submissão do formulário (apenas para type="submit" e type="image")
     * @param int|string|null $height Especifica a altura do elemento <input> (apenas para type="image")
     * @param string|null $list Refere-se a um elemento <datalist> que contém opções predefinidas para o elemento <input>
     * @param int|string|null $max Especifica o valor máximo para o elemento <input> (número ou data)
     * @param int|null $maxlength Especifica o número máximo de caracteres permitidos em um elemento <input>
     * @param int|string|null $min Especifica o valor mínimo para o elemento <input> (número ou data)
     * @param int|null $minlength Especifica o número mínimo de caracteres necessários em um elemento <input>
     * @param string|null $pattern Especifica uma expressão regular contra a qual o valor do <input> será validado
     * @param string|null $popovertarget Especifica o elemento popover a ser acionado (apenas para type="button")
     * @param PopovertargetactionEnum|string|null $popovertargetaction Especifica o que acontece com o popover quando o botão é clicado (esconder, mostrar ou alternar - apenas para type="button")
     * @param int|null $size Especifica a largura do elemento <input> em caracteres
     * @param string|null $src Especifica a URL da imagem a ser usada como botão de submissão (apenas para type="image")
     * @param int|string|null $step Especifica o intervalo entre valores válidos em um campo de input numérico
     * @param int|null $width Especifica a largura do elemento <input> (apenas para type="image")
     */
    public static function create(
        InputTypeEnum|string                $type = InputTypeEnum::TEXT,
        string|null                         $name = null,
        string|null                         $value = null,
        string|null                         $placeholder = null,
        bool|string|null                    $readonly = null,
        bool|string|null                    $required = null,
        bool|string|null                    $multiple = null,
        bool|string|null                    $disabled = null,
        bool|string|null                    $checked = null,
        string|null                         $accept = null,
        string|null                         $alt = null,
        AutocompleteEnum|string|null        $autocomplete = null,
        bool|string|null                    $autofocus = null,
        string|null                         $dirname = null,
        string|null                         $form = null,
        string|null                         $formaction = null,
        EnctypeEnum|string|null             $formenctype = null,
        MethodEnum|string|null              $formmethod = null,
        bool|string|null                    $formnovalidate = null,
        TargetEnum|string|null              $formtarget = null,
        int|string|null                     $height = null,
        string|null                         $list = null,
        int|string|null                     $max = null,
        int|null                            $maxlength = null,
        int|string|null                     $min = null,
        int|null                            $minlength = null,
        string|null                         $pattern = null,
        string|null                         $popovertarget = null,
        PopovertargetactionEnum|string|null $popovertargetaction = null,
        int|null                            $size = null,
        string|null                         $src = null,
        int|string|null                     $step = null,
        int|null                            $width = null
    ):self
    {
        return new self(
            $type,
            $name,
            $value,
            $placeholder,
            $readonly,
            $required,
            $multiple,
            $disabled,
            $checked,
            $accept,
            $alt,
            $autocomplete,
            $autofocus,
            $dirname,
            $form,
            $formaction,
            $formenctype,
            $formmethod,
            $formnovalidate,
            $formtarget,
            $height,
            $list,
            $max,
            $maxlength,
            $min,
            $minlength,
            $pattern,
            $popovertarget,
            $popovertargetaction,
            $size,
            $src,
            $step,
            $width
        );
    }

    public function getType():selfTypeEnum|string
    {
        return $this->type instanceof InputTypeEnum ? $this->type->value : $this->type;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }

    public function getReadonly(): bool|string|null
    {
        return $this->readonly;
    }

    public function getRequired(): bool|string|null
    {
        return $this->required;
    }

    public function getMultiple(): bool|string|null
    {
        return $this->multiple;
    }

    public function getDisabled(): bool|string|null
    {
        return $this->disabled;
    }

    public function getChecked(): bool|string|null
    {
        return $this->checked;
    }

    public function getAccept(): ?string
    {
        return $this->accept;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function getAutocomplete(): string|AutocompleteEnum|null
    {
        return $this->autocomplete instanceof AutocompleteEnum ? $this->autocomplete->value : $this->autocomplete;
    }

    public function getAutofocus(): bool|string|null
    {
        return $this->autofocus;
    }

    public function getDirname(): ?string
    {
        return $this->dirname;
    }

    public function getForm(): ?string
    {
        return $this->form;
    }

    public function getFormaction(): ?string
    {
        return $this->formaction;
    }

    public function getFormenctype(): EnctypeEnum|string|null
    {
        return $this->formenctype instanceof EnctypeEnum ? $this->formenctype->value : $this->formenctype;
    }

    public function getFormmethod(): string|MethodEnum|null
    {
        return $this->formmethod instanceof MethodEnum ? $this->formmethod->value : $this->formmethod;
    }

    public function getFormnovalidate(): bool|string|null
    {
        return $this->formnovalidate;
    }

    public function getFormtarget(): string|TargetEnum|null
    {
        return $this->formtarget instanceof TargetEnum ? $this->formtarget->value : $this->formtarget;
    }

    public function getHeight(): int|string|null
    {
        return $this->height;
    }

    public function getList(): ?string
    {
        return $this->list;
    }

    public function getMax(): int|string|null
    {
        return $this->max;
    }

    public function getMaxlength(): ?int
    {
        return $this->maxlength;
    }

    public function getMin(): int|string|null
    {
        return $this->min;
    }

    public function getMinlength(): ?int
    {
        return $this->minlength;
    }

    public function getPattern(): ?string
    {
        return $this->pattern;
    }

    public function getPopovertarget(): ?string
    {
        return $this->popovertarget;
    }

    public function getPopovertargetaction(): PopovertargetactionEnum|string|null
    {
        return $this->popovertargetaction instanceof PopovertargetactionEnum ? $this->popovertargetaction->value : $this->popovertargetaction;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function getSrc(): ?string
    {
        return $this->src;
    }

    public function getStep(): int|string|null
    {
        return $this->step;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setType(InputTypeEnum|string $type):self
    {
        $this->type = $type;
        return $this;
    }

    public function setName(?string $name):self
    {
        $this->name = $name;
        return $this;
    }

    public function setValue(?string $value):self
    {
        $this->value = $value;
        return $this;
    }

    public function setPlaceholder(?string $placeholder):self
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    public function setReadonly(bool|string|null $readonly):self
    {
        $this->readonly = $readonly;
        return $this;
    }

    public function setRequired(bool|string|null $required):self
    {
        $this->required = $required;
        return $this;
    }

    public function setMultiple(bool|string|null $multiple):self
    {
        $this->multiple = $multiple;
        return $this;
    }

    public function setDisabled(bool|string|null $disabled):self
    {
        $this->disabled = $disabled;
        return $this;
    }

    public function setChecked(bool|string|null $checked):self
    {
        $this->checked = $checked;
        return $this;
    }

    public function setAccept(?string $accept):self
    {
        $this->accept = $accept;
        return $this;
    }

    public function setAlt(?string $alt):self
    {
        $this->alt = $alt;
        return $this;
    }

    public function setAutocomplete(string|AutocompleteEnum|null $autocomplete):self
    {
        $this->autocomplete = $autocomplete;
        return $this;
    }

    public function setAutofocus(bool|string|null $autofocus):self
    {
        $this->autofocus = $autofocus;
        return $this;
    }

    public function setDirname(?string $dirname):self
    {
        $this->dirname = $dirname;
        return $this;
    }

    public function setForm(?string $form):self
    {
        $this->form = $form;
        return $this;
    }

    public function setFormaction(?string $formaction):self
    {
        $this->formaction = $formaction;
        return $this;
    }

    public function setFormenctype(EnctypeEnum|string|null $formenctype):self
    {
        $this->formenctype = $formenctype;
        return $this;
    }

    public function setFormmethod(string|MethodEnum|null $formmethod):self
    {
        $this->formmethod = $formmethod;
        return $this;
    }

    public function setFormnovalidate(bool|string|null $formnovalidate):self
    {
        $this->formnovalidate = $formnovalidate;
        return $this;
    }

    public function setFormtarget(string|TargetEnum|null $formtarget):self
    {
        $this->formtarget = $formtarget;
        return $this;
    }

    public function setHeight(int|string|null $height):self
    {
        $this->height = $height;
        return $this;
    }

    public function setList(?string $list):self
    {
        $this->list = $list;
        return $this;
    }

    public function setMax(int|string|null $max):self
    {
        $this->max = $max;
        return $this;
    }

    public function setMaxlength(?int $maxlength):self
    {
        $this->maxlength = $maxlength;
        return $this;
    }

    public function setMin(int|string|null $min):self
    {
        $this->min = $min;
        return $this;
    }

    public function setMinlength(?int $minlength):self
    {
        $this->minlength = $minlength;
        return $this;
    }

    public function setPattern(?string $pattern):self
    {
        $this->pattern = $pattern;
        return $this;
    }

    public function setPopovertarget(?string $popovertarget):self
    {
        $this->popovertarget = $popovertarget;
        return $this;
    }

    public function setPopovertargetaction(PopovertargetactionEnum|string|null $popovertargetaction):self
    {
        $this->popovertargetaction = $popovertargetaction;
        return $this;
    }

    public function setSize(?int $size):self
    {
        $this->size = $size;
        return $this;
    }

    public function setSrc(?string $src):self
    {
        $this->src = $src;
        return $this;
    }

    public function setStep(int|string|null $step):self
    {
        $this->step = $step;
        return $this;
    }

    public function setWidth(?int $width):self
    {
        $this->width = $width;
        return $this;
    }
}