<?php declare(strict_types = 1);

use Tests\Toolkit\Bypass;

require __DIR__ . '/../vendor/autoload.php';

Bypass::bypassFinals();
Tests\Toolkit\Bypass::bypassReadonly();
