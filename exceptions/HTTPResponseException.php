<?php

namespace Exception;

use stdClass;

class HTTPResponseException extends \Exception
{
    private stdClass $response;

    public function __construct(int $code = 0, \stdClass $response = null, string $message = '', \Throwable|null $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->response = $response;
    }

    public function getResponse(): stdClass
    {
        return $this->response;
    }
}
