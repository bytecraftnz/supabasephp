<?php
namespace Bytecraftnz\SupabasePhp;

use Bytecraftnz\SupabasePhp\Responses\AuthResponse;
use Bytecraftnz\SupabasePhp\Models\AuthError;
use Bytecraftnz\SupabasePhp\Responses\UserResponse;

final class AuthClient extends Supabase implements \Bytecraftnz\SupabasePhp\Contracts\AuthClient
{

    
    private $authTranformerCallable;
    private $userTranformerCallable;

    public function __construct(string $url, string $key)
    {
        parent::__construct($url, $key);
        $this->authTranformerCallable = [$this, 'authReponseTransform'];
        $this->userTranformerCallable = [$this, 'userReponseTransform'];
    }

    /**
     * Sign in (authenticate by email and password)
     * @access public
     * @param string $email The user email
     * @param string $password The user password
     * @return AuthResponse | AuthError
     */    
    public function signInWithEmailAndPassword(string $email, string $password): AuthResponse | AuthError
    {        
        $options = [
            'body' => [
                'email' => $email,
                'password' => $password
            ],
        ];

        return $this->doPostRequest('token?grant_type=password', $options, $this->authTranformerCallable);

    }


    /**
     * Sign in (authenticate by refresh token)
     * @access public
     * @param string $refreshToken The refresh token
     * @return AuthResponse | AuthError
     */    
    public function signInWithRefreshToken(string $refreshToken) : AuthResponse | AuthError
    {
        $options = [
            'body' => [
                'refresh_token' => $refreshToken
            ],
        ];
        
        return $this->doPostRequest('token?grant_type=refresh_token', $options, $this->authTranformerCallable);
    }

    /**
     * Sign in (authenticate by SMS OTP)
     * @access public
     * @param string $phone The user phone number
     * @return AuthResponse | AuthError
     */
    public function signInWithSMSOTP(string $phone): AuthError | null
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
     * @return AuthResponse | AuthError
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
     * @return AuthResponse | AuthError
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
        return $this->doPostRequest('signup', ['body' => $fields] , $this->authTranformerCallable);
    }

    /**
     * Sign Up (create user by phone and password)
     * @access public
     * @param string $phone The user phone number
     * @param string $password The user password
     * @param array $data Additional data to be sent stored as user metadata
     * @return AuthResponse | AuthError
     */
    public function signUpWithPhoneAndPassword(string $phone, string $password, array $data = []): AuthResponse | AuthError
    {
        $fields = [
            'phone' => $phone,
            'password' => $password
        ];
        if(is_array($data) && count($data) > 0){
            $fields['data'] = $data;
        }
        return $this->doPostRequest('signup', ['body' => $fields ] , $this->authTranformerCallable);
    }

    /**
     * Verify OTP - Phone (One Time Password)
     * @access private
     * @param string $otp The OTP code
     * @param string $token The token received in the OTP process
     * @return AuthResponse | AuthError
     */
    public function verifyOtpViaPhone(String $otp, String $token):AuthResponse | AuthError
    {
        return $this->verifyOtp('phone',$otp, $token);
    }

    /**
     * Verify OTP - Email (One Time Password)
     * @access private
     * @param string $otp The OTP code
     * @param string $token The token received in the OTP process
     * @return AuthResponse | AuthError
     */    
    public function verifyOtpViaEmail(String $otp, String $token): AuthResponse | AuthError
    {
        return $this->verifyOtp('email', $otp,  $token);
    }


    /**
     * Logout
     * @access public
     * @param string $bearerUserToken The bearer token (from in sign in process)
     * @return null | AuthError
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
     * @return null | AuthError
     */
    public function resetPasswordForEmail(string $email, array $options): null | AuthError
    {
        $fields = [
            'body' => [
                'email' => $email,
            ],
            'redirect_to' => $options['redirectTo'] ?? null
        ];

        return $this->doPostRequest('recover', $fields, null);
    }

        /**
     * Update the user data
     * @access public
     * @param string $bearerUserToken The bearer user token (generated in sign in process)
     * @param array  $data Optional. The user meta data
     * @return UserResponse | AuthError
     */
    public function updateUser( String $bearerToken, array $data =[]): UserResponse | AuthError
    {
        if(isset($data['data'])){
            $data['data'] = [
                'data' => $data['data']
            ];
        }

        $options = [
            'headers' => $this->getHeadersWithBearer($bearerToken),
            'body' => $data
        ];

        return $this->doPutRequest('user', $options, $this->userTranformerCallable);

    }

        /**
     * Update the user Password
     * @access public
     * @param string $bearerUserToken The bearer user token (generated in sign in process)
     * @param string $password Optional. The user password
     * @return UserResponse | AuthError
     */
    public function updateUserPassword( String $bearerToken, String $password ): UserResponse | AuthError
    {
        return $this->updateUser($bearerToken, ['body' => ['password' => $password]]);
    }

    /**
     * Update the user Email
     * @access public
     * @param string $bearerUserToken The bearer user token (generated in sign in process)
     * @param string $email Optional. The user email
     * @return UserResponse | AuthError
     */    
    public function updateUserEmail( String $bearerToken, String $email ): UserResponse | AuthError
    {
        return $this->updateUser($bearerToken, ['body' => ['email' => $email]]);
    }    

    /**
     * Get the user data
     * @access public
     * @param string $bearerUserToken The bearer user token (generated in sign in process)
     * @return UserResponse | AuthError
     */
    public function getUser(string $bearerToken): UserResponse | AuthError
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
        return ($user->getUser())->getAud() == 'authenticated';
    }
 
    /**
     * Verify OTP (One Time Password)
     * @access private
     * @param string $type The type of OTP (email or phone)
     * @param string $otp The OTP code
     * @param string $token The token received in the OTP process
     * @return array|object|null
     */
    private function verifyOtp(String $type, String $otp, String $token):AuthResponse | AuthError
    {
        $fields = [
            'body' => [
                'type' => $type,
                'token' => $token,
                $type => $otp
            ],
        ];
        
        return $this->doPostRequest('verify', $fields , null);
    }

    protected function authReponseTransform($user, $requestData)
    {
        return AuthResponse::fromObject($user, $requestData);
    }

    protected function userReponseTransform($user)
    {
        dd($user);
        return UserResponse::fromObject($user);
    }
}