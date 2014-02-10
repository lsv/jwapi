<?php
namespace Jwapi\Api;

use Guzzle\Http\Client;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\Response;

abstract class Api
{
    const APIURL = 'api.jwplatform.com';
    const APIVERSION = '1.4';

    const STATUS_OK = 'ok';

    private $apikey;
    private $apisecret;
    private $https = true;
    private $gets = array();
    private $posts = array();

    /**
     * @var Response
     */
    private $response;

    protected $url;
    protected $method = 'GET';

    protected $authenticate = true;

    public function __construct($apikey, $secret, $useHttps = true)
    {
        $this->apikey = $apikey;
        $this->apisecret = $secret;
        $this->https = (bool)$useHttps;
        $this->setGet('api_format', 'json');
    }

    public function getHttps()
    {
        return $this->https;
    }

    public function getApiKey()
    {
        return $this->apikey;
    }

    public function getApiSecret()
    {
        return $this->apisecret;
    }

    public function getApiVersion()
    {
        return self::APIVERSION;
    }

    public function getApiUrl()
    {
        return self::APIURL;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return Response
     */
    public function send()
    {
        $this->beforeRun();

        if (!preg_match('/^(http)/', $this->url, $matches)) {
            $client = new Client(sprintf(
                'http%s://%s/%s',
                ($this->getHttps() ? 's' : ''),
                $this->getApiUrl(),
                $this->getApiVersion()
            ));
        } else {
            $client = new Client;
        }

        switch ($this->method) {
            default:
            case 'GET':
                $request = $client->get($this->url, null, array(
                    'query' => $this->getGets()
                ));
                break;
            case 'POST':
                $request = $client->post($this->url, null, $this->posts, array(
                    'query' => $this->getGets()
                ));
                break;
        }

        $this->setResponse($request);
        $this->checkStatus();
        return $this->afterRun();
    }

    private function checkStatus()
    {
        $response = $this->getResponse();
        $data = $response->json();
        if ($data['status'] != self::STATUS_OK) {
            throw new \Exception(sprintf(
                "Request not OK:\nStatus: %s\nCode: %s\nTitle: %s\nMessage:\n%s",
                $data['status'],
                $data['code'],
                $data['title'],
                $data['message']
            ));
        }
    }

    /**
     * @param RequestInterface $request
     * @return Response
     */
    protected function setResponse(RequestInterface $request)
    {
        $this->response = $request->send();
        return $this->response;
    }

    protected function beforeRun()
    {

    }

    /**
     * @return \Guzzle\Http\Message\Response
     */
    protected function afterRun()
    {
        return $this->getResponse();
    }

    protected function issetGet($key)
    {
        if (array_key_exists($key, $this->gets)) {
            return true;
        }

        return false;
    }

    protected function setGet($key, $value)
    {
        $this->gets[$key] = urlencode($value);
        return $this;
    }

    protected function getGet($key)
    {
        if ($this->issetGet($key)) {
            return $this->gets[$key];
        }

        return null;
    }

    private function getGets()
    {
        if ($this->authenticate) {
            $digits = 8;

            $this
                ->setGet('api_key', $this->getApiKey())
                ->setGet('api_timestamp', time())
                ->setGet('api_nonce', rand(pow(10, $digits-1), pow(10, $digits)-1))
                ->setGet('api_signature', '');

            ksort($this->gets);

            $signature = '';
            foreach($this->gets as $get) {
                $signature .= $get;
            }
            $this->setGet('api_signature', sha1($signature . $this->getApiSecret()));
        }

        return $this->gets;

    }

    protected function issetPost($key)
    {
        if (array_key_exists($key, $this->posts)) {
            return true;
        }

        return false;
    }

    protected function setPost($key, $value)
    {
        $this->method = 'POST';
        $this->posts[$key] = $value;
        return $this;
    }

    protected function getPost($key)
    {
        if ($this->issetPost($key)) {
            return $this->posts[$key];
        }

        return null;
    }

    protected function setBoolean($bool)
    {
        return $bool ? 'True' : 'False';
    }

    protected function getBoolean($bool)
    {
        return $bool == 'True' ? true : false;
    }

} 