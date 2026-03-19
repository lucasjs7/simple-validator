<?php

namespace Lucasjs7\SimpleValidator;

use Exception;
use Throwable;
use Lucasjs7\SimpleValidator\Language\Language as Lng;

class ValidatorException extends Exception {

    /**
     * @var array<int, string|int>
     */
    private readonly array $errorPath;

    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param array<int, string|int> $errorPath
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
     * @return array<int, string|int>
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
