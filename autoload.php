<?php

function __autoload($class)
{
    $parts = explode('\\', $class);
    require implode('/', $parts) . '.php';
}
