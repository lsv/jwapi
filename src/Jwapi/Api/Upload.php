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

    /**
     * {@inherit}
     */
    protected $path;

    /**
     * Create our second level request for posting items
     *
     * @param Api         $api
     * @param SplFileInfo $file
     * @param bool        $method
     */
    public function __construct(Api $api, SplFileInfo $file, $method)
    {
        $data = $api->getResponse()->json();
        parent::__construct($api->getApiKey(), $api->getApiSecret(), $api->getHttps());

        $this->path = sprintf(
            '%s://%s%s',
            $data['link']['protocol'],
            $data['link']['address'],
            $data['link']['path']
        );

        $this
            ->setGet('key', $data['link']['query']['key'])
            ->setGet('token', $data['link']['query']['token'])
            ->setPost('file', '@' . $file->getPath() . '/' . $file->getFilename());

    }

    /**
     * {@inherit}
     */
    protected function beforeRun()
    {
        $this->authenticate = false;
    }
}
