<?php

namespace Bytecraftnz\SupabasePhp\Models;

use Bytecraftnz\SupabasePhp\GenerateLinkType;

class GenerateLinkProperties
{

    private string $action_link;
    private string $email_otp;
    private string $hashed_token;
    private string $redirect_to;
    private GenerateLinkType $verification_type;

    public function __construct(
       array $data
    )
    {
        $this->action_link = $data['action_link'] ?? '';
        $this->email_otp = $data['email_otp'] ?? '';
        $this->hashed_token = $data['hashed_token'] ?? '';
        $this->redirect_to = $data['redirect_to'] ?? '';
        $this->verification_type = GenerateLinkType::from($data['verification_type'] ?? '');
    }
    
    public function getActionLink(): string
    {
        return $this->action_link;
    }
    public function getEmailOtp(): string
    {
        return $this->email_otp;
    }
    public function getHashedToken(): string
    {
        return $this->hashed_token;
    }
    public function getRedirectTo(): string
    {
        return $this->redirect_to;
    }
    public function getVerificationType(): GenerateLinkType
    {
        return $this->verification_type;
    }
    public function toArray(): array
    {
        return [
            'action_link' => $this->action_link,
            'email_otp' => $this->email_otp,
            'hashed_token' => $this->hashed_token,
            'redirect_to' => $this->redirect_to,
            'verification_type' => $this->verification_type,
        ];
    }
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
    
    public function fromArray(array $data): self
    {
        return new self(
            $data['action_link'],
            $data['email_otp'],
            $data['hashed_token'],
            $data['redirect_to'],
            GenerateLinkType::from($data['verification_type'])
        );
    }
    
    public function fromJson(string $json): self
    {
        $data = json_decode($json, true);
        return $this->fromArray($data);
    }   
    
}
