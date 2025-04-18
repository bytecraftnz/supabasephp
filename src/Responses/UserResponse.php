<?php

namespace Bytecraftnz\SupabasePhp\Responses;
use Bytecraftnz\SupabasePhp\Models\AuthError;
use Bytecraftnz\SupabasePhp\Models\User;

class UserResponse
{
    private AuthError $auth;
    private User $user;

    public function __construct(
        private array $data
    ) {
        $this->auth = new AuthError($data['auth'] ?? []);
        $this->user = new User($data['user'] ?? []);
    }

    public function getAuth(): AuthError
    {
        return $this->auth;
    }
    public function getUser(): User
    {
        return $this->user;
    }
    public function toArray(): array
    {
        return [
            'auth' => $this->auth->toArray(),
            'user' => $this->user->toArray(),
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
}