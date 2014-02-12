<?php
namespace Jwapi_Tests\Videos;

use Jwapi\Videos\Lists;
use Jwapi_Tests\TestClass;

class ListsTest extends TestClass
{

    public function test_CanListVideos()
    {
        $date1 = new \DateTime();
        $date2 = $date1->add(new \DateInterval('P1D'));

        $obj = new Lists($this->getApiKey(), $this->getApiSecret());
        $obj
            ->setMediaTypesFilter(Lists::MEDIAFILTER_AUDIO)
            ->setStatusFilter(Lists::STATUSFILTER_CREATED)
            ->setTagsMode(Lists::TAGS_ALL)
            ->setStartDate($date1)
            ->setEndDate($date2)
            ->setResultLimit(1)
            ->setResultOffset(1)
            ->setOrderBy('title', 'desc')
        ;

        $url = parse_url($obj->send()->getEffectiveUrl());
        $values = array(
            'result_limit' => 1,
            'result_offset' => 1,
            'tags_mode' => Lists::TAGS_ALL,
            'mediatypes_filter' => Lists::MEDIAFILTER_AUDIO,
            'statuses_filter' => Lists::STATUSFILTER_CREATED,
            'order_by' => urlencode('title:desc'),
            'start_date' => $date1->getTimestamp(),
            'end_date' => $date2->getTimestamp()
        );

        $this->checkUrlValues($url, $values);

        $this->checkUrl($obj, $url);
        $this->checkSignature($obj, $url);
    }

    public function test_CanListRealVideos()
    {
        $obj = new Lists($this->getApiKey(), $this->getApiSecret());
        $obj
            ->setMediaTypesFilter(Lists::MEDIAFILTER_VIDEO)
            ->setOrderBy('title', 'desc');

        $request = $obj->send();
        $response = $request->json();

        $this->assertTrue(is_array($response));
        $this->assertArrayHasKey('videos', $response);
        $this->assertArrayHasKey('title', $response['videos'][0]);

    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_InvalidTagsMode()
    {
        $obj = new Lists($this->getApiKey(), $this->getApiSecret());
        $obj->setTagsMode('foo');

    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_InvalidStatusFilter()
    {
        $obj = new Lists($this->getApiKey(), $this->getApiSecret());
        $obj->setStatusFilter('foo');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_InvalidMediaFilter()
    {
        $obj = new Lists($this->getApiKey(), $this->getApiSecret());
        $obj->setMediaTypesFilter('foo');
    }

    /**
     * @expectedException \Exception
     */
    public function test_CantSetToHighLimit()
    {
        $obj = new Lists($this->getApiKey(), $this->getApiSecret());
        $obj->setResultLimit(1000000);
    }

} 