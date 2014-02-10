<?php
namespace Jwapi\Videos;

use Jwapi\Api\Api;
use Jwapi\Traits;

class Lists extends Api
{
    use Traits\Tags;
    use Traits\Limits;

    const TAGS_ALL = 'all';
    const TAGS_ANY = 'any';

    const MEDIAFILTER_UNKNOWN = 'unknown';
    const MEDIAFILTER_AUDIO = 'audio';
    const MEDIAFILTER_VIDEO = 'video';

    const STATUSFILTER_CREATED = 'created';
    const STATUSFILTER_PROCESSING = 'processing';
    const STATUSFILTER_READY = 'ready';
    const STATUSFILTER_UPDATING = 'updating';
    const STATUSFILTER_FAILED = 'failed';

    const MAXLIMIT = 1000;

    protected $url = '/videos/list';

    /**
     * @param string $mode
     * @return $this
     */
    public function setTagsMode($mode = self::TAGS_ALL)
    {
        $this->setGet('tags_mode', $mode);
        return $this;
    }

    /**
     * @param Search $search
     * @return $this
     */
    public function setSearch(Search $search)
    {
        $this->setGet('search', $search->__toString());
        return $this;
    }

    /**
     * @param string $mediafilter
     * @return $this
     */
    public function setMediaTypesFilter($mediafilter = self::MEDIAFILTER_VIDEO)
    {
        $this->setGet('mediatypes_filter', $mediafilter);
        return $this;
    }

    /**
     * @param string $statusfilter
     * @return $this
     */
    public function setStatusFilter($statusfilter = self::STATUSFILTER_READY)
    {
        $this->setGet('statuses_filter', $statusfilter);
        return $this;
    }

    /**
     * @param string $order
     * @return $this
     */
    public function setOrderBy($order)
    {
        $this->setGet('order_by', $order);
        return $this;
    }

    /**
     * @param \DateTime $date
     * @return $this
     */
    public function setStartDate(\DateTime $date)
    {
        $this->setGet('start_date', $date->getTimestamp());
        return $this;
    }

    /**
     * @param \DateTime $date
     * @return $this
     */
    public function setEndDate(\DateTime $date)
    {
        $this->setGet('end_date', $date->getTimestamp());
        return $this;
    }

    protected function beforeRun()
    {
        if ($this->tags) {
            $this->setGet('tags', implode(',', $this->tags));
        }
    }

} 