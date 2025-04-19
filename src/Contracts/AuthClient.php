<?php

namespace Bytecraftnz\SupabasePhp\Contracts;

use Bytecraftnz\SupabasePhp\Models\AuthError;
use Bytecraftnz\SupabasePhp\Responses\AuthResponse;

interface AuthClient
{


    public function signUpWithEmailAndPassword(string $email, string $password, array $data): AuthResponse | AuthError;

    public function signUpWithPhoneAndPassword(string $phone, string $password, array $data = []): AuthResponse | AuthError;

    public function signOut(String $bearerToken): null | AuthError;

    public function signInWithEmailAndPassword(string $email, string $password): AuthResponse | AuthError;

    public function signInWithRefreshToken(string $refreshToken): AuthResponse | AuthError;

    public function verifyOtpViaPhone ( String $otp, String $token ): AuthResponse | AuthError;
    
    public function verifyOtpViaEmail ( String $otp, String $token ): AuthResponse | AuthError;

    

    public function resetPasswordForEmail ( String $email, array $options ): array|object|null; 

    public function getUser(string $bearerUserToken): array|object|null;

    public function updateUser( String $bearerToken, array $data =[]): array|object|null;
    
    public function updateUserPassword( String $bearerToken, String $password ): array|object|null;
    
    public function updateUserEmail( String $bearerToken, String $email ): array|object|null;  
    
    public function isAuthenticated(string $bearerUserToken) : bool;


    public function signInMagicLink(string $email): AuthResponse | AuthError;

    public function signInWithSMSOTP(string $phone) : AuthError | null;
    
    public function isError($o):bool;
    public function getError(): string;
}