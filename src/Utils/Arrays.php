<?php

namespace AlessandroDesign\FormBuilder\Utils;

class Arrays
{
    public static function isMultidimensionalArray(array $array): bool
    {
        foreach ($array as $element) {
            if (is_array($element)) {
                return true; // É multidimensional
            }
        }
        return false; // É unidimensional
    }
}