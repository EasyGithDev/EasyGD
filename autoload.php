<?php

function easy_autoload($classname)
{
    $classname = array_pop(explode('\\', $classname));
    $classname = __DIR__ . '/src/' . strtolower($classname) . '.php';
    if (file_exists($classname))
        require_once $classname;
}

spl_autoload_register('easy_autoload');
