<?php

namespace STA\Populate;

use STA\Config\Config;
use STA\STAException;
use STA\Storage\ProductStorage;

class Populate
{
    /**
     * Populate the database with products defined in a json file.
     * The file name is on POPULATE config on the env configs.
     * @return array Array of SKUs of the saved products
     * @throws STAException
     */
    public static function populate(): array
    {
        $path = self::getDataPath();
        $data = self::getDataFromFile($path);
        return self::saveProducts($data);
    }


    /**
     * It builds the path to the populate file on "sta" (app folder)
     * folder and with filename described on POPULATE config on the env configs.
     * @return string The absolute path to the populate file
     */
    private static function getDataPath(): string
    {
        return '/app/' . getEnv('POPULATE');
    }


    /**
     * Load a file content with file_get_contents and decode the file with
     * json_decode with associative mode on and return this parsed data.
     * @param string $file The path to the data file
     * @return array The json decoded data from the file
     */
    private static function getDataFromFile(string $file): array
    {
        return json_decode(file_get_contents($file), true);
    }

    /**
     * Save all given products to the database and return all sku of these products.
     * @param array $products Array of Products data to be saved on database
     * @return array Array of SKUs of the saved products
     * @throws STAException
     */
    private static function saveProducts(array $products): array
    {
        $saved = array();
        foreach ($products as $data) {
            ProductStorage::addProduct(...$data);
            $saved[] = $data['sku'];
        }
        return $saved;
    }
}