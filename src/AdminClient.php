<?php
namespace Bytecraftnz\SupabasePhp;

use Supabase;

final class AdminClient extends Supabase implements \Bytecraftnz\SupabasePhp\Contracts\AdminClient
{
    /**
     * @var string
     */
    protected $serviceKey;
    
    public function __construct(string $url, string $key,  string $serviceKey)
    {    
        parent::__construct($url, $key);
        $this->serviceKey = $this->serviceKey;
    }

    protected function getHeaders(): array
    {
        return array_merge(parent::getHeaders(), [
            'Authorization' => 'Bearer ' . $this->serviceKey,
        ]);
    }

    public function getUserById(string $id): array|object|null
    {
        // Implement getUserById logic here
        throw new \Exception("Not implemented");
    }

    public function deleteUser(string $id): array|object|null
    {
        // Implement deleteUser logic here
        throw new \Exception("Not implemented");
    }
    
    public function listUsers(): array|object|null
    {
        // Implement listUsers logic here
        throw new \Exception("Not implemented");
    }

    public function createUser(String $email, String $password, array $data = []): array|object|null
    {
        // Implement createUser logic here
        throw new \Exception("Not implemented");
    }

    public function inviteUserByEmail(string $email): array|object|null
    {
        // Implement inviteUserByEmail logic here
        throw new \Exception("Not implemented");
    }

    public function generateLink(String $type, String $email, String $password):array|object|null
    {
        // Implement generateLink logic here
        throw new \Exception("Not implemented");
    }

    public function updateUserById(string $id, array $data): array|object|null
    {
        // Implement updateUserById logic here
        throw new \Exception("Not implemented");
    }

    public function deleteFactor(string $id, string $factorId): array|object|null
    {
        // Implement deleteFactor logic here
        throw new \Exception("Not implemented");
    }


}