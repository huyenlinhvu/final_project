<?php
declare(strict_types=1);
namespace Services\Exception;
require_once '../autoload.php';

use Exception;

class RouteNotFoundException extends Exception
{
    public function __construct()
    {
        $this->message = "Error: Page doesn't exist";
        $this->code = 404;
    }
}