<?php

namespace STA\Storage;

use PDO;
use STA\Config\Config;

class Database
{
    const PRODUCTS_TABLE = 'products';
    const PRODUCTS_ID_FIELD = 'sku';
    const ORDER_DESC = 'DESC';
    const ORDER_ASC = 'ASC';

    private static Database|null $database = null;
    private PDO $connection;

    /**
     * Return a database instance ready to use on the MySQL server.
     * @return Database An database instance
     */
    public static function getDB(): Database
    {
        if(self::$database)
            return self::$database;
        return self::$database = new Database();
    }

    /**
     * Load the instance to the MySQL server and return a read to use
     * instance of Database.
     */
    public function __construct()
    {
        $host = getEnv('DATABASE_HOST');
        $name = getEnv('DATABASE_NAME');
        $user = getEnv('DATABASE_USER');
        $pass = getEnv('DATABASE_PASS');

        $dsn = 'mysql:host=' . $host . ';dbname=' . $name;
        $this->connection = new PDO($dsn, $user, $pass);
    }

    /**
     * Select all objects from the given table on the database with
     * a given order on the given column.
     *
     * This function auto assign the class on the first column on the
     * database and populate the objects after the __construct was
     * called. using these PDO props:
     * PDO::FETCH_CLASS, PDO::FETCH_CLASSTYPE, PDO::FETCH_PROPS_LATE
     *
     * The default values is to return the list of all products of
     * the database ordered descending by sku column.
     * @param string $table The database table to get the data from
     * @param string $orderBy The column name to order by
     * @param string $order The order type, Database constants
     * @return array All the objects in a array
     */
    public function selectAll(
        string $table=self::PRODUCTS_TABLE,
        string $orderBy=self::PRODUCTS_ID_FIELD,
        string $order=self::ORDER_DESC,
    ): array {
        $query = "SELECT * FROM $table ORDER BY $orderBy $order;";
        $data = $this->connection->query($query);
        return $data->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_CLASSTYPE | PDO::FETCH_PROPS_LATE);
    }

    /**
     * Insert data to the database using statements.
     * By default, the table is PRODUCTS_TABLE const.
     * @param mixed $data The data ordered as the columns to be saved
     * @param string $table The database table to save data
     * @return bool If the data as saved
     */
    public function insert(
        mixed $data,
        string $table=self::PRODUCTS_TABLE,
    ): bool {
        $binds = str_repeat('?,', count($data) - 1) . '?';
        $query = "INSERT IGNORE INTO $table VALUES($binds);";
        $stmt = $this->connection->prepare($query);
        return $stmt->execute(array_values($data));
    }

    /**
     * Delete objects from the database with the given keys
     * By default, the table is PRODUCTS_TABLE const and the
     * column key is the PRODUCTS_ID_FIELD const.
     * @param array $keys The array of object ids to delete
     * @param string $column The column of the ids on the table
     * @param string $table The table to delete from
     * @return bool If the objects was deleted
     */
    public function delete(
        array $keys,
        string $column=self::PRODUCTS_ID_FIELD,
        string $table=self::PRODUCTS_TABLE,
    ): bool {
        $binds = str_repeat('?,', count($keys) - 1) . '?';
        $query = "DELETE FROM $table WHERE $column IN($binds);";
        $stmt = $this->connection->prepare($query);
        return $stmt->execute($keys);
    }
}