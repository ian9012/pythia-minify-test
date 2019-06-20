<?php
declare(strict_types=1);

namespace App\Exception;

use DomainException;
use Zend\ProblemDetails\Exception\CommonProblemDetailsExceptionTrait;
use Zend\ProblemDetails\Exception\ProblemDetailsExceptionInterface;

class RuntimeException extends DomainException implements ProblemDetailsExceptionInterface
{
    use CommonProblemDetailsExceptionTrait;

    public static function create(string $message) : self
    {
        $e = new self($message);
        $e->status = 404;
        $e->detail = $message;
        $e->type = '/api/doc/runtime-error';
        $e->title = 'Please contact me';
        return $e;
    }
}
