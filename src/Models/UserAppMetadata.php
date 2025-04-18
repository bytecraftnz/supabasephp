<?php

namespace Bytecraftnz\SupabasePhp\Models;


class UserAppMetadata{
    private string $provider;
    private array $providers;

    public function __construct(        
        object $data
    ) {
        $this->provider = $data->provider ?? '';
        $this->providers = (array) $data->providers ?? [];
    }
    public function getProvider(): string
    {
        return $this->provider;
    }
    public function getProviders(): array
    {
        return $this->providers;
    }

    public static function fromObject(object $data): self
    {
        return new self($data);
    }   
}