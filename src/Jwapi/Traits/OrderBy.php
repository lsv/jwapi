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
namespace Jwapi\Traits;

/**
 * Class OrderBy
 * @package Jwapi\Traits
 */
trait OrderBy
{

    /**
     * Order By options
     * @var array
     */
    protected $orders = array();

    /**
     * (optional)
     * Specifies parameters by which returned result should be ordered.
     * Default sort order is ascending and can be omitted.
     * Multiple parameters should be separated by comma.
     *
     * @param  string  $orderBy
     * @param  string  $order
     * @return OrderBy
     */
    public function setOrderBy($orderBy, $order = 'asc')
    {
        $this->orders[] = $orderBy . ':' . $order;
        return $this;
    }

    /**
     * Runs just before the request
     */
    protected function beforeOrderBy()
    {
        if ($this->orders) {
            $this->setGet('order_by', implode(',', $this->orders));
        }
    }
}
