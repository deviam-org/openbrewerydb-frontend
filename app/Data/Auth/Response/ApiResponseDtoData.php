<?php

declare(strict_types=1);

namespace App\Data\Auth\Response;

use Spatie\LaravelData\Data;

final class ApiResponseDtoData extends Data
{
    public function __construct(
        public readonly bool $success,
        public readonly string $message,
        public readonly ?array $data,
        public readonly ?array $meta,
        public readonly ?string $error,
        public readonly ?array $errors,
    ) {}
}
