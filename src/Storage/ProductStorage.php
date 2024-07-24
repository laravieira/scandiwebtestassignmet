<?php

namespace STA\Storage;

use STA\Connection\InputValidator;
use STA\Product\Product;
use STA\STAException;

class ProductStorage
{

    /**
     * Return an array with all products load from the database ordered
     * descending on 'sku' key by default. This array has all products
     * parsed to they specific class. (Not stdClass)
     * @return array All product objects on the database
     */
    public static function listProducts(): array
    {
        return Database::getDB()->selectAll();
    }

    /**
     * Add a product to the database by its given data.
     * @param string $sku SKU id of a product
     * @param string $name Product's name
     * @param string $price Product's price
     * @param string $type Product's type
     * @param mixed ...$specs All others product specific data
     * @return bool If the product was saved on the database
     * @throws STAException If any field is missing
     */
    public static function addProduct(
        string $sku,
        string $name,
        string $price,
        string $type,
        mixed ...$specs
    ): bool {
        InputValidator::checkValues($sku, $name, $price, $type);
        return Database::getDB()->insert(array(
            'type' => '\\STA\Product\\'.$type,
            'sku' => $sku,
            'name' => $name,
            'price' => $price,
            'detail' => implode('x', $specs)
        ));
    }

    /**
     * Mass delete all products with the sku identifiers specified
     * on the skus parameter.
     * @param array $skus All sku ids of the products
     * @return bool If the products was deleted
     * @throws STAException If any field is missing
     */
    public static function deleteProducts(array $skus): bool
    {
        InputValidator::checkValues($skus, ['skus']);
        return Database::getDB()->delete($skus);
    }
}