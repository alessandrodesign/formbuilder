<?php

namespace AlessandroDesign\FormBuilder\Enums;

enum TagEnum: string
{
    case Form = 'form';
    case Select = 'select';
    case Optgroup = 'optgroup';
    case Option = 'option';
    case Input = 'input';
    case Label = 'label';
    case Div = 'div';
    case Button = 'button';
}
