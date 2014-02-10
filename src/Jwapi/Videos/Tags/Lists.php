<?php
namespace Jwapi\Videos\Tags;

use Jwapi\Api\Api;
use Jwapi\Traits;

class Lists extends Api
{
    use Traits\Limits;

    /**
     * @param string $search
     * @return $this
     */
    public function setSearch($search)
    {
        $this->setGet('search', $search);
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

} 