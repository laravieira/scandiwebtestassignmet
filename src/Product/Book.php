<?php


namespace STA\Product;

class Book extends Product
{
    public float $weight;

    /**
     * Load a Book instance and make sure to specify its type property
     */
    public function __construct()
    {
        $this->type = $this::class;
    }

    /**
     * Used to PDO assign the detail data to the right Book property.
     * @param string $name Book property name
     * @param mixed $value Book property value
     */
    public function __set(string $name, mixed $value): void
    {
        if($name == 'detail')
            $this->weight = floatval($value);
    }
}