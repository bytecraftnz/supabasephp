<?php

namespace Bytecraftnz\SupabasePhp\Laravel\Models;

use Bytecraftnz\SupabasePhp\Responses\AuthResponse;

class User implements \Illuminate\Contracts\Auth\Authenticatable
{
    private $authIdentifier;
    private $authPassword;
    private $rememberToken;

    public function __construct(array $attributes = [])
    {
        $this->authIdentifier = $attributes['authIdentifier'] ?? null;
        $this->authPassword = $attributes['authPassword'] ?? null;
        $this->rememberToken = $attributes['rememberToken'] ?? null;
    }


    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return $this->authIdentifier;
    }

    public function getAuthPasswordName()
    {
        return 'password';
    }

    public function getAuthPassword()
    {
        return $this->authPassword;
    }

    public function getRememberToken()
    {
        return $this->rememberToken;
    }

    public function setRememberToken($value)
    {
        $this->rememberToken = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }


    public static function fromSupavalRequest(AuthResponse $auth_response, string $password): self
    {

        $user = $auth_response->getUser();

        return new self([
            'authIdentifier' => $user->getId(),
            'authPassword' => $password,
            'rememberToken' => '',
        ]);
    }
}