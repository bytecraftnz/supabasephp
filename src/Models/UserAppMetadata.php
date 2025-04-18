<?php

namespace Bytecraftnz\SupabasePhp\Models;


class UserAppMetadata{
    private string $provider;
    private array $data;

    public function __construct(        
        array $data
    ) {
        $this->provider = $data['provider'] ?? '';
        $this->data = $data['data'] ?? [];
    }
    public function getProvider(): string
    {
        return $this->provider;
    }
    public function getData(): array
    {
        return $this->data;
    }
    public function toArray(): array
    {
        return [
            'provider' => $this->provider,
            'data' => $this->data,
        ];
    }
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
    public function fromArray(array $data): self
    {
        return new self($data);
    }
    public function fromJson(string $json): self
    {
        $data = json_decode($json, true);
        return new self($data);
    }
    public function __toString(): string
    {
        return json_encode($this->toArray());
    }
}