<?php


namespace STA\Product;

class Furniture extends Product
{
    public float $height;
    public float $width;
    public float $length;


    /**
     * Load a Furniture instance and make sure to specify its type property
     */
    public function __construct(){
        $this->type = $this::class;
    }

    /**
     * Parse the database string, extract and convert all data on it
     * then assign it to proper Furniture properties.
     *
     * As described on the STA Notion, this string has the data separated
     * by 'x' character and contains the data height, width, length, respectively.
     * @param string $detail The compact database string.
     */
    private function parseDetail(string $detail): void {
        $dimension = explode('x', $detail);
        $this->height = floatval($dimension[0]);
        $this->width = floatval($dimension[1]);
        $this->length = floatval($dimension[2]);
    }

    /**
     * Used to PDO assign the detail data to the right Furniture properties.
     * @param string $name Furniture property name
     * @param mixed $value Furniture property value
     */
    public function __set(string $name, mixed $value): void
    {
        if($name == 'detail')
            $this->parseDetail($value);
    }
}