<?php

namespace Bytecraftnz\SupabasePhp\Responses;

use Bytecraftnz\SupabasePhp\Models\AuthError;
use DateTime;
use Illuminate\Support\Facades\Date;
use Bytecraftnz\SupabasePhp\Models\User;

class AuthResponse
{
    private string $accessToken;
    private string $tokenType;
    private int $expiresIn;
    private DateTime $expiresAt;
    private string $refreshToken;

    private User $user;

    private ?AuthError $authError;

    public function __construct(
        private object $data
    ) {
        $this->authError = null;

        if(isset($data->error)) {
            $this->authError = new AuthError($data->error);
        } 

        
        $this->accessToken = $data->access_token ?? '';
        $this->tokenType = $data->token_type ?? '';
        $this->expiresIn = $data->expires_in ?? 0;
        $this->expiresAt = Date::createFromTimestamp($data->expires_at ?? 0);
        $this->refreshToken = $data->refresh_token ?? '';

        $this->user = User::fromObject($data->user ?? null);

    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }
    public function getTokenType(): string
    {
        return $this->tokenType;
    }
    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }
    public function getExpiresAt(): DateTime
    {
        return $this->expiresAt;
    }

    public function isExpired(): bool
    {
        return $this->expiresAt < new DateTime();
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }
    
    public function getUser(): User
    {
        return $this->user;
    }

    public static function fromObject(object $data): self
    {
        return new self($data);
    }


}