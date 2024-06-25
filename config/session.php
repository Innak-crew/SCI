<?php

use Illuminate\Support\Str;

return array(
    'driver' => 'database',
    'lifetime' => 120,
    'expire_on_close' => true,
    'files' => storage_path().'/sessions',
    'connection' => 'mysql',
    'table' => 'sessions',
    'lottery' => array(2, 100),
    'cookie' => 'laravel_session',
    'path' => '/',
    'domain' => null,
    'secure' => false,
   );
