<?php

namespace Bytecraftnz\SupabasePhp\Contracts;

interface AdminClient
{

    public function getUserById( String $id ): array|object|null;
    
    public function deleteUser( String $email, bool $softdelete = false ): array|object|null;
    
    public function listUsers(int $page = 1, int $per_page = 5): array|object|null;

    public function createUser( String $email, String $password, array $data = [] ): array|object|null;

    public function inviteUserByEmail( String $email, array $options ): array|object|null;

    public function updateUserById(String $id, array $data): array|object|null;
    
    public function generateSignUpLink(String $email, String $password, string $redirect_to): array|object|null;    
    
    public function generateInviteLink( String $email, string $redirect_to): array|object|null;
    
    public function generateMagicLinkLink(String $email, string $redirect_to): array|object|null;    
    
    public function generateRecoveryLink(String $email, string $redirect_to): array|object|null;
    
    public function generateEmailChangeLink(String $email, String $newEmail, string $redirect_to): array|object|null;
    


}