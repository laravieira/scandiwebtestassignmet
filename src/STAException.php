<?php

namespace STA;

use DateTime;
use Exception;

class STAException extends Exception
{
    /**
     * Returns basic error data to be printed to json reader clients.
     * @return array Basic data to be printed to json clients
     */
    public function respond(): array
    {
        return array(
            'error' => true,
            'code' => $this->getCode(),
            'message' => $this->getMessage(),
            'date' => (new DateTime('now'))->format('r'),
        );
    }
}