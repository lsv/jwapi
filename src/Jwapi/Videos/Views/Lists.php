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

use Jwapi\Api\Api;
use Jwapi\Traits;

/**
 * List views statistics per video.
 * @package Jwapi\Videos\Views
 */
class Lists extends Api
{
    use Traits\Limits;
    use Traits\Dates;
    use Traits\OrderBy;
    use Traits\Search;
    use Traits\Aggregate;

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
     * List by methods
     * @var array
     */
    private static $listbys = array(
        self::LISTBY_VIDEO,
        self::LISTBY_DAY
    );

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

    /**
     * Status filters
     * @var array
     */
    private static $statusfilters = array(
        self::STATUS_FILTER_ACTIVE,
        self::STATUS_FILTER_DELETED
    );

    /**
     * {@inherit}
     */
    protected $path = '/videos/views/list';

    /**
     * (optional)
     * Specifies videos views statistics listing type
     * LISTBY_VIDEO: Videos views statistics listed by a video
     * LISTBY_DAY: Videos views statistics listed by a day.
     *
     * @param  string $listby
     * @return Lists
     * @throws \InvalidArgumentException
     */
    public function setListBy($listby = self::LISTBY_VIDEO)
    {
        if (!in_array($listby, self::$listbys)) {
            throw new \InvalidArgumentException('List by method ' . $listby . ' is not valid');
        }

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
        $this->setListBy(self::LISTBY_DAY);
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
     * @throws \InvalidArgumentException
     */
    public function setStatusFilter($statusfilter = self::STATUS_FILTER_ACTIVE)
    {
        if (!in_array($statusfilter, self::$statusfilters)) {
            throw new \InvalidArgumentException('Status filter ' . $statusfilter . ' is not valid');
        }

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
     * {@inherit}
     */
    protected function beforeRun()
    {
        $this->beforeOrderBy();
    }

}
