<?php 

namespace Bytecraftnz\SupabasePhp\Models;

class UserIdentity{
    private string $id;
    private string $user_id;
    private array $identity_data;
    private string $identity_id;
    private string $provider;
    private string $created_at;
    private string $last_sign_in_at;
    private string $updated_at;

    public function __construct(
        array $data
    ) {
        $this->id = $data['id'] ?? '';
        $this->user_id = $data['user_id'] ?? '';
        $this->identity_data = $data['identity_data'] ?? [];
        $this->identity_id = $data['identity_id'] ?? '';
        $this->provider = $data['provider'] ?? '';
        $this->created_at = $data['created_at'] ?? '';
        $this->last_sign_in_at = $data['last_sign_in_at'] ?? '';
        $this->updated_at = $data['updated_at'] ?? '';
    }


    public function getId(): string
    {
        return $this->id;
    }
    public function getUserId(): string
    {
        return $this->user_id;
    }
    public function getIdentityData(): array
    {
        return $this->identity_data;
    }
    public function getIdentityId(): string
    {
        return $this->identity_id;
    }
    public function getProvider(): string
    {
        return $this->provider;
    }
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }
    public function getLastSignInAt(): string
    {
        return $this->last_sign_in_at;
    }
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'identity_data' => $this->identity_data,
            'identity_id' => $this->identity_id,
            'provider' => $this->provider,
            'created_at' => $this->created_at,
            'last_sign_in_at' => $this->last_sign_in_at,
            'updated_at' => $this->updated_at,
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