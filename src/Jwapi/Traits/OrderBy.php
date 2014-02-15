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
        $this->setGet('order_by', $orderBy . ':' . $order);

        return $this;
    }

}
