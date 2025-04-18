<?php 

namespace Bytecraftnz\SupabasePhp\Models;

use Bytecraftnz\SupabasePhp\Models\UserMetadata;


class UserIdentity{

    private string $identity_id;
    private string $id;
    private string $user_id;
    private UserMetadata $identity_data;
    private string $provider;
    private string $last_sign_in_at;
    private string $created_at;
    private string $updated_at;
    private string $email;

    public function __construct(
        object $data
    ) {
        $this->id = $data->id ?? '';
        $this->user_id = $data->user_id ?? '';
        $this->identity_data = UserMetadata::fromObject($data->identity_data ?? []);
        $this->identity_id = $data->identity_id ?? '';
        $this->provider = $data->provider ?? '';
        $this->created_at = $data->created_at ?? '';
        $this->last_sign_in_at = $data->last_sign_in_at ?? '';
        $this->updated_at = $data->updated_at ?? '';
        $this->email = $data->email ?? '';
    }


    public function getId(): string
    {
        return $this->id;
    }
    public function getUserId(): string
    {
        return $this->user_id;
    }
    public function getIdentityData(): UserMetadata
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
    public function getEmail(): string
    {
        return $this->email;
    }
    
    public static function fromObject(object $data): self
    {
        return new self($data);
    }

}