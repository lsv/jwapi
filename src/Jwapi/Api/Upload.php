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

use Symfony\Component\Finder\SplFileInfo;

/**
 * Our second level requester
 * @package Jwapi\Api
 */
class Upload extends Api
{
    protected $url;

    /**
     * Create our second level request for posting items
     *
     * @param Api $api
     * @param SplFileInfo $file
     * @param bool $method
     */
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