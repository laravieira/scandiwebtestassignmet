<?php

namespace STA\Connection;

use STA\STAException;

class InputValidator
{
    /**
     * Check if all values of the given array are empty.
     * If any is empty then throw STAException.
     * @param mixed ...$params parameters to check
     * @throws STAException If any parameter is empty
     */
    public static function checkValues(mixed ...$params): void {
        foreach ($params as $key => $value) {
            if (empty($value))
                throw new STAException('The param '.$key.' are required!', 400);
        }
    }

    /**
     * Check if any of the given fields are missing or empty on the given params array.
     * If any is missing or empty then throw STAException.
     * @param array $params Array to be checked
     * @param array $fields Fields to search on the array
     * @throws STAException If any field is missing or empty
     */
    public static function checkParams(array $params, array $fields): void {
        foreach ($fields as $field) {
            if (empty($params[$field]))
                throw new STAException('The param '.$field.' are required!', 400);
        }
    }
}