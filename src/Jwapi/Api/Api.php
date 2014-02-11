<?php
/**
 * This file is part of JW API.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license http://opensource.org/licenses/MIT
 * @author Martin Aarhof <martin.aarhof@gmail.com>
 */
namespace Jwapi\Api;

use Guzzle\Http\Client;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\Response;

/**
 * This class is doing all our requests to the API server
 * @package Jwapi\Api
 */
abstract class Api
{

    /**
     * API url
     * @var string
     */
    const APIURL = 'api.jwplatform.com';

    /**
     * API version
     * @var string
     */
    const APIVERSION = '1.4';

    /**
     * OK status for responses
     * @var string
     */
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

    /**
     * Construct our API with our keys
     *
     * @param string $apikey
     * @param string $secret
     * @param bool $useHttps
     */
    public function __construct($apikey, $secret, $useHttps = true)
    {
        $this->apikey = $apikey;
        $this->apisecret = $secret;
        $this->https = (bool)$useHttps;
        $this->setGet('api_format', 'json');
    }

    /**
     * Get if we use https
     * @return bool
     */
    public function getHttps()
    {
        return $this->https;
    }

    /**
     * Get the api key
     * @return string
     */
    public function getApiKey()
    {
        return $this->apikey;
    }

    /**
     * Get the api secret
     * @return string
     */
    public function getApiSecret()
    {
        return $this->apisecret;
    }

    /**
     * Get the api version
     * @return string
     */
    public function getApiVersion()
    {
        return self::APIVERSION;
    }

    /**
     * Get the api base url
     * @return string
     */
    public function getApiUrl()
    {
        return self::APIURL;
    }

    /**
     * Get the response
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    public function getPath()
    {
        return $this->url;
    }

    /**
     * Send our request
     *
     * @param bool $checkstatus
     * @return Response
     */
    public function send($checkstatus = true)
    {
        $this->beforeRun();

        if (!preg_match('/^(http)/', $this->getPath(), $matches)) {
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
                $request = $client->get($this->getPath(), null, array(
                    'query' => $this->getGets()
                ));
                break;
            case 'POST':
                $request = $client->post($this->getPath(), null, $this->posts, array(
                    'query' => $this->getGets()
                ));
                break;
        }

        $this->setResponse($request);
        if ($checkstatus) {
            $this->checkStatus();
        }
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
        try {
            $this->response = $request->send();
        } catch (ClientErrorResponseException $exception) {
            $this->response = $exception->getResponse();
        }

        return $this->response;
    }

    protected function beforeRun()
    {

    }

    /**
     * @return Response
     */
    protected function afterRun()
    {
        return $this->getResponse();
    }

    /**
     * @param string $key
     * @return bool
     */
    protected function issetGet($key)
    {
        if (array_key_exists($key, $this->gets)) {
            return true;
        }

        return false;
    }

    /**
     * @param string $key
     * @param string $value
     * @return Api
     */
    protected function setGet($key, $value)
    {
        $this->gets[$key] = urlencode($value);
        return $this;
    }

    /**
     * @param string $key
     * @return null|string
     */
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

    /**
     * @param string $key
     * @return bool
     */
    protected function issetPost($key)
    {
        if (array_key_exists($key, $this->posts)) {
            return true;
        }

        return false;
    }

    /**
     * @param string $key
     * @param string $value
     * @return Api
     */
    protected function setPost($key, $value)
    {
        $this->method = 'POST';
        $this->posts[$key] = $value;
        return $this;
    }

    /**
     * @param string $key
     * @return null|string
     */
    protected function getPost($key)
    {
        if ($this->issetPost($key)) {
            return $this->posts[$key];
        }

        return null;
    }

    /**
     * @param bool $bool
     * @return string
     */
    protected function setBoolean($bool)
    {
        return $bool ? 'True' : 'False';
    }

    /**
     * @param string $bool
     * @return bool
     */
    protected function getBoolean($bool)
    {
        return $bool == 'True' ? true : false;
    }

} 