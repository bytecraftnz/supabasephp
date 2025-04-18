<?php
namespace Bytecraftnz\SupabasePhp;

use Supabase;

final class AdminClient extends Supabase implements \Bytecraftnz\SupabasePhp\Contracts\AdminClient
{
    /**
     * @var string
     */
    protected $serviceKey;
    
    /**
     * @var string
     */
    protected const adminRoutePath = '/admin';

    public function __construct(string $url, string $key,  string $serviceKey)
    {    
        parent::__construct($url, $key);
        $this->serviceKey = $this->serviceKey;
    }

    /**
     * @return array
     */
    protected function getHeaders(): array
    {
        return array_merge(parent::getHeaders(), [
            'Authorization' => 'Bearer ' . $this->serviceKey,
        ]);
    }

    /**
     * Get user by id
     * @param string $id
     * @return array|object|null
     */
    public function getUserById(string $id): array|object|null
    {
        $endPoint = $this->buildEndpoint( self::adminRoutePath .'/users/' . $id);

        $options = [
            'headers' => $this->getHeaders(),
            'body' => null,
        ];

        return $this->doGetRequest($endPoint, $options);

    }

    public function deleteUser(string $id, bool $softdelete = false): array|object|null
    {
        $endPoint = $this->buildEndpoint( self::adminRoutePath .'/users/' . $id);
        $options = [
            'headers' => $this->getHeaders(),
            'body' => json_encode([
                'should_soft_delete' => $softdelete
            ]),
        ];
        return $this->doDeleteRequest($endPoint, $options);
    }
    
    public function listUsers(int $page = 1, int $per_page = 5): array|object|null
    {
        $endPoint = $this->buildEndpoint( self::adminRoutePath .'/users');
        $options = [
            'headers' => $this->getHeaders(),
            'body' => null,
            'query' => [
                'page' => $page,
                'per_page' => $per_page
            ]
        ];
        return $this->doGetRequest($endPoint, $options);
    }

    public function createUser(String $email, String $password, array $data = []): array|object|null
    {
        $endPoint = $this->buildEndpoint( self::adminRoutePath .'/users');
        $options = [
            'headers' => $this->getHeaders(),
            'body' => json_encode([
                'email' => $email,
                'password' => $password,
                'data' => $data
            ]),
        ];
        return $this->doPostRequest($endPoint, $options);
    }

    public function inviteUserByEmail(string $email, array $options): array|object|null
    {
        $options = [
            'headers' => $this->getHeaders(),
            'body' => json_encode([
                'email' => $email,
                'data' => $options['data'] ?? null,                
            ]),
            'redirectTo' => $options['redirect_to'] ?? null,
        ];

        $endPoint = $this->buildEndpoint( '/invite' );
        return $this->doPostRequest($endPoint, $options);
    }

    public function generateSignUpLink(String $email, String $password, string $redirect_to): array|object|null
    {
        $options = [
            'email' => $email,
            'password' => $password,
            'redirect_to' => $redirect_to,
        ];

        return $this->generateLink($options);
    }
    
    public function generateMagicLinkLink(String $email, string $redirect_to): array|object|null
    {
        $options = [
            'email' => $email,
            'redirect_to' => $data['redirect_to'] ?? null,
        ];
        return $this->generateLink($options);
    }
    
    public function generateInviteLink( String $email, string $redirect_to): array|object|null
    {
        $options = [
            'email' => $email,
            'redirect_to' => $redirect_to,
        ];
        return $this->generateLink($options);
    }

    public function generateRecoveryLink(String $email, string $redirect_to): array|object|null
    {
        $options = [
            'email' => $email,
            'redirect_to' => $redirect_to,
        ];
        return $this->generateLink($options);
    }
    
    public function generateEmailChangeLink(String $email, String $newEmail, string $redirect_to): array|object|null
    {
        $options = [
            'email' => $email,
            'new_email' => $newEmail,
            'redirect_to' => $redirect_to,
        ];
        return $this->generateLink($options);
    }


    public function updateUserById(string $id, array $data): array|object|null
    {
        $options = [
            'headers' => $this->getHeaders(),
            'body' => json_encode([
                'data' => $data,                
            ]),
        ];

        $endPoint = $this->buildEndpoint( self::adminRoutePath .'/users/' . $id);
        return $this->doPutRequest($endPoint, $options);
    }


    private function buildEndpoint(string $endpoint): string
    {
        return self::baseRoutePath .  $endpoint;
    }


    private function generateLink(array $options):array|object|null
    {
        $endPoint = $this->buildEndpoint( self::adminRoutePath .'/generate_link');

        $redirectTo = $options['redirect_to'] ?? null;
        unset($options['redirect_to']);

        $options = [
            'headers' => $this->getHeaders(),
            'body' => json_encode($options),
            'redirectTo' => $redirectTo ,
        ];
        return $this->doPostRequest($endPoint, $options);
        
    }

}