<?php

namespace AlessandroDesign\FormBuilder;

use AlessandroDesign\FormBuilder\Entities\Button;
use AlessandroDesign\FormBuilder\Entities\Input;
use AlessandroDesign\FormBuilder\Entities\Label;
use AlessandroDesign\FormBuilder\Entities\OptGroup;
use AlessandroDesign\FormBuilder\Entities\Option;
use AlessandroDesign\FormBuilder\Entities\Select;
use AlessandroDesign\FormBuilder\Enums\AutocompleteEnum;
use AlessandroDesign\FormBuilder\Enums\ButtonTypeEnum;
use AlessandroDesign\FormBuilder\Enums\EnctypeEnum;
use AlessandroDesign\FormBuilder\Enums\InputTypeEnum;
use AlessandroDesign\FormBuilder\Enums\MethodEnum;
use AlessandroDesign\FormBuilder\Enums\PopovertargetactionEnum;
use AlessandroDesign\FormBuilder\Enums\RelEnum;
use AlessandroDesign\FormBuilder\Enums\TagEnum;
use AlessandroDesign\FormBuilder\Enums\TargetEnum;
use AlessandroDesign\FormBuilder\Traits\FormEventsTrait;
use AlessandroDesign\FormBuilder\Traits\HTMLGlobalAttributesTrait;
use AlessandroDesign\FormBuilder\Traits\SupportFormTrait;
use AlessandroDesign\FormBuilder\Utils\Security\CsrfTokenManager;
use AlessandroDesign\FormBuilder\Utils\Session\SessionCache;
use DOMDocument;
use DOMElement;
use DOMException;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;
use Random\RandomException;

class Form
{
    use HTMLGlobalAttributesTrait, FormEventsTrait, SupportFormTrait;

    private const string csrf_token = 'csrf_token_alessandrodesign';
    private DOMDocument $dom;
    private DOMElement $form;
    private int|string $elementIndex = 0;
    private array $elements = [];
    /** @var $labels Label[] */
    private array $labels = [];

    /** @var $labelsForInputCheckRadio Label[] */
    private array $labelsForInputCheckRadio = [];
    private array|null $options = null;
    private array $classElement = [];
    private array $classLabel = [];
    private array $parents = [];
    private array $children = [];
    private array $optionsSelect = [];
    private array $optionsSelected = [];

    /**
     * @param string|null $name Especifica o nome de um formulário
     * @param MethodEnum|string|null $method Especifica o método HTTP a ser usado ao enviar dados de formulário
     * @param string|null $action Especifica para onde enviar os dados do formulário quando um formulário é enviado
     * @param EnctypeEnum|string|null $enctype Especifica como os dados do formulário devem ser codificados ao enviá-los ao servidor (apenas para method="post")
     * @param TargetEnum|string|null $target Especifica onde exibir a resposta recebida após o envio do formulário
     * @param string|null $acceptCharset Especifica as codificações de caracteres que serão usadas para o envio do formulário
     * @param AutocompleteEnum|string|bool|null $autocomplete Especifica se um formulário deve ter o preenchimento automático ativado ou desativado
     * @param bool $novalidate Especifica que o formulário não deve ser validado quando enviado
     * @param RelEnum|string|null $rel Especifica a relação entre um recurso vinculado e o documento atual
     */
    public function __construct(
        protected string|null                       $name = null,
        protected MethodEnum|string|null            $method = null,
        protected string|null                       $action = null,
        protected EnctypeEnum|string|null           $enctype = null,
        protected TargetEnum|string|null            $target = null,
        protected string|null                       $acceptCharset = null,
        protected AutocompleteEnum|string|bool|null $autocomplete = null,
        protected bool                              $novalidate = false,
        protected RelEnum|string|null               $rel = null,
    )
    {
        $this->dom = new DOMDocument('1.0', 'utf-8');
        $this->dom->formatOutput = true;
    }

