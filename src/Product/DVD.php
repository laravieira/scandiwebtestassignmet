<?php


namespace STA\Product;

class DVD extends Product
{
    public float $size;

    /**
     * Load a DVD instance and make sure to specify its type property
     */
    public function __construct()
    {
        $this->type = $this::class;
    }

    /**
     * Used to PDO assign the detail data to the right DVD property.
     * @param string $name DVD property name
     * @param mixed $value DVD property value
     */
    public function __set(string $name, mixed $value): void
    {
        if($name == 'detail')
            $this->size = floatval($value);
    }
}