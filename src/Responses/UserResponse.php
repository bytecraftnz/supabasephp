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
    
}