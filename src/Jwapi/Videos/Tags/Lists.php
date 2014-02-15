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
namespace Jwapi\Videos\Tags;

use Guzzle\Http\Message\Response;
use Jwapi\Api\Api;
use Jwapi\Traits;

/**
 * Return a list of video tags.
 * @package Jwapi\Videos\Tags
 */
class Lists extends Api
{

    const MAXLIMIT = 1000;

    //use Traits\Limits;
    //use Traits\OrderBy;

    /**
     * Case-insensitive search in the name tag field. It will list all tags which name contains search string.
     *
     * @param  string $search
     * @return Lists
     */
    public function setSearch($search)
    {
        $this->setGet('search', $search);

        return $this;
    }

    /**
     * (optional)
     * Specifies maximum number of items to return. Default is 50. Maximum result limit is 1000.
     *
     * @param  integer    $limit
     * @return Lists
     * @throws \Exception
     */
    public function setResultLimit($limit)
    {
        if ((int) $limit > self::MAXLIMIT) {
            throw new \Exception('Max ' . self::MAXLIMIT . ' results is allowed');
        }

        $this->setGet('result_limit', (int) $limit);

        return $this;
    }

    /**
     * (optional)
     * Specifies how many items should be skipped at the beginning of the result set. Default is 0.
     *
     * @param  integer $offset
     * @return Lists
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

    /**
     * (optional)
     * Specifies parameters by which returned result should be ordered.
     * Default sort order is ascending and can be omitted.
     * Multiple parameters should be separated by comma.
     *
     * @param  string $orderBy
     * @param  string $order
     * @return Lists
     */
    public function setOrderBy($orderBy, $order = 'asc')
    {
        $this->setGet('order_by', $orderBy . ':' . $order);

        return $this;
    }
}
