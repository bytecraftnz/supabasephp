<?php

namespace Bytecraftnz\SupabasePhp\Laravel;

use Bytecraftnz\SupabasePhp\Contracts\AuthClient;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;


class SupavalUserProvider implements UserProvider
{

    public function __construct(private AuthClient $authClient)
    {
        // Constructor logic if needed
    }

	public function retrieveById($identifier)
	{
		// Implement logic to retrieve a user by their unique identifier
	}

	public function retrieveByToken($identifier, $token)
	{
		// Implement logic to retrieve a user by their unique identifier and "remember me" token
	}

	public function updateRememberToken($user, $token)
	{
		// Implement logic to update the "remember me" token for the user
	}

	public function retrieveByCredentials(array $credentials)
	{
		// Implement logic to retrieve a user by their credentials
	}

	public function validateCredentials($user, array $credentials)
	{
		// Implement logic to validate a user's credentials
	}

	public function rehashPasswordIfRequired(Authenticatable $user, array $credentials, bool $force = false)
	{
		// Implement logic to rehash the password if required
	}
}