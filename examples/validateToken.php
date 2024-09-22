<?php

use AlessandroDesign\FormBuilder\Form;

require_once implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'vendor', 'autoload.php']);

try {
    if (Form::validateToken()) {
        $response = 'Token válido';
    } else {
        throw new \Exception('Token inválido');
    }
} catch (\Psr\SimpleCache\InvalidArgumentException $e) {
    $response = $e->getMessage();
} catch (\Random\RandomException $e) {
    $response = $e->getMessage();
} catch (\Exception $e) {
    $response = $e->getMessage();
}

echo $response;