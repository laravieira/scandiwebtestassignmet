<?php

// Hi... I hope you got this STA thing...
// If not, sorry, STA is standard for Scandiweb Test Assignment
// I still hoping you like my code. : ]

namespace STA;

use STA\Config\Config;
use STA\Connection\Router;
use STA\Connection\Routes;

require 'Autoload.php';

// Sorry... but... I need these three procedural lines to start the application
new Autoload();
Routes::loadRoutes(new Router())->call($_SERVER['REQUEST_URI']);

