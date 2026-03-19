<?php

namespace Lucasjs7\SimpleValidator;

use Exception;
use Throwable;
use Lucasjs7\SimpleValidator\Language\Language as Lng;

class ValidatorException extends Exception {

    /**
     * @var array<string|int, mixed>
     */
    private readonly array $errorPath;

    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param array<string|int, mixed> $errorPath
     */
    public function __construct(
        string     $message = '',
        int        $code = 0,
        ?Throwable $previous = null,
        array      $errorPath = [],
    ) {
        parent::__construct($message, $code, $previous);
        $this->errorPath = $errorPath;
    }

    /**
     * @return array<string|int, mixed>
     */
    public function getErrorPath(): array {
        return $this->errorPath;
    }

    public function debug(): void {
        Core::exitError(
            title: 'ValidatorException',
            message: Lng::get('exception.debug'),
            exception: $this,
            backtrace: true,
        );
    }
}
