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
namespace Jwapi\Videos;

use Guzzle\Http\Message\Response;
use Jwapi\Api\Api;
use Jwapi\Traits;
use Jwapi\Search as SearchObject;

/**
 * Return a list of videos.
 * @package Jwapi\Videos
 */
class Lists extends Api
{
    //use Traits\Tags;
    //use Traits\Limits;
    //use Traits\Dates;
    //use Traits\OrderBy;
    //use Traits\Search;

    /**
     * Search by all tags
     * @var string
     */
    const TAGS_ALL = 'all';

    /**
     * Search by any tags
     * @var string
     */
    const TAGS_ANY = 'any';

    /**
     * Tags
     * @var array
     */
    protected $tags = array();

    /**
     * Tag modes
     * @var array
     */
    static private $tagsmodes = array(
        self::TAGS_ALL,
        self::TAGS_ANY
    );

    /**
     * Search by unknown medias
     * @var string
     */
    const MEDIAFILTER_UNKNOWN = 'unknown';

    /**
     * Search by audio medias
     * @var string
     */
    const MEDIAFILTER_AUDIO = 'audio';

    /**
     * Search by video medias
     * @var string
     */
    const MEDIAFILTER_VIDEO = 'video';

    /**
     * Mediafilters
     * @var array
     */
    static private $mediafilters = array(
        self::MEDIAFILTER_UNKNOWN,
        self::MEDIAFILTER_AUDIO,
        self::MEDIAFILTER_VIDEO
    );

    /**
     * Search by created videos
     * @var string
     */
    const STATUSFILTER_CREATED = 'created';

    /**
     * Search by processing videos
     * @var string
     */
    const STATUSFILTER_PROCESSING = 'processing';

    /**
     * Search by ready videos
     * @var string
     */
    const STATUSFILTER_READY = 'ready';

    /**
     * Search by updating videos
     * @var string
     */
    const STATUSFILTER_UPDATING = 'updating';

    /**
     * Search by failed videos
     * @var string
     */
    const STATUSFILTER_FAILED = 'failed';

    /**
     * Statusfilters
     * @var array
     */
    static private $statusfilters = array(
        self::STATUSFILTER_CREATED,
        self::STATUSFILTER_PROCESSING,
        self::STATUSFILTER_READY,
        self::STATUSFILTER_UPDATING,
        self::STATUSFILTER_FAILED
    );

    /**
     * Maximum limit
     * @var integer
     */
    const MAXLIMIT = 1000;

    /**
     * {@inherit}
     */
    protected $path = '/videos/list';

    /**
     * (optional)
     * Tags search mode:
     * TAGS_ALL: A video will only be listed if it has all tags specified in the tags parameter.
     * TAGS_ANY: A video will be listed if it has at least one tag specified in the tags parameter.
     *
     * @param string $mode
     * @return Lists
     *
     * @throws \InvalidArgumentException
     */
    public function setTagsMode($mode = self::TAGS_ALL)
    {
        if (in_array($mode, self::$tagsmodes)) {
            $this->setGet('tags_mode', $mode);
            return $this;
        }

        throw new \InvalidArgumentException('Mode ' . $mode . ' is invalid');

    }

    /**
     * (optional)
     * List only videos with the specified media types. Filter string can include the following media types:
     * MEDIAFILTER_UNKNOWN: List only videos with media type unknown.
     * MEDIAFILTER_AUDIO: List only videos with media type audio.
     * MEDIAFILTER_VIDEO: List only videos with media type video.
     *
     * @param string $mediafilter
     * @return Lists
     *
     * @throws \InvalidArgumentException
     */
    public function setMediaTypesFilter($mediafilter = self::MEDIAFILTER_VIDEO)
    {
        if (in_array($mediafilter, self::$mediafilters)) {
            $this->setGet('mediatypes_filter', $mediafilter);
            return $this;
        }

        throw new \InvalidArgumentException('Media type filter: ' . $mediafilter . ' is invalid');
    }

    /**
     * (optional)
     * List only videos with the specified statuses. Filter string can include the following statuses:
     * STATUSFILTER_READY: List only videos with status ready.
     * STATUSFILTER_CREATED: List only videos with status created.
     * STATUSFILTER_PROCCESSING: List only videos with status processing.
     * STATUSFILTER_UPDATING: List only videos with status updating.
     * STATUSFILTER_FAILED: List only videos with status failed.
     *
     * @param string $statusfilter
     * @return Lists
     *
     * @throws \InvalidArgumentException
     */
    public function setStatusFilter($statusfilter = self::STATUSFILTER_READY)
    {
        if (in_array($statusfilter, self::$statusfilters)) {
            $this->setGet('statuses_filter', $statusfilter);
            return $this;
        }

        throw new \InvalidArgumentException('Status filter: ' . $statusfilter . ' is invalid');
    }

    /**
     * {@inherit}
     */
    protected function beforeRun()
    {
        $this->beforeTags();
    }

    /**
     * (optional)
     * Set multiple tags
     *
     * @param array $tags
     * @return Lists
     */
    public function setTags(array $tags)
    {
        foreach($tags as $tag) {
            $this->addTag($tag);
        }
        return $this;
    }

    /**
     * (optional)
     * Add a single tag
     *
     * @param string $tag
     * @return Lists
     */
    public function addTag($tag)
    {
        $this->tags[] = $tag;
        return $this;
    }

    /**
     * Run before actual request
     */
    protected function beforeTags()
    {
        if ($this->tags) {
            $this->setGet('tags', implode(',', $this->tags), false);
        }
    }

    /**
     * (optional)
     * Specifies maximum number of items to return. Default is 50. Maximum result limit is 1000.
     *
     * @param integer $limit
     * @return Lists
     * @throws \Exception
     */
    public function setResultLimit($limit)
    {
        if ((int)$limit > self::MAXLIMIT) {
            throw new \Exception('Max ' . self::MAXLIMIT . ' results is allowed');
        }

        $this->setGet('result_limit', (int)$limit);
        return $this;
    }

    /**
     * (optional)
     * Specifies how many items should be skipped at the beginning of the result set. Default is 0.
     *
     * @param integer $offset
     * @return Lists
     */
    public function setResultOffset($offset)
    {
        $this->setGet('result_offset', (int)$offset);
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
        $total = (int)$data['total'];
        $offset = (int)$data['offset'];
        $limit = (int)$data['limit'];

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
        $offset = (int)$data['offset'];
        $limit = (int)$data['limit'];

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
     * UTC date starting from which videos should be returned.
     * Default is the first day of the current month.
     *
     * @param \DateTime $date
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
     * @param \DateTime $date
     * @return Lists
     */
    public function setEndDate(\DateTime $date)
    {
        $this->setGet('end_date', $date->getTimestamp());
        return $this;
    }

    /**
     * (optional)
     * Specifies parameters by which returned result should be ordered.
     * Default sort order is ascending and can be omitted.
     * Multiple parameters should be separated by comma.
     *
     * @param string $orderBy
     * @param string $order
     * @return Lists
     */
    public function setOrderBy($orderBy, $order = 'asc')
    {
        $this->setGet('order_by', $orderBy . ':' . $order);
        return $this;
    }

    /**
     * (optional)
     * Set what you want to search for
     *
     * @param SearchObject $search
     * @return Lists
     */
    public function setSearch(SearchObject $search)
    {
        $this->setGet('search', $search->__toString());
        return $this;
    }

} 