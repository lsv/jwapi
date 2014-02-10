<?php
namespace Jwapi\Api;

use Symfony\Component\Finder\SplFileInfo;

class Upload extends Api
{
    protected $url;

    public function __construct(Api $api, SplFileInfo $file, $method)
    {
        $data = $api->getResponse()->json();
        parent::__construct($api->getApiKey(), $api->getApiSecret(), $api->getHttps());

        $this->url = sprintf('%s://%s%s',
            $data[$method]['link']['protocol'],
            $data[$method]['link']['address'],
            $data[$method]['link']['path']
        );

        $this
            ->setGet('key', $data[$method]['query']['key'])
            ->setGet('token', $data[$method]['query']['token'])
            ->setPost('file', file_get_contents($file->getFilename()));

    }

    protected function beforeRun()
    {
        $this->authenticate = false;
    }

} 