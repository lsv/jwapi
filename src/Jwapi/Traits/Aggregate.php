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
 * Class Aggregate
 * @package Jwapi\Traits
 */
trait Aggregate
{

    /**
     * (optional)
     * Specifies if returned videos daily views statistics should be aggregate.
     * True: Aggregate videos daily views for the specified date range.
     * False: Do not aggregate videos daily views.
     *
     * @param  bool      $aggregate
     * @return Aggregate
     */
    public function setAggregate($aggregate = false)
    {
        $this->setGet('aggregate', $this->setBoolean($aggregate));

        return $this;
    }

}
