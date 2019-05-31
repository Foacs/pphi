<?php
/**
 * Created by PhpStorm.
 * User: dederobert
 * Date: 31/05/19
 * Time: 14:50
 */

namespace PPHI\Exception\Connector;

use PPHI\Connector\ConnectorError;
use Throwable;

class ConnectionException extends \Exception
{
    public function __construct(string $message = "", ConnectorError $error = null, int $code = 0, Throwable $previous = null)
    {
        if ($error !== null) {
            $message .= "(Error : " . $error->getMessage() . ")";
        }
        parent::__construct($message, $code, $previous);
    }
}
