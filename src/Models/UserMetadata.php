<?php

namespace Bytecraftnz\SupabasePhp\Models;



class UserMetadata
{
    private array $data;
    private string $email;
    private bool $email_verified;
    private bool $phone_verified;
    private string $sub;

    public function __construct(
        object $userMetadata
    ) {
        
        $this->data = (array) isset($userMetadata->data) ? $userMetadata->data : [];        
        $this->email = $userMetadata->email ?? '';
        $this->email_verified = $userMetadata->email_verified ?? false;
        $this->phone_verified = $userMetadata->phone_verified ?? false;
        $this->sub = $userMetadata->sub ?? '';
    }


    public function getData(): array
    {
        return $this->data;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function isEmailVerified(): bool
    {
        return $this->email_verified;
    }
    public function isPhoneVerified(): bool
    {
        return $this->phone_verified;
    }
    public function getSub(): string
    {
        return $this->sub;
    }

    public static function fromObject(object $userMetadata): self
    {
        return new self($userMetadata ?? (object)[]);
    }
}