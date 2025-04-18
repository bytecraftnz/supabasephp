<?php

namespace Bytecraftnz\SupabasePhp\Models;

use Bytecraftnz\SupabasePhp\Models\UserAppMetadata;
use Bytecraftnz\SupabasePhp\Models\UserMetadata;

class User{
    private string $id;
    private UserAppMetadata $app_metadata;
    private UserMetadata $user_metadata;
    private string $aud;
    private string $confirmation_sent_at;
    private string $recovery_sent_at;
    private string $email_change_sent_at;
    private string $new_email;
    private string $new_phone;
    private string $invited_at;
    private string $action_link;
    private string $email;
    private string $phone;
    private string $created_at;
    private string $confirmed_at;
    private string $email_confirmed_at;
    private string $phone_confirmed_at;
    private string $last_sign_in_at;
    private string $role;
    private string $updated_at;
    private array $identities;
    private bool $is_anonymous;
    private bool $is_sso_user;
    private array $factors;


    public function __construct(
        object $data
    ) {
        $this->id = $data->id ?? '';
        $this->app_metadata = UserAppMetadata::fromObject($data->app_metadata);
        $this->user_metadata = UserMetadata::fromObject($data->user_metadata);
        $this->aud = $data->aud ?? '';
        $this->confirmation_sent_at = $data->confirmation_sent_at ?? '';
        $this->recovery_sent_at = $data->recovery_sent_at ?? '';
        $this->email_change_sent_at = $data->email_change_sent_at ?? '';
        $this->new_email = $data->new_email ?? '';
        $this->new_phone = $data->new_phone ?? '';
        $this->invited_at = $data->invited_at ?? '';
        $this->action_link = $data->action_link ?? '';
        $this->email = $data->email ?? '';
        $this->phone = $data->phone ?? '';
        $this->created_at = $data->created_at ?? '';
        $this->confirmed_at = $data->confirmed_at ?? '';
        $this->email_confirmed_at = $data->email_confirmed_at ?? '';
        $this->phone_confirmed_at = $data->phone_confirmed_at ?? '';
        $this->last_sign_in_at = $data->last_sign_in_at ?? '';
        $this->role = $data->role ?? '';
        $this->updated_at = $data->updated_at ?? '';

        $this->identities = array_map(
            fn($identity) => UserIdentity::fromObject($identity),
            $data->identities ?? []
        );

    }

    public function getId(): string
    {
        return $this->id;
    }
    public function getAppMetadata(): UserAppMetadata
    {
        return $this->app_metadata;
    }
    public function getUserMetadata(): UserMetadata
    {
        return $this->user_metadata;
    }
    public function getAud(): string
    {
        return $this->aud;
    }
    public function getConfirmationSentAt(): string
    {
        return $this->confirmation_sent_at;
    }
    public function getRecoverySentAt(): string
    {
        return $this->recovery_sent_at;
    }
    public function getEmailChangeSentAt(): string
    {
        return $this->email_change_sent_at;
    }
    public function getNewEmail(): string
    {
        return $this->new_email;
    }
    public function getNewPhone(): string
    {
        return $this->new_phone;
    }
    public function getInvitedAt(): string
    {
        return $this->invited_at;
    }
    public function getActionLink(): string
    {
        return $this->action_link;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function getPhone(): string
    {
        return $this->phone;
    }
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }
    public function getConfirmedAt(): string
    {
        return $this->confirmed_at;
    }
    public function getEmailConfirmedAt(): string
    {
        return $this->email_confirmed_at;
    }
    public function getPhoneConfirmedAt(): string
    {
        return $this->phone_confirmed_at;
    }
    public function getLastSignInAt(): string
    {
        return $this->last_sign_in_at;
    }
    public function getRole(): string
    {
        return $this->role;
    }
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }
    public function getIdentities(): array
    {
        return $this->identities;
    }
    public function getIsAnonymous(): bool
    {
        return $this->is_anonymous;
    }
    public function getIsSsoUser(): bool
    {
        return $this->is_sso_user;
    }
    public function getFactors(): array
    {
        return $this->factors;
    }

    public static function fromObject(object $user): self
    {
        return new self(
            $user
        );
    }
    
}