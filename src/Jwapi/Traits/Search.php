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

use Jwapi\Search as SearchObject;

/**
 * Class Search
 * @package Jwapi\Traits
 */
trait Search
{

    /**
     * (optional)
     * Set what you want to search for
     *
     * @param  SearchObject $search
     * @return Search
     */
    public function setSearch(SearchObject $search)
    {
        $this->setGet('search', $search->__toString());

        return $this;
    }

}
