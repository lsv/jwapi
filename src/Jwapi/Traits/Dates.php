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
 * Class Dates
 * @package Jwapi\Traits
 */
trait Dates
{

    /**
     * (optional)
     * UTC date starting from which videos should be returned.
     * Default is the first day of the current month.
     *
     * @param  \DateTime $date
     * @return Dates
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
     * @param  \DateTime $date
     * @return Dates
     */
    public function setEndDate(\DateTime $date)
    {
        $this->setGet('end_date', $date->getTimestamp());

        return $this;
    }

}
