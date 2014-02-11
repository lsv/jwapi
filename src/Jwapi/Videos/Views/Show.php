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
namespace Jwapi\Videos\Views;

use Jwapi\Api\Api;
use Jwapi\Traits;

/**
 * Shows views statistics for a video
 * @package Jwapi\Videos\Views
 */
class Show extends Api
{
    use Traits\VideoKey;
    use Traits\Dates;

    protected $url = '/videos/views/show';

    /**
     * (optional)
     * Specifies if returned video views statistics should be grouped by year and month.
     * True: Group daily video views statistics by year and month.
     * False: Do not group daily video views.
     *
     * @param bool $groupDays
     * @return Show
     */
    public function setGroupDays($groupDays = false)
    {
        $this->setGet('group_days', $this->setBoolean($groupDays));
        return $this;
    }

    /**
     * (optional)
     * Specifies if video views statistics should include days for which there is no statistics available:
     * True: Daily views statistics will include empty days. Video views for the empty days will be set to 0.
     * False: Daily views statistics will not include empty days.
     *
     * @param bool $includeEmptyDays
     * @return Show
     */
    public function setIncludeEmptyDays($includeEmptyDays = false)
    {
        $this->setGet('include_empty_days', $this->setBoolean($includeEmptyDays));
        return $this;
    }

} 