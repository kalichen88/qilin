<?php
declare(strict_types=1);

namespace App\Exception;

use RuntimeException;

class BusinessException extends RuntimeException
{
    public function __construct(string $message, int $code = 1000)
    {
        parent::__construct($message, $code);
    }
}
