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
     */
    public function setTagsMode($mode = self::TAGS_ALL)
    {
        $this->setGet('tags_mode', $mode);
        return $this;
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
     */
    public function setMediaTypesFilter($mediafilter = self::MEDIAFILTER_VIDEO)
    {
        $this->setGet('mediatypes_filter', $mediafilter);
        return $this;
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
     */
    public function setStatusFilter($statusfilter = self::STATUSFILTER_READY)
    {
        $this->setGet('statuses_filter', $statusfilter);
        return $this;
    }

    /**
     * {@inherit}
     */
    protected function beforeRun()
    {
        if ($this->tags) {
            $this->setGet('tags', implode(',', $this->tags));
        }
    }

} 