    /**
     * @param string|null $name Especifica o nome de um formulário
     * @param MethodEnum|string|null $method Especifica o método HTTP a ser usado ao enviar dados de formulário
     * @param string|null $action Especifica para onde enviar os dados do formulário quando um formulário é enviado
     * @param EnctypeEnum|string|null $enctype Especifica como os dados do formulário devem ser codificados ao enviá-los ao servidor (apenas para method="post")
     * @param TargetEnum|string|null $target Especifica onde exibir a resposta recebida após o envio do formulário
     * @param string|null $acceptCharset Especifica as codificações de caracteres que serão usadas para o envio do formulário
     * @param AutocompleteEnum|string|bool|null $autocomplete Especifica se um formulário deve ter o preenchimento automático ativado ou desativado
     * @param bool $novalidate Especifica que o formulário não deve ser validado quando enviado
     * @param RelEnum|string|null $rel Especifica a relação entre um recurso vinculado e o documento atual
     * @return $this
     */
    public static function create(
        string|null                       $name = null,
        MethodEnum|string|null            $method = null,
        string|null                       $action = null,
        EnctypeEnum|string|null           $enctype = null,
        TargetEnum|string|null            $target = null,
        string|null                       $acceptCharset = null,
        AutocompleteEnum|string|bool|null $autocomplete = null,
        bool                              $novalidate = false,
        RelEnum|string|null               $rel = null
    ): self
    {
        return new self($name, $method, $action, $enctype, $target, $acceptCharset, $autocomplete, $novalidate, $rel);
    }

