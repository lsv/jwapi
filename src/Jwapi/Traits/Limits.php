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
namespace Jwapi\Traits;

use Guzzle\Http\Message\Response;

/**
 * Class Limits
 * @package Jwapi\Traits
 */
trait Limits
{

    /**
     * Max limits of results
     * @var int
     */
    protected $maxlimit = 1000;

    /**
     * (optional)
     * Specifies maximum number of items to return. Default is 50. Maximum result limit is 1000.
     *
     * @param  integer    $limit
     * @return Limits
     * @throws \Exception
     */
    public function setResultLimit($limit)
    {
        if ((int) $limit > $this->maxlimit) {
            throw new \Exception('Max ' . $this->maxlimit . ' results is allowed');
        }

        $this->setGet('result_limit', (int) $limit);

        return $this;
    }

    /**
     * (optional)
     * Specifies how many items should be skipped at the beginning of the result set. Default is 0.
     *
     * @param  integer $offset
     * @return Limits
     */
    public function setResultOffset($offset)
    {
        $this->setGet('result_offset', (int) $offset);

        return $this;
    }

    /**
     * Get next page of results
     * Returns null if no next page
     *
     * @return null|Response
     * @throws \Exception
     */
    public function getNextResults()
    {
        if (! $this->getResponse() instanceof Response) {
            throw new \Exception('You have not send any query yet');
        }

        $data = $this->getResponse()->json();
        $total = (int) $data['total'];
        $offset = (int) $data['offset'];
        $limit = (int) $data['limit'];

        if ($total > ($offset + $limit)) {
            return $this
                ->setResultOffset($offset + $limit)
                ->send();
        }

        return null;
    }

    /**
     * Get previous page of results
     * Returns null if no previous page
     *
     * @return null|Response
     * @throws \Exception
     */
    public function getPrevResults()
    {
        if (! $this->getResponse() instanceof Response) {
            throw new \Exception('You have not send any query yet');
        }

        $data = $this->getResponse()->json();
        $offset = (int) $data['offset'];
        $limit = (int) $data['limit'];

        if ($offset > 0) {
            $newoffset = $offset - $limit;

            return $this
                ->setResultOffset(($newoffset < 0 ? 0 : $newoffset))
                ->send();
        }

        return null;
    }

}
