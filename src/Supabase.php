<?php

namespace Bytecraftnz\SupabasePhp;
abstract class Supabase
{

    /**
     * @var string
     */
    protected $url;
    /**
     * @var string
     */
    protected $key;
    
    /**
     * @var \GuzzleHttp\Client
     */
    protected $httpClient;

    /**
     * @var string
     */
    const baseRoutePath = 'auth/v1';


    /**
     * @var string
     */
    private $error;


    protected function __construct(string $url, string $key)
    {
        $this->url = $url;
        $this->key = $key;
        $this->httpClient = new \GuzzleHttp\Client();
    }



    protected function getHeaders()
    {
        return [
            'apikey' => $this->key,
            'content-type' => 'application/json',
            'accept' => 'application/json',
        ];
    }

    protected function getHeadersWithBearer(string $bearer): array
    {
        return array_merge($this->getHeaders(), [
            'Authorization' => 'Bearer ' . $bearer
        ]);
    }

    protected function buildUrl(string $endpoint): string
    {   
        
        return $this->url .'/'. self::baseRoutePath . '/' . ltrim($endpoint, '/');
    }

    protected function doRequest(string $method, string $endpoint, array $options = []): array|object|null
    {

        $url = $this->buildUrl($endpoint);
        $headers = $this->getHeaders();
        if (isset($options['headers'])) {
            $headers = array_merge($headers, $options['headers']);
        }
        $body = null;
        if (isset($options['body'])) {
            $body = json_encode($options['body']);
        }
        // Implement doRequest logic here

        try{
            $response = $this->httpClient->request(
                $method,
                $url,
                [
                    'headers' => $headers,
                    'body' => $body,
                ]
            );
            return json_decode($response->getBody());
        } catch(\GuzzleHttp\Exception\RequestException $e){
            $e->getCode();
            $this->extractErrorFromRequestException($e);
            throw $e;
        } catch(\GuzzleHttp\Exception\ConnectException $e){
            $this->error = $e->getMessage();
            throw $e;
        }
    }

    protected function doPostRequest(string $endpoint, array $options = []): array|object|null
    {
        return $this->doRequest('POST', $endpoint, $options);
    }
    
    protected function doDeleteRequest(string $endpoint, array $options = []): array|object|null
    {
        return $this->doRequest('DELETE', $endpoint, $options);
    }
    
    protected function doPutRequest(string $endpoint, array $options = []): array|object|null
    {
        return $this->doRequest('PUT', $endpoint, $options);
    }

    protected function doGetRequest(string $endpoint, array $options = []): array|object|null
    {
        return $this->doRequest('GET', $endpoint, $options);
    }


    public function extractErrorFromRequestException(\GuzzleHttp\Exception\RequestException $e) : void
    {
        if($e->hasResponse()){
            $res = json_decode($e->getResponse()->getBody());
            $searchItems = ['msg', 'message', 'error_description'];            
            foreach($searchItems as $item){
                if(isset($res->$item)){
                    $this->error = $res->$item;
                    break;
                }
            }
        }
    }

    public function getError(): string
    {
        return $this->error;
    }

    public static function createAuthClient(string $url, string $key): \Bytecraftnz\SupabasePhp\Contracts\AuthClient
    {
        return new \Bytecraftnz\SupabasePhp\AuthClient($url, $key);
    }

    public static function createAdminClient(string $url, string $key, string $serviceKey): \Bytecraftnz\SupabasePhp\Contracts\AdminClient
    {
        return new \Bytecraftnz\SupabasePhp\AdminClient($url, $key, $serviceKey);
    }

}