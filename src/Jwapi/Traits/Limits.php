<?php
namespace Jwapi\Traits;

use Guzzle\Http\Message\Response;

trait Limits
{

    /**
     * @param integer $limit
     * @return $this
     * @throws \Exception
     */
    public function setResultLimit($limit)
    {
        if ((int)$limit > $this->getLimit()) {
            throw new \Exception('Max ' . $this->getLimit() . ' results is allowed');
        }

        $this->setGet('result_limit', (int)$limit);
        return $this;
    }

    /**
     * @param integer $offset
     * @return $this
     */
    public function setResultOffset($offset)
    {
        $this->setGet('result_offset', (int)$offset);
        return $this;
    }

    /**
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

} 