<?php

defined('APP_PATH') or define('APP_PATH', __DIR__.'/');

require_once APP_PATH.'autoload.php';

$user = new App\Models\User;
$user->setName('John Doe');
$user->setEmail('john.doe@example.com');

$a = new App\Models\ShoppingCart($user);
$a->addProduct('Apple', 4.95, 2);
$a->addProduct('Orange', 3.99, 1);
// echo $a->getTotalPrice();
$a->printInvoice();

$b = new App\Models\ShoppingCart($user);
$b->addProduct('Apple', 4.95, 3);
$b->removeProduct('Apple', 1);
// echo $b->getTotalPrice();