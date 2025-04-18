<?php

namespace Bytecraftnz\SupabasePhp;

use Bytecraftnz\SupabasePhp\Models\AuthError;

use function PHPUnit\Framework\isEmpty;

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

    protected function doRequest(string $method, string $endpoint, array $options = [], array $transform = []): array|object|null
    {

        $url = $this->buildUrl($endpoint);
        $headers = $this->getHeaders();
        if (isset($options['headers'])) {
            $headers = array_merge($headers, $options['headers']);
            unset($options['headers']);
        }
        
        try{
            $response = $this->httpClient->request(
                $method,
                $url,
                [
                    'headers' => $headers,
                    'body' => json_encode($options)
                ]
            );

            $responseObject = json_decode($response->getBody());

            return isEmpty($transform) ? $transform($responseObject) : $responseObject ;
        } catch(\GuzzleHttp\Exception\RequestException $e){
            $this->extractErrorFromRequestException($e);
            return new AuthError(
                [
                    'message' => $this->getError(),
                    'code' => $e->getCode(),
                    'status' => $e->getResponse()->getStatusCode()
                ]
            );
        } catch(\GuzzleHttp\Exception\ConnectException $e){
            $this->error = $e->getMessage();
            return new AuthError(
                [
                    'message' => $this->error,
                    'code' => $e->getCode(),
                    'status' => 'Connection Error'
                ]
            );
        }
    }

    protected function doPostRequest(string $endpoint, array $options = [], ?array $transform ): object
    {
        return $this->doRequest('POST', $endpoint, $options, $transform);
    }
    
    protected function doDeleteRequest(string $endpoint, array $options = [], ?array $transform): object
    {
        return $this->doRequest('DELETE', $endpoint, $options, $transform);
    }
    
    protected function doPutRequest(string $endpoint, array $options = [], ?array $transform): object
    {
        return $this->doRequest('PUT', $endpoint, $options, $transform);
    }

    protected function doGetRequest(string $endpoint, array $options = [], ?array $transform): object
    {
        return $this->doRequest('GET', $endpoint, $options, $transform);
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

    public function isError($o):bool
    {
        return $o instanceof AuthError;
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