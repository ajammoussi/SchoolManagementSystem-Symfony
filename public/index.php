<?php

use App\Kernel;

// Adjust the path to autoload_runtime.php if needed
require_once __DIR__ . '/../vendor/autoload_runtime.php';

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
