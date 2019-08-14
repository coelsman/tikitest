<?php

namespace App\Models;

class ShoppingCart extends BaseModel
{
    public $user;

    public $products;

    public function __construct(User $user)
    {
        parent::__construct();

        $this->user = $user;
        $this->resetListProducts();
    }

    public function resetListProducts()
    {
        $this->products = array();
    }

    public function getProductItem($productName)
    {
        return isset($this->products[$productName])
            ? $this->products[$productName]
            : null;
    }

    public function addProduct($productName, $price, $quantity = 1)
    {
        if (!$item = $this->getProductItem($productName)) {
            $item = array(
                'name'     => $productName,
                'price'    => $price,
                'quantity' => 0
            );
        }

        $item['quantity'] += intval($quantity);

        $this->products[$productName] = $item;
    }

    public function removeProduct($productName, $quantity = 1)
    {
        if (!$item = $this->getProductItem($productName)) {
            return 'No product found';
        }

        $item['quantity'] -= intval($quantity);

        if ($item['quantity'] <= 0) {
            unset($this->products[$productName]);
            return;
        }

        $this->products[$productName] = $item;
    }

    public function getTotalPrice()
    {
        return array_sum(array_map(function ($item) {
            return $item['quantity'] * $item['price'];
        }, $this->products));
    }

    public function formatProductItemRow($name, $unitPrice, $quantity, $totalPrice)
    {
        return str_repeat(' ', 16) .
        $name . str_repeat(' ', 21 - strlen($name)) .
        str_repeat(' ', 8 - strlen($unitPrice)) . $unitPrice .
        str_repeat(' ', 4 - strlen($quantity)) . $quantity .
        str_repeat(' ', 6 - strlen($totalPrice)) . $totalPrice;
    }

    public function printCartDetails()
    {
        return implode("\n", array_map(function ($item) {
            return $this->formatProductItemRow(
                $item['name'],
                number_format($item['price'], 2),
                $item['quantity'],
                number_format($item['quantity'] * $item['price'], 2)
            );
        }, $this->products));
    }

    public function printInvoice()
    {
        echo sprintf("
            *******************************************
            *                 INVOICE                 *
            *******************************************

            **** ID
                %s

            **** CLIENT INFORMATION
                Name:          %s
                Email address: %s

            **** CART DETAILS\n%s

            TOTAL: $%s
        ",
            $this->id,
            $this->user->name,
            $this->user->email,
            $this->printCartDetails(),
            $this->getTotalPrice()
        );
    }
}
