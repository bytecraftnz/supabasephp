<?php

namespace Bytecraftnz\SupabasePhp\Models;

use Bytecraftnz\SupabasePhp\Responses\AuthResponse;

class UserAccess
{
    private string $accessToken;
    private string $refreshToken;
    private string $expiresAt;
    private string $tokenType;
    private string $expiresIn;

    public function __construct(
        object $data
    ) {
        $this->accessToken = $data->access_token ?? '';
        $this->refreshToken = $data->refresh_token ?? '';
        $this->expiresAt = $data->expires_at ?? '';
        $this->tokenType = $data->token_type ?? '';
        $this->expiresIn = $data->expires_in ?? '';
    }
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }
    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }
    public function getExpiresAt(): string
    {
        return $this->expiresAt;
    }
    public function getTokenType(): string
    {
        return $this->tokenType;
    }
    public function getExpiresIn(): string
    {
        return $this->expiresIn;
    }
    public function isExpired(): bool
    {
        return $this->expiresAt < time();
    }
    public static function fromAuthResponse(AuthResponse $auth_response): self
    {
        return new self($auth_response);
    }
}