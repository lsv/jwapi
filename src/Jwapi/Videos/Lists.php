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

/**
 * Return a list of videos.
 * @package Jwapi\Videos
 */
class Lists extends Api
{
    use Traits\Tags;
    use Traits\Limits;
    use Traits\Dates;
    use Traits\OrderBy;
    use Traits\Search;

    /**
     * A video will only be listed if it has all tags specified in the tags parameter.
     * @var string
     */
    const TAGS_ALL = 'all';

    /**
     * A video will be listed if it has at least one tag specified in the tags parameter.
     * @var string
     */
    const TAGS_ANY = 'any';

    /**
     * Tag modes
     * @var array
     */
    private static $tagsmodes = array(
        self::TAGS_ALL,
        self::TAGS_ANY
    );

    /**
     * List only videos with media type unknown.
     * @var string
     */
    const MEDIAFILTER_UNKNOWN = 'unknown';

    /**
     * List only videos with media type audio.
     * @var string
     */
    const MEDIAFILTER_AUDIO = 'audio';

    /**
     * List only videos with media type video.
     * @var string
     */
    const MEDIAFILTER_VIDEO = 'video';

    /**
     * Mediafilters
     * @var array
     */
    private static $mediafilters = array(
        self::MEDIAFILTER_UNKNOWN,
        self::MEDIAFILTER_AUDIO,
        self::MEDIAFILTER_VIDEO
    );

    /**
     * List only videos with status created.
     * @var string
     */
    const STATUSFILTER_CREATED = 'created';

    /**
     * List only videos with status processing.
     * @var string
     */
    const STATUSFILTER_PROCESSING = 'processing';

    /**
     * List only videos with status ready.
     * @var string
     */
    const STATUSFILTER_READY = 'ready';

    /**
     * List only videos with status updating.
     * @var string
     */
    const STATUSFILTER_UPDATING = 'updating';

    /**
     * List only videos with status failed.
     * @var string
     */
    const STATUSFILTER_FAILED = 'failed';

    /**
     * Statusfilters
     * @var array
     */
    private static $statusfilters = array(
        self::STATUSFILTER_CREATED,
        self::STATUSFILTER_PROCESSING,
        self::STATUSFILTER_READY,
        self::STATUSFILTER_UPDATING,
        self::STATUSFILTER_FAILED
    );

    /**
     * {@inherit}
     */
    protected $path = '/videos/list';

    private $mediaFilters = array();
    private $statusFilters = array();

    /**
     * (optional)
     * Tags search mode
     *
     * @param  string $mode
     * @return Lists
     *
     * @throws \InvalidArgumentException
     */
    public function setTagsMode($mode = self::TAGS_ALL)
    {
        if (! in_array($mode, self::$tagsmodes)) {
            throw new \InvalidArgumentException('Mode ' . $mode . ' is invalid');
        }

        $this->setGet('tags_mode', $mode);
        return $this;
    }

    /**
     * (optional)
     * List only videos with the specified media types.
     *
     * @param  string $mediafilter
     * @return Lists
     *
     * @throws \InvalidArgumentException
     */
    public function setMediaTypesFilter($mediafilter = self::MEDIAFILTER_VIDEO)
    {
        if (! in_array($mediafilter, self::$mediafilters)) {
            throw new \InvalidArgumentException('Media type filter: ' . $mediafilter . ' is invalid');
        }

        $this->mediaFilters[] = $mediafilter;
        return $this;
    }

    /**
     * (optional)
     * @see setMediaTypesFilter
     *
     * @param array $mediafilters
     * @return $this
     */
    public function addMediaTypesFilters(array $mediafilters)
    {
        foreach($mediafilters as $filter) {
            $this->setMediaTypesFilter($filter);
        }

        return $this;
    }

    /**
     * (optional)
     * List only videos with the specified statuses.
     *
     * @param  string $statusfilter
     * @return Lists
     *
     * @throws \InvalidArgumentException
     */
    public function setStatusFilter($statusfilter = self::STATUSFILTER_READY)
    {
        if (! in_array($statusfilter, self::$statusfilters)) {
            throw new \InvalidArgumentException('Status filter: ' . $statusfilter . ' is invalid');
        }

        $this->statusFilters[] = $statusfilter;
        return $this;
    }

    /**
     * (optional)
     * @see setStatusFilter
     *
     * @param array $statusfilters
     * @return $this
     */
    public function addStatusFilters(array $statusfilters)
    {
        foreach($statusfilters as $filter) {
            $this->setStatusFilter($filter);
        }

        return $this;
    }

    /**
     * {@inherit}
     */
    protected function beforeRun()
    {
        $this->beforeTags();
        $this->beforeOrderBy();

        if ($this->statusFilters) {
            $this->setGet('statuses_filter', implode(',', $this->statusFilters));
        }

        if ($this->mediaFilters) {
            $this->setGet('mediatypes_filter', implode(',', $this->mediaFilters));
        }

    }

}
