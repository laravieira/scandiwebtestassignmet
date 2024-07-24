<?php

// This is an implementation of PSR-4, I hope I did it right. Based on that example:
// https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader-examples.md

namespace STA;

class Autoload
{
    const STA_PREFIX = 'STA\\';

    private string $basedir;
    private int $prefixLength;

    /**
     * Loads the autoload static vars and register the STA class
     * loader on the spl system, to automatically load STA classes.
     */
    public function __construct()
    {
        $this->basedir = $this->getSTABasePath();
        $this->prefixLength = strlen(self::STA_PREFIX);

        spl_autoload_register(array($this, 'loadSTAClass'));
    }

    /**
     * Loads an STA class by given your full qualified name.
     * @param string $class The full qualified STA class name to be loaded.
     */
    private function loadSTAClass(string $class): void
    {
        if(!str_starts_with($class, self::STA_PREFIX))
            return;

        $path = substr($class, $this->prefixLength);
        $path = str_replace('\\', '/', $path);
        $file = $this->basedir . $path . '.php';
        if (file_exists($file))
            require $file;
    }

    /**
     * It builds the path to the classes files on "/src"
     * folder. It's the absolute path to the STA namespace.
     * @return string The absolute path to the STA namespace
     */
    private function getSTABasePath(): string
    {
        return __DIR__ . '/src/';
    }

}
