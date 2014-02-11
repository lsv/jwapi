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
namespace Jwapi\Videos\Tags;

use Jwapi\Api\Api;
use Jwapi\Traits;

/**
 * Return a list of video tags.
 * @package Jwapi\Videos\Tags
 */
class Lists extends Api
{
    use Traits\Limits;
    use Traits\OrderBy;

    /**
     * Case-insensitive search in the name tag field. It will list all tags which name contains search string.
     *
     * @param string $search
     * @return Lists
     */
    public function setSearch($search)
    {
        $this->setGet('search', $search);
        return $this;
    }

} 