<?php
namespace Bytecraftnz\SupabasePhp;

use Bytecraftnz\SupabasePhp\Responses\AuthResponse;
use Bytecraftnz\SupabasePhp\Models\AuthError;

final class AuthClient extends Supabase implements \Bytecraftnz\SupabasePhp\Contracts\AuthClient
{

    
    private $authTranformerCallable;

    public function __construct(string $url, string $key)
    {
        parent::__construct($url, $key);
        $this->authTranformerCallable = [$this, 'authReponseTransform'];
    }

    /**
     * Sign in (authenticate by email and password)
     * @access public
     * @param string $email The user email
     * @param string $password The user password
     * @return array|object|null
     */    
    public function signInWithEmailAndPassword(string $email, string $password): AuthResponse | AuthError
    {        
        $fields = [
            'email' => $email,
            'password' => $password
        ];

        return $this->doPostRequest('token?grant_type=password', $fields, $this->authTranformerCallable);

    }


    /**
     * Sign in (authenticate by refresh token)
     * @access public
     * @param string $refreshToken The refresh token
     * @return void
     */    
    public function signInWithRefreshToken(string $refreshToken) : AuthResponse | AuthError
    {
        $fields = [
            'refresh_token' => $refreshToken
        ];
        
        return $this->doPostRequest('token?grant_type=refresh_token', $fields, $this->authTranformerCallable);
    }

    /**
     * Sign in (authenticate by SMS OTP)
     * @access public
     * @param string $phone The user phone number
     * @return array|object|null
     */
    public function signInWithSMSOTP(string $phone): AuthResponse | AuthError
    {
        throw new \Exception("Not implemented");
        $fields = [
            'phone' => $phone
        ];
        return $this->doPostRequest('otp', $fields , $this->authTranformerCallable);
    }

    /**
     * Sign in (authenticate by magic link sended to user email)
     * @access public
     * @param string $email The user email
     * @return array|object|null
     */    
    public function signInMagicLink(string $email): AuthResponse | AuthError
    {
        throw new \Exception("Not implemented");
        $fields = [
            'email' => $email
        ];
        return $this->doPostRequest('magiclink', $fields , $this->authTranformerCallable);
    }

    /**
     * Sign up (create user by email and password)
     * @access public
     * @param string $email The user email
     * @param string $password The user password
     * @param array $data Additional data to be sent stored as user metadata
     * @return array|object|null
     */
    public function signUpWithEmailAndPassword(string $email, string $password, array $data): AuthResponse | AuthError
    {
        // Implement sign-up logic here
        $fields = [
            'email' => $email,
            'password' => $password
        ];
        if(is_array($data) && count($data) > 0){
            $fields['data'] = $data;
        }
        return $this->doPostRequest('signup', $fields , $this->authTranformerCallable);
    }

    /**
     * Sign Up (create user by phone and password)
     * @access public
     * @param string $phone The user phone number
     * @param string $password The user password
     * @param array $data Additional data to be sent stored as user metadata
     * @return void
     */
    public function signUpWithPhoneAndPassword(string $phone, string $password, array $data = []):AuthResponse | AuthError
    {
        $fields = [
            'phone' => $phone,
            'password' => $password
        ];
        if(is_array($data) && count($data) > 0){
            $fields['data'] = $data;
        }
        return $this->doPostRequest('signup', $fields , $this->authTranformerCallable);
    }

    /**
     * Verify OTP - Phone (One Time Password)
     * @access private
     * @param string $otp The OTP code
     * @param string $token The token received in the OTP process
     * @return array|object|null
     */
    public function verifyOtpViaPhone(String $otp, String $token)
    {
        return $this->verifyOtp('phone',$otp, $token);
    }

    /**
     * Verify OTP - Email (One Time Password)
     * @access private
     * @param string $otp The OTP code
     * @param string $token The token received in the OTP process
     * @return array|object|null
     */    
    public function verifyOtpViaEmail(String $otp, String $token)
    {
        return $this->verifyOtp('email', $otp,  $token);
    }


    /**
     * Logout
     * @access public
     * @param string $bearerUserToken The bearer token (from in sign in process)
     * @return array|object|null
     */    
    public function signOut(String $bearerToken): null | AuthError
    {

        $options = [
            'headers' => $this->getHeadersWithBearer($bearerToken),
        ];

        return $this->doPostRequest('logout', $options, null);
    }

    /**
     * Recover the user password (by a link sended to user email)
     * @access public
     * @param string $email The user email
     * @return array|object|null
     */
    public function resetPasswordForEmail(string $email): array|object|null
    {
        $fields = [
            'email' => $email
        ];

        return $this->doPostRequest('recover', $fields, null);
    }

        /**
     * Update the user data
     * @access public
     * @param string $bearerUserToken The bearer user token (generated in sign in process)
     * @param array  $data Optional. The user meta data
     * @return array|object|null
     */
    public function updateUser( String $bearerToken, array $data =[]): array|object|null
    {
        $options = [
            'headers' => $this->getHeadersWithBearer($bearerToken),
            'body' => json_encode($data)
        ];

        return $this->doPutRequest('user', $options, null);

    }

        /**
     * Update the user Password
     * @access public
     * @param string $bearerUserToken The bearer user token (generated in sign in process)
     * @param string $password Optional. The user password
     * @return array|object|null
     */
    public function updateUserPassword( String $bearerToken, String $password ): array|object|null
    {
        return $this->updateUser($bearerToken, ['password' => $password]);
    }

    /**
     * Update the user Email
     * @access public
     * @param string $bearerUserToken The bearer user token (generated in sign in process)
     * @param string $email Optional. The user email
     * @return array|object|null
     */    
    public function updateUserEmail( String $bearerToken, String $email ): array|object|null
    {
        return $this->updateUser($bearerToken, ['email' => $email]);
    }    

    /**
     * Get the user data
     * @access public
     * @param string $bearerUserToken The bearer user token (generated in sign in process)
     * @return array|object|null
     */
    public function getUser(string $bearerToken): array|object|null
    {
        $options = [
            'headers' => $this->getHeadersWithBearer($bearerToken),
        ];
        return $this->doGetRequest('user', $options, null);

    }

    /**
     * Check if the user is authenticated
     * @access public
     * @param string $bearerUserToken The bearer user token (generated in sign in process)
     * @return bool
     */
    public function isAuthenticated(string $bearerUserToken) : bool
    {
        $user = $this->getUser($bearerUserToken);
        return $user->aud == 'authenticated';
    }
 
    /**
     * Verify OTP (One Time Password)
     * @access private
     * @param string $type The type of OTP (email or phone)
     * @param string $otp The OTP code
     * @param string $token The token received in the OTP process
     * @return array|object|null
     */
    private function verifyOtp(String $type, String $otp, String $token)
    {
        $fields = [
            'type' => $type,
            'token' => $token,
            $type => $otp
        ];
        
        return $this->doPostRequest('verify', $fields , null);
		// Implement verifyOtp logic here
    
    }

    protected function authReponseTransform($user)
    {
        return AuthResponse::fromObject($user);
    }

}