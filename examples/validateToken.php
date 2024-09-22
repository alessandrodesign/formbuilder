<?php

use AlessandroDesign\FormBuilder\Form;

require_once implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'vendor', 'autoload.php']);

try {
    $response = Form::validateToken();
} catch (\Psr\SimpleCache\InvalidArgumentException $e) {
    $response = $e->getMessage();
} catch (\Random\RandomException $e) {
    $response = $e->getMessage();
}
dd($response);