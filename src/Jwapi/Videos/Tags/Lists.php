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

use Guzzle\Http\Message\Response;
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
    use Traits\Search;

    /**
     * {@inherit}
     */
    protected $path = '/videos/tags/list';

}
