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
 * Class Search
 * @package Jwapi\Traits
 */
trait Search
{

    /**
     * (optional)
     * Set what you want to search for
     *
     * Case-insensitive search in the author, description, link, md5, tags, title, video_key fields and custom fields.
     * Parameter can also include comma-separated list of fields that specifies where search should be done.
     * Search parameter can be specified in the following ways:
     * search
     * - Only videos that contain search string in at least one of the default search fields will be listed. Default search fields are: author, description, tags, title and video_key.
     * search:*
     * - Only videos that contain search string in at least one of the search fields will be listed. Search fields are: author, description, link, md5, tags, title and video_key.
     * search:field1[,field2]
     * - Only videos that contain search string in at least one of the fields specified in the list will be listed. Multiple fields in the list must be comma-separated. Allowed fields are: author, description, link, md5, tags, title and video_key.
     * search:custom.*
     * - Only videos that contain search string in at least one of the custom fields will be listed.
     * search:custom.field1[,custom.field2]
     * - Only videos that contain search string in at least one of the custom fields specified in the list will be listed. Multiple fields in the list must be comma-separated.
     * search:field1[,field2],custom.field1[,custom.field2]
     * - Only videos that contain search string in at least one of the search or custom fields specified in the list will be listed. Multiple fields in the list must be comma-separated.
     * An * wildcard field can be used if search should be done in all search fields and/or all custom search fields. For example:
     * search:*,custom.field1,custom.field2
     * search:field1,field2,custom.*
     * search:*,custom.*
     *
     * @param  string $search
     * @return Search
     */
    public function setSearch($search)
    {
        $this->setGet('search', $search);

        return $this;
    }

}
