<?php

namespace Bytecraftnz\SupabasePhp\Responses;

use Bytecraftnz\SupabasePhp\Models\GenerateLinkProperties;
use Bytecraftnz\SupabasePhp\Models\User;
use Bytecraftnz\SupabasePhp\Models\AuthError;


class GenerateLinkResponse
{
    private GenerateLinkProperties $properties;
    private User $user;
    private AuthError $auth;
    
    public function __construct( 
        private array $data
    ) {
        $this->properties = new GenerateLinkProperties($data['properties'] ?? []);
        $this->user = new User($data['user'] ?? []);
        $this->auth = new AuthError($data['auth'] ?? []);
    }

    public function getProperties(): GenerateLinkProperties
    {
        return $this->properties;
    }
    public function getUser(): User
    {
        return $this->user;
    }
    public function getAuthError(): AuthError
    {
        return $this->auth;
    }


    public function toArray(): array
    {
        return [
            'properties' => $this->properties->toArray(),
            'user' => $this->user->toArray(),
            'auth' => $this->auth->toArray(),
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
