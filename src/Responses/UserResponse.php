<?php

namespace Bytecraftnz\SupabasePhp\Responses;
use Bytecraftnz\SupabasePhp\Models\User;

class UserResponse
{
    private User $user;

    public function __construct(
        object $data
    ) {
        $this->user = new User($data->user);
    }

    public function getUser(): User
    {
        return $this->user;
    }
    
    public static function fromObject(object $data): UserResponse
    {
        return new self($data);
    }   
}