    public static function sess(CacheInterface|null $cache = null): CsrfTokenManager
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $sessionCache = $cache ?? new SessionCache();
        return new CsrfTokenManager($sessionCache, self::csrf_token);
    }

    /**
     * @throws RandomException
     * @throws InvalidArgumentException
     */
    public function useToken(): self
    {
        // Obter token CSRF
        $this->inputHidden(self::csrf_token, self::csrf_token, self::sess()->getToken());
        return $this;
    }

    /**
     * @throws RandomException
     * @throws InvalidArgumentException
     */
    public static function validateToken(string|null $token = null): bool
    {
        return self::sess()->validateToken($token ?? ($_POST[self::csrf_token] ?? ''));
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getMethod(): string|MethodEnum|null
    {
        return $this->method instanceof MethodEnum ? $this->method->value : $this->method;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function getEnctype(): EnctypeEnum|string|null
    {
        return $this->enctype instanceof EnctypeEnum ? $this->enctype->value : $this->enctype;
    }

    public function getTarget(): string|TargetEnum|null
    {
        return $this->target instanceof TargetEnum ? $this->target->value : $this->target;
    }

    public function getAcceptCharset(): ?string
    {
        return $this->acceptCharset;
    }

    public function getAutocomplete(): bool|string|AutocompleteEnum|null
    {
        return $this->autocomplete instanceof AutocompleteEnum ? $this->autocomplete->value : (is_string($this->autocomplete) ? $this->autocomplete : ($this->autocomplete ? 'true' : 'false'));
    }

    public function isNovalidate(): bool
    {
        return $this->novalidate;
    }

    public function getRel(): string|RelEnum|null
    {
        return $this->rel instanceof RelEnum ? $this->rel->value : $this->rel;
    }

    public function inputButton(
        string|null      $label = null,
        string|null      $id = null,
        string|null      $class = null,
        string|null      $name = null,
        string|null      $value = null,
        string|null      $placeholder = null,
        bool|string|null $readonly = null,
        bool|string|null $required = null,
        bool|string|null $disabled = null,
        string|null      $style = null,
        array            $attributes = null
    ): self
    {
        $attributes = array_merge($attributes ?? [], [
            'label' => Label::create($label, $id),
            'type' => InputTypeEnum::BUTTON,
            'name' => $name,
            'value' => $value,
            'placeholder' => $placeholder,
            'readonly' => $readonly,
            'required' => $required,
            'disabled' => $disabled,
        ]);
        $this->input(...$attributes)->setId($id)->setClass($class)->setStyle($style)->populateAttributes($attributes);
        return $this;
    }

    public function inputCheckbox(
        string|null       $label = null,
        string|null       $id = null,
        string|null       $class = null,
        string|null       $name = null,
        string|null       $value = null,
        object|array|null $options = null,
        bool|string|null  $checked = null,
        bool|string|null  $readonly = null,
        bool|string|null  $required = null,
        bool|string|null  $disabled = null,
        string|null       $style = null,
        array             $attributes = null
    ): self
    {
        $attributes = array_merge($attributes ?? [], [
            'label' => Label::create($label, $id),
            'type' => InputTypeEnum::CHECKBOX,
            'name' => is_array($options) ? "{$name}[]" : $name,
            'checked' => $checked,
            'value' => $value,
            'readonly' => $readonly,
            'required' => $required,
            'disabled' => $disabled,
        ]);
        $this->options = $options;
        $input = $this->input(...$attributes);
        if (is_array($input)) {
            foreach ($input as $index => $element) {
                $attributes['id'] = $id . "_" . $index;
                $element->setClass($class)->setStyle($style)->populateAttributes($attributes);
            }
        } else {
            $input->setId($id)->setClass($class)->setStyle($style)->populateAttributes($attributes);
        }
        return $this;
    }

    public function inputColor(
        string|null      $label = null,
        string|null      $id = null,
        string|null      $class = null,
        string|null      $name = null,
        string|null      $value = null,
        bool|string|null $readonly = null,
        bool|string|null $required = null,
        bool|string|null $disabled = null,
        string|null      $style = null,
        array            $attributes = null
    ): self
    {
        $attributes = array_merge($attributes ?? [], [
            'label' => Label::create($label, $id),
            'type' => InputTypeEnum::COLOR,
            'name' => $name,
            'value' => $value,
            'readonly' => $readonly,
            'required' => $required,
            'disabled' => $disabled,
        ]);
        $this->input(...$attributes)->setId($id)->setClass($class)->setStyle($style)->populateAttributes($attributes);
        return $this;
    }

    public function inputDate(
        string|null      $label = null,
        string|null      $id = null,
        string|null      $class = null,
        string|null      $name = null,
        string|null      $value = null,
        bool|string|null $readonly = null,
        bool|string|null $required = null,
        bool|string|null $disabled = null,
        string|null      $style = null,
        array            $attributes = null
    ): self
    {
        $attributes = array_merge($attributes ?? [], [
            'label' => Label::create($label, $id),
            'type' => InputTypeEnum::DATE,
            'name' => $name,
            'value' => $value,
            'readonly' => $readonly,
            'required' => $required,
            'disabled' => $disabled,
        ]);
        $this->input(...$attributes)->setId($id)->setClass($class)->setStyle($style)->populateAttributes($attributes);
        return $this;
    }

    public function inputDatetimeLocal(
        string|null      $label = null,
        string|null      $id = null,
        string|null      $class = null,
        string|null      $name = null,
        string|null      $value = null,
        bool|string|null $readonly = null,
        bool|string|null $required = null,
        bool|string|null $disabled = null,
        string|null      $style = null,
        array            $attributes = null
    ): self
    {
        $attributes = array_merge($attributes ?? [], [
            'label' => Label::create($label, $id),
            'type' => InputTypeEnum::DATETIME_LOCAL,
            'name' => $name,
            'value' => $value,
            'readonly' => $readonly,
            'required' => $required,
            'disabled' => $disabled,
        ]);
        $this->input(...$attributes)->setId($id)->setClass($class)->setStyle($style)->populateAttributes($attributes);
        return $this;
    }

    public function inputEmail(
        string|null      $label = null,
        string|null      $id = null,
        string|null      $class = null,
        string|null      $name = null,
        string|null      $value = null,
        string|null      $placeholder = null,
        bool|string|null $readonly = null,
        bool|string|null $required = null,
        bool|string|null $disabled = null,
        string|null      $style = null,
        array            $attributes = null
    ): self
    {
        $attributes = array_merge($attributes ?? [], [
            'label' => Label::create($label, $id),
            'type' => InputTypeEnum::EMAIL,
            'name' => $name,
            'value' => $value,
            'placeholder' => $placeholder,
            'readonly' => $readonly,
            'required' => $required,
            'disabled' => $disabled,
        ]);
        $this->input(...$attributes)->setId($id)->setClass($class)->setStyle($style)->populateAttributes($attributes);
        return $this;
    }

    public function inputFile(
        string|null      $label = null,
        string|null      $id = null,
        string|null      $class = null,
        string|null      $name = null,
        bool|string|null $readonly = null,
        bool|string|null $required = null,
        bool|string|null $disabled = null,
        bool|string|null $multiple = null,
        string|null      $style = null,
        array            $attributes = null
    ): self
    {
        $attributes = array_merge($attributes ?? [], [
            'label' => Label::create($label, $id),
            'type' => InputTypeEnum::FILE,
            'name' => $name,
            'readonly' => $readonly,
            'required' => $required,
            'disabled' => $disabled,
            'multiple' => $multiple,
        ]);
        $this->input(...$attributes)->setId($id)->setClass($class)->setStyle($style)->populateAttributes($attributes);
        return $this;
    }

    public function inputHidden(
        string|null $id = null,
        string|null $name = null,
        string|null $value = null,
        array       $attributes = null
    ): self
    {
        $attributes = array_merge($attributes ?? [], [
            'type' => InputTypeEnum::HIDDEN,
            'name' => $name,
            'value' => $value,
        ]);
        $this->input(...$attributes)->setId($id)->populateAttributes($attributes);
        return $this;
    }

    public function inputImage(
        string|null      $label = null,
        string|null      $id = null,
        string|null      $class = null,
        string|null      $name = null,
        string|null      $value = null,
        bool|string|null $readonly = null,
        bool|string|null $required = null,
        bool|string|null $disabled = null,
        string|null      $style = null,
        array            $attributes = null
    ): self
    {
        $attributes = array_merge($attributes ?? [], [
            'label' => Label::create($label, $id),
            'type' => InputTypeEnum::IMAGE,
            'name' => $name,
            'value' => $value,
            'readonly' => $readonly,
            'required' => $required,
            'disabled' => $disabled,
        ]);
        $this->input(...$attributes)->setId($id)->setClass($class)->setStyle($style)->populateAttributes($attributes);
        return $this;
    }

    public function inputMonth(
        string|null      $label = null,
        string|null      $id = null,
        string|null      $class = null,
        string|null      $name = null,
        string|null      $value = null,
        bool|string|null $readonly = null,
        bool|string|null $required = null,
        bool|string|null $disabled = null,
        string|null      $style = null,
        array            $attributes = null
    ): self
    {
        $attributes = array_merge($attributes ?? [], [
            'label' => Label::create($label, $id),
            'type' => InputTypeEnum::MONTH,
            'name' => $name,
            'value' => $value,
            'readonly' => $readonly,
            'required' => $required,
            'disabled' => $disabled,
        ]);
        $this->input(...$attributes)->setId($id)->setClass($class)->setStyle($style)->populateAttributes($attributes);
        return $this;
    }

    public function inputNumber(
        string|null      $label = null,
        string|null      $id = null,
        string|null      $class = null,
        string|null      $name = null,
        string|null      $value = null,
        bool|string|null $readonly = null,
        bool|string|null $required = null,
        bool|string|null $disabled = null,
        string|null      $style = null,
        array            $attributes = null
    ): self
    {
        $attributes = array_merge($attributes ?? [], [
            'label' => Label::create($label, $id),
            'type' => InputTypeEnum::NUMBER,
            'name' => $name,
            'value' => $value,
            'readonly' => $readonly,
            'required' => $required,
            'disabled' => $disabled,
        ]);
        $this->input(...$attributes)->setId($id)->setClass($class)->setStyle($style)->populateAttributes($attributes);
        return $this;
    }

    public function inputPassword(
        string|null      $label = null,
        string|null      $id = null,
        string|null      $class = null,
        string|null      $name = null,
        string|null      $value = null,
        string|null      $placeholder = null,
        bool|string|null $readonly = null,
        bool|string|null $required = null,
        bool|string|null $disabled = null,
        string|null      $style = null,
        array            $attributes = null
    ): self
    {
        $attributes = array_merge($attributes ?? [], [
            'label' => Label::create($label, $id),
            'type' => InputTypeEnum::PASSWORD,
            'name' => $name,
            'value' => $value,
            'placeholder' => $placeholder,
            'readonly' => $readonly,
            'required' => $required,
            'disabled' => $disabled,
        ]);
        $this->input(...$attributes)->setId($id)->setClass($class)->setStyle($style)->populateAttributes($attributes);
        return $this;
    }

    public function inputRadio(
        string|null       $label = null,
        string|null       $id = null,
        string|null       $class = null,
        string|null       $name = null,
        string|null       $value = null,
        object|array|null $options = null,
        bool|string|null  $checked = null,
        bool|string|null  $readonly = null,
        bool|string|null  $required = null,
        bool|string|null  $disabled = null,
        string|null       $style = null,
        array             $attributes = null
    ): self
    {
        $attributes = array_merge($attributes ?? [], [
            'label' => Label::create($label, $id),
            'type' => InputTypeEnum::RADIO,
            'name' => is_array($options) ? "{$name}[]" : $name,
            'value' => $value,
            'checked' => $checked,
            'readonly' => $readonly,
            'required' => $required,
            'disabled' => $disabled,
        ]);
        $this->options = $options;
        $input = $this->input(...$attributes);
        if (is_array($input)) {
            foreach ($input as $index => $element) {
                $attributes['id'] = $id . "_" . $index;
                $element->setClass($class)->setStyle($style)->populateAttributes($attributes);
            }
        } else {
            $input->setId($id)->setClass($class)->setStyle($style)->populateAttributes($attributes);
        }
        return $this;
    }

    public function inputRange(
        string|null      $label = null,
        string|null      $id = null,
        string|null      $class = null,
        string|null      $name = null,
        string|null      $value = null,
        bool|string|null $readonly = null,
        bool|string|null $required = null,
        bool|string|null $disabled = null,
        string|null      $style = null,
        array            $attributes = null
    ): self
    {
        $attributes = array_merge($attributes ?? [], [
            'label' => Label::create($label, $id),
            'type' => InputTypeEnum::RANGE,
            'name' => $name,
            'value' => $value,
            'readonly' => $readonly,
            'required' => $required,
            'disabled' => $disabled,
        ]);
        $this->input(...$attributes)->setId($id)->setClass($class)->setStyle($style)->populateAttributes($attributes);
        return $this;
    }

    public function inputReset(
        string|null      $label = null,
        string|null      $id = null,
        string|null      $class = null,
        string|null      $name = null,
        string|null      $value = null,
        bool|string|null $readonly = null,
        bool|string|null $disabled = null,
        string|null      $style = null,
        array            $attributes = null
    ): self
    {
        $attributes = array_merge($attributes ?? [], [
            'label' => Label::create($label, $id),
            'type' => InputTypeEnum::RESET,
            'name' => $name,
            'value' => $value,
            'readonly' => $readonly,
            'disabled' => $disabled,
        ]);
        $this->input(...$attributes)->setId($id)->setClass($class)->setStyle($style)->populateAttributes($attributes);
        return $this;
    }

    public function inputSearch(
        string|null      $label = null,
        string|null      $id = null,
        string|null      $class = null,
        string|null      $name = null,
        string|null      $value = null,
        string|null      $placeholder = null,
        bool|string|null $readonly = null,
        bool|string|null $required = null,
        bool|string|null $disabled = null,
        string|null      $style = null,
        array            $attributes = null
    ): self
    {
        $attributes = array_merge($attributes ?? [], [
            'label' => Label::create($label, $id),
            'type' => InputTypeEnum::SEARCH,
            'name' => $name,
            'value' => $value,
            'placeholder' => $placeholder,
            'readonly' => $readonly,
            'required' => $required,
            'disabled' => $disabled,
        ]);
        $this->input(...$attributes)->setId($id)->setClass($class)->setStyle($style)->populateAttributes($attributes);
        return $this;
    }

    public function inputSubmit(
        string|null      $label = null,
        string|null      $id = null,
        string|null      $class = null,
        string|null      $name = null,
        string|null      $value = null,
        bool|string|null $readonly = null,
        bool|string|null $disabled = null,
        string|null      $style = null,
        array            $attributes = null
    ): self
    {
        $attributes = array_merge($attributes ?? [], [
            'label' => Label::create($label, $id),
            'type' => InputTypeEnum::SUBMIT,
            'name' => $name,
            'value' => $value,
            'readonly' => $readonly,
            'disabled' => $disabled,
        ]);
        $this->input(...$attributes)->setId($id)->setClass($class)->setStyle($style)->populateAttributes($attributes);
        return $this;
    }

    public function inputTel(
        string|null      $label = null,
        string|null      $id = null,
        string|null      $class = null,
        string|null      $name = null,
        string|null      $value = null,
        string|null      $placeholder = null,
        bool|string|null $readonly = null,
        bool|string|null $required = null,
        bool|string|null $disabled = null,
        string|null      $style = null,
        array            $attributes = null
    ): self
    {
        $attributes = array_merge($attributes ?? [], [
            'label' => Label::create($label, $id),
            'type' => InputTypeEnum::TEL,
            'name' => $name,
            'value' => $value,
            'placeholder' => $placeholder,
            'readonly' => $readonly,
            'required' => $required,
            'disabled' => $disabled,
        ]);
        $this->input(...$attributes)->setId($id)->setClass($class)->setStyle($style)->populateAttributes($attributes);
        return $this;
    }

    public function inputText(
        string|null      $label = null,
        string|null      $id = null,
        string|null      $class = null,
        string|null      $name = null,
        string|null      $value = null,
        string|null      $placeholder = null,
        bool|string|null $readonly = null,
        bool|string|null $required = null,
        bool|string|null $disabled = null,
        string|null      $style = null,
        array            $attributes = null
    ): self
    {
        $attributes = array_merge($attributes ?? [], [
            'label' => Label::create($label, $id),
            'type' => InputTypeEnum::TEXT,
            'name' => $name,
            'value' => $value,
            'placeholder' => $placeholder,
            'readonly' => $readonly,
            'required' => $required,
            'disabled' => $disabled,
        ]);
        $this->input(...$attributes)->setId($id)->setClass($class)->setStyle($style)->populateAttributes($attributes);
        return $this;
    }

    public function inputTime(
        string|null      $label = null,
        string|null      $id = null,
        string|null      $class = null,
        string|null      $name = null,
        string|null      $value = null,
        bool|string|null $readonly = null,
        bool|string|null $required = null,
        bool|string|null $disabled = null,
        string|null      $style = null,
        array            $attributes = null
    ): self
    {
        $attributes = array_merge($attributes ?? [], [
            'label' => Label::create($label, $id),
            'type' => InputTypeEnum::TIME,
            'name' => $name,
            'value' => $value,
            'readonly' => $readonly,
            'required' => $required,
            'disabled' => $disabled,
        ]);
        $this->input(...$attributes)->setId($id)->setClass($class)->setStyle($style)->populateAttributes($attributes);
        return $this;
    }

    public function inputUrl(
        string|null      $label = null,
        string|null      $id = null,
        string|null      $class = null,
        string|null      $name = null,
        string|null      $value = null,
        string|null      $placeholder = null,
        bool|string|null $readonly = null,
        bool|string|null $required = null,
        bool|string|null $disabled = null,
        string|null      $style = null,
        array            $attributes = null
    ): self
    {
        $attributes = array_merge($attributes ?? [], [
            'label' => Label::create($label, $id),
            'type' => InputTypeEnum::URL,
            'name' => $name,
            'value' => $value,
            'placeholder' => $placeholder,
            'readonly' => $readonly,
            'required' => $required,
            'disabled' => $disabled,
        ]);
        $this->input(...$attributes)->setId($id)->setClass($class)->setStyle($style)->populateAttributes($attributes);
        return $this;
    }

    public function inputWeek(
        string|null      $label = null,
        string|null      $id = null,
        string|null      $class = null,
        string|null      $name = null,
        string|null      $value = null,
        bool|string|null $readonly = null,
        bool|string|null $required = null,
        bool|string|null $disabled = null,
        string|null      $style = null,
        array            $attributes = null
    ): self
    {
        $attributes = array_merge($attributes ?? [], [
            'label' => Label::create($label, $id),
            'type' => InputTypeEnum::WEEK,
            'name' => $name,
            'value' => $value,
            'readonly' => $readonly,
            'required' => $required,
            'disabled' => $disabled,
        ]);
        $this->input(...$attributes)->setId($id)->setClass($class)->setStyle($style)->populateAttributes($attributes);
        return $this;
    }

    public function select(
        string|null      $label = null,
        string|null      $id = null,
        string|null      $class = null,
        string|null      $name = null,
        string|null      $value = null,
        string|bool|null $required = null,
        string|bool|null $disabled = null,
        string|bool|null $multiple = null,
        string|int|null  $size = null,
        string|bool|null $autofocus = null,
        string|null      $style = null,
        array            $attributes = null
    ): self
    {
        $this->elementIndex = count($this->elements);

        if ($label !== null) {
            $this->labels[$this->elementIndex] = Label::create($label, $id);
        }

        $this->elements[$this->elementIndex] = Select::create(
            $name, $required, $disabled, $multiple, $size, $autofocus
        )->setId($id)->setClass($class)->setStyle($style)->populateAttributes($attributes);

        if ($value !== null) {
            $this->optionsSelected[$this->elementIndex] = $value;
        }

        return $this;
    }

    public function addOptions(array $options, &$element = null): self
    {
        $optgroup = [];

        foreach ($options as $index => $option) {
            if (is_array($option)) {
                $optgroup[$index] = [];
                $this->addOptions($option, $optgroup[$index]);
                $this->optionsSelect[$this->elementIndex][$index] = OptGroup::create($index, null, $optgroup[$index]);
            } elseif ($element !== null) {
                $element[] = Option::create(
                    $option,
                    $index,
                    $this->optionsSelected[$this->elementIndex] == $index ? true : null
                );
            } else {
                $this->optionsSelect[$this->elementIndex][$index] = Option::create(
                    $option,
                    $index,
                    $this->optionsSelected[$this->elementIndex] == $index ? true : null
                );
            }
        }

        return $this;
    }

    public function button(
        string|null                $text = null,
        string|null                $id = null,
        string|null                $class = null,
        string|null                $name = null,
        ButtonTypeEnum|string|null $type = ButtonTypeEnum::SUBMIT,
        string|bool|null           $disabled = null,
        string|null                $value = null,
        string|null                $style = null,
        array                      $attributes = null
    ): self
    {
        $this->elementIndex = count($this->elements);

        $this->elements[$this->elementIndex] = Button::create(
            $text,
            $name,
            $type,
            $disabled,
            $value
        )->setId($id)->setClass($class)->setStyle($style)->populateAttributes($attributes);

        return $this;
    }

    private function input(
        Label|null                          $label = null,
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
    ): Input|array
    {
        $this->elementIndex = count($this->elements);

        if ($label !== null) {
            $this->labels[$this->elementIndex] = $label;
        }

        $label = null;

        if (is_array($this->options)) {
            $input = [];
            foreach ($this->options as $strOrIndex => $option) {
                if (is_string($strOrIndex) && !is_numeric($strOrIndex)) {
                    $label[] = Label::create($strOrIndex);
                }
                $input[] = Input::create(
                    $type,
                    $name,
                    $option ?? $value,
                    $placeholder,
                    $readonly,
                    in_array($option, $this->options) && $required ? 'required' : $required,
                    $multiple,
                    in_array($option, $this->options) && $disabled ? 'disabled' : $disabled,
                    in_array($option, $this->options) && ($checked || $option == $value) ? 'checked' : $checked,
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
            $this->options = null;
        } else {
            $input = Input::create(
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

        $this->elements[$this->elementIndex] = $input;

        if ($label) {
            $this->labelsForInputCheckRadio[$this->elementIndex] = $label;
        }

        return $this->elements[$this->elementIndex];
    }

    public function addClassLabel(string $classes): self
    {
        $this->classLabel[$this->elementIndex] = $classes;
        return $this;
    }

    public function addClassElement(string $classes): self
    {
        $this->classElement[$this->elementIndex] = $classes;
        return $this;
    }

    public function addParent(string $classes, string|null $childrenClasses = null): self
    {
        $this->parents[$this->elementIndex] = $classes;
        if ($childrenClasses) {
            $this->children[$this->elementIndex] = $childrenClasses;
        }
        return $this;
    }

    /**
     * @throws DOMException
     */
    private function prepareForm(): void
    {
        $this->form = $this->dom->createElement(TagEnum::Form->value);
        $this->reflection($this->form, false);
    }

    /**
     * @throws DOMException
     */
    /**
     * Structura o formulário com elementos, pais e filhos, gerando a hierarquia necessária.
     *
     * @return void
     * @throws DOMException
     */
    public function structureTheForm(): void
    {
        if (empty($this->elements)) {
            return;
        }

        foreach ($this->elements as $index => $input) {
            $tagParent = $this->createTagParent($index);
            $tagChildren = $this->createTagChildren($index);

            //$this->labelsForInputCheckRadio[$index]

            $existsAnotherLabel = key_exists($index, $this->labelsForInputCheckRadio);

            // Processa o rótulo
            $this->processLabel($index, $tagParent, $tagChildren, $existsAnotherLabel);

            if ($input instanceof Input || is_array($input)) {
                // Processa os inputs
                $this->processInputs($input, $index, $tagParent, $tagChildren, $existsAnotherLabel);
            } elseif ($input instanceof Button) {
                // Processa os selects
                $this->processButtons($input, $index, $tagParent, $tagChildren);
            } else {
                // Processa os selects
                $this->processSelects($input, $index, $tagParent, $tagChildren);
            }

            // Adiciona os filhos ao pai, se existir
            if ($tagChildren) {
                $tagParent->appendChild($tagChildren);
                $this->form->appendChild($tagParent);
            } elseif ($tagParent) {
                $this->form->appendChild($tagParent);
            }
        }
    }

    /**
     * Cria a tag pai se existir.
     *
     * @param int $index
     * @return DOMElement|null
     * @throws DOMException
     */
    private function createTagParent(int $index): ?DOMElement
    {
        if (key_exists($index, $this->parents)) {
            $tagParent = $this->dom->createElement(TagEnum::Div->value);
            $tagParent->setAttribute('class', $this->parents[$index]);
            return $tagParent;
        }
        return null;
    }

    /**
     * Cria a tag filho se existir.
     *
     * @param int $index
     * @return DOMElement|null
     * @throws DOMException
     */
    private function createTagChildren(int $index): ?DOMElement
    {
        if (key_exists($index, $this->children)) {
            $tagChildren = $this->dom->createElement(TagEnum::Div->value);
            $tagChildren->setAttribute('class', $this->children[$index]);
            return $tagChildren;
        }
        return null;
    }

    /**
     * Processa o rótulo associado ao índice.
     *
     * @param int $index
     * @param DOMElement|null $tagParent
     * @param DOMElement|null $tagChildren
     * @param bool $existsAnotherLabel
     * @return void
     * @throws DOMException
     */
    private function processLabel(int $index, ?DOMElement $tagParent, ?DOMElement $tagChildren, bool $existsAnotherLabel = false): void
    {
        if (key_exists($index, $this->labels)) {
            $labelTag = $this->labels[$index]->element($this->dom, TagEnum::Label->value, $existsAnotherLabel);

            if (key_exists($index, $this->classLabel)) {
                $labelTag->setAttribute('class', $this->classLabel[$index]);
            }

            // Adiciona o rótulo na tag correta
            if ($tagChildren) {
                $tagChildren->appendChild($labelTag);
            } elseif ($tagParent) {
                $tagParent->appendChild($labelTag);
            } else {
                $this->form->appendChild($labelTag);
            }
        }
    }

    /**
     * Processa os inputs associados ao índice.
     *
     * @param Input|Input[] $input
     * @param int $index
     * @param DOMElement|null $tagParent
     * @param DOMElement|null $tagChildren
     * @param bool $existsAnotherLabel
     * @return void
     * @throws DOMException
     */
    private function processInputs(Input|array $input, int $index, ?DOMElement $tagParent, ?DOMElement $tagChildren, bool $existsAnotherLabel = false): void
    {
        $inputs = is_array($input) ? $input : [$input];

        foreach ($inputs as $iterator => $inputElement) {
            $inputTag = $inputElement->element($this->dom, TagEnum::Input->value);

            if (key_exists($index, $this->classElement)) {
                $inputTag->setAttribute('class', $this->classElement[$index]);
            }

            $labelTag = null;

            if ($existsAnotherLabel && isset($this->labelsForInputCheckRadio[$index][$iterator])) {
                $label = $this->labelsForInputCheckRadio[$index][$iterator];
                $label->setFor($inputElement->getId());
                $labelTag = $label->element($this->dom, TagEnum::Label->value);
            }

            // Adiciona o input na tag correta
            if ($tagChildren) {
                if ($labelTag) {
                    $tagChildren->appendChild($labelTag);
                }
                $tagChildren->appendChild($inputTag);
            } elseif ($tagParent) {
                if ($labelTag) {
                    $tagParent->appendChild($labelTag);
                }
                $tagParent->appendChild($inputTag);
            } else {
                if ($labelTag) {
                    $this->form->appendChild($labelTag);
                }
                $this->form->appendChild($inputTag);
            }
        }
    }

    /**
     * Processa os selects associados ao índice.
     *
     * @param Select $select
     * @param int $index
     * @param DOMElement|null $tagParent
     * @param DOMElement|null $tagChildren
     * @return void
     * @throws DOMException
     */
    private function processSelects(Select $select, int $index, ?DOMElement $tagParent, ?DOMElement $tagChildren): void
    {
        $selectTag = $select->element($this->dom, TagEnum::Select->value);

        if (key_exists($index, $this->classElement)) {
            $selectTag->setAttribute('class', $this->classElement[$index]);
        }

        if (key_exists($index, $this->optionsSelect)) {
            foreach ($this->optionsSelect[$index] as $option) {
                $selectTag->appendChild($option->element($this->dom, $option instanceof OptGroup ? TagEnum::Optgroup->value : TagEnum::Option->value));
            }
        }

        // Adiciona o select na tag correta
        if ($tagChildren) {
            $tagChildren->appendChild($selectTag);
        } elseif ($tagParent) {
            $tagParent->appendChild($selectTag);
        } else {
            $this->form->appendChild($selectTag);
        }
    }

    /**
     * Processa os buttons associados ao índice.
     *
     * @param Button $button
     * @param int $index
     * @param DOMElement|null $tagParent
     * @param DOMElement|null $tagChildren
     * @return void
     * @throws DOMException
     */
    private function processButtons(Button $button, int $index, ?DOMElement $tagParent, ?DOMElement $tagChildren): void
    {
        $buttonTag = $button->element($this->dom, TagEnum::Button->value);

        if (key_exists($index, $this->classElement)) {
            $buttonTag->setAttribute('class', $this->classElement[$index]);
        }

        // Adiciona o select na tag correta
        if ($tagChildren) {
            $tagChildren->appendChild($buttonTag);
        } elseif ($tagParent) {
            $tagParent->appendChild($buttonTag);
        } else {
            $this->form->appendChild($buttonTag);
        }
    }

    /**
     * @throws DOMException
     */
    public function render(): string
    {
        $this->prepareForm();
        $this->structureTheForm();
        $this->dom->appendChild($this->form);
        return $this->dom->saveHTML();
    }

    /**
     * @throws DOMException
     */
    public function __toString(): string
    {
        return $this->render();
    }
}