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
namespace Jwapi\Videos\Views;

use Guzzle\Http\Message\Response;
use Jwapi\Api\Api;
use Jwapi\Traits;

/**
 * List views statistics per video.
 * @package Jwapi\Videos\Views
 */
class Lists extends Api
{
    //use Traits\Limits;
    //use Traits\Dates;
    //use Traits\OrderBy;
    //use Traits\Search;
    //use Traits\Aggregate;

    /**
     * List by videos
     * @var string
     */
    const LISTBY_VIDEO = 'video';

    /**
     * List by day
     * @var string
     */
    const LISTBY_DAY = 'day';

    /**
     * List by status active
     * @var string
     */
    const STATUS_FILTER_ACTIVE = 'active';

    /**
     * List by status deleted
     * @var string
     */
    const STATUS_FILTER_DELETED = 'deleted';

    const MAXLIMIT = 1000;

    /**
     * {@inherit}
     */
    protected $path = '/videos/views/list';

    /**
     * (optional)
     * Specifies if returned videos daily views statistics should be aggregate.
     * True: Aggregate videos daily views for the specified date range.
     * False: Do not aggregate videos daily views.
     *
     * @param  bool  $aggregate
     * @return Lists
     */
    public function setAggregate($aggregate = false)
    {
        $this->setGet('aggregate', $this->setBoolean($aggregate));

        return $this;
    }

    /**
     * (optional)
     * Set what you want to search for
     *
     * Case-insensitive search in the author, description, link, md5, tags, title, video_key fields and custom fields.
     * Parameter can also include comma-separated list of fields that specifies where search should be done.
     * Search parameter can be specified in the following ways:
     * search
     * - Only videos that contain search string in at least one of the default search fields will be listed. Default search fields are: author, description, tags, title and video_key.
     * search:*
     * - Only videos that contain search string in at least one of the search fields will be listed. Search fields are: author, description, link, md5, tags, title and video_key.
     * search:field1[,field2]
     * - Only videos that contain search string in at least one of the fields specified in the list will be listed. Multiple fields in the list must be comma-separated. Allowed fields are: author, description, link, md5, tags, title and video_key.
     * search:custom.*
     * - Only videos that contain search string in at least one of the custom fields will be listed.
     * search:custom.field1[,custom.field2]
     * - Only videos that contain search string in at least one of the custom fields specified in the list will be listed. Multiple fields in the list must be comma-separated.
     * search:field1[,field2],custom.field1[,custom.field2]
     * - Only videos that contain search string in at least one of the search or custom fields specified in the list will be listed. Multiple fields in the list must be comma-separated.
     * An * wildcard field can be used if search should be done in all search fields and/or all custom search fields. For example:
     * search:*,custom.field1,custom.field2
     * search:field1,field2,custom.*
     * search:*,custom.*
     *
     * @param  string $search
     * @return $this
     */
    public function setSearch($search)
    {
        $this->setGet('search', $search);

        return $this;
    }

    /**
     * (optional)
     * Specifies videos views statistics listing type
     * LISTBY_VIDEO: Videos views statistics listed by a video
     * LISTBY_DAY: Videos views statistics listed by a day.
     *
     * @param  string $listby
     * @return Lists
     */
    public function setListBy($listby = self::LISTBY_VIDEO)
    {
        $this->setGet('list_by', $listby);

        return $this;
    }

    /**
     * (optional)
     * Specifies if returned videos daily views statistics should be grouped by year and month.
     * True: Group daily videos views statistics by year and month.
     * False: Do not group daily videos views.
     *
     * @param  bool  $groupbydays
     * @return Lists
     */
    public function setGroupByDays($groupbydays = false)
    {
        $this->setGet('group_days', $this->setBoolean($groupbydays));

        return $this;
    }

    /**
     * (optional)
     * List only videos with the specified statuses. Filter string can include the following statuses:
     * STATUS_FILTER_ACTIVE: List only videos with status active.
     * STATUS_FILTER_DELETED: List only videos with status deleted.
     *
     * @param  string $statusfilter
     * @return Lists
     */
    public function setStatusFilter($statusfilter = self::STATUS_FILTER_ACTIVE)
    {
        $this->setGet('statuses_filter', $statusfilter);

        return $this;
    }

    /**
     * (optional)
     * Specifies if videos views statistics should include days for which there is no statistics available:
     * True: Daily views statistics will include empty days. Videos views for the empty days will be set to 0.
     * False: Daily views statistics will not include empty days.
     *
     * @param  bool  $includeEmptyDays
     * @return Lists
     */
    public function setIncludeEmptyDays($includeEmptyDays = false)
    {
        $this->setGet('include_empty_days', $this->setBoolean($includeEmptyDays));

        return $this;
    }

    /**
     * (optional)
     * UTC date starting from which videos should be returned.
     * Default is the first day of the current month.
     *
     * @param  \DateTime $date
     * @return Lists
     */
    public function setStartDate(\DateTime $date)
    {
        $this->setGet('start_date', $date->getTimestamp());

        return $this;
    }

    /**
     * (optional)
     * UTC date until (and including) which videos should be returned.
     * Default is today’s date.
     *
     * @param  \DateTime $date
     * @return Lists
     */
    public function setEndDate(\DateTime $date)
    {
        $this->setGet('end_date', $date->getTimestamp());

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
