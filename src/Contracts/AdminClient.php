<?php

namespace Bytecraftnz\SupabasePhp\Contracts;

interface AdminClient
{

    public function getUserById( String $id ): array|object|null;
    
    public function deleteUser( String $email ): array|object|null;
    
    public function listUsers(): array|object|null;

    public function createUser( String $email, String $password, array $data = [] ): array|object|null;

    public function inviteUserByEmail( String $email ): array|object|null;

    //signup, magiclink, invite, recovery, email_change_current, email_change_new, phone_change
    public function generateLink(String $type, String $email, String $password): array|object|null;
    
    public function updateUserById(String $id, array $data): array|object|null;
    
    public function deleteFactor(String $id, String $userId): array|object|null;

}