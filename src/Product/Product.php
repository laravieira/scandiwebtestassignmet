<?php

namespace STA\Product;

abstract class Product
{
    public string $type;
    public string $sku;
    public string $name;
    public float $price;

    abstract public function __construct();
    abstract public function __set(string $name, mixed $value): void;
}