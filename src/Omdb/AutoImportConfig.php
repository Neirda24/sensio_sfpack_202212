<?php

declare(strict_types=1);

namespace App\Omdb;

class AutoImportConfig
{
    private ?bool $forceImport = null;

    public function __construct(
        private readonly bool $autoImportEnabled = false,
    ) {
    }

    public function skip(): void
    {
        $this->forceImport = false;
    }

    public function restore(): void
    {
        $this->forceImport = null;
    }

    public function getValue(): bool
    {
        return $this->forceImport ?? $this->autoImportEnabled;
    }
}
