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
 * Class Tags
 * @package Jwapi\Traits
 */
trait Tags
{

    /**
     * Tags
     * @var array
     */
    protected $tags = array();

    /**
     * (optional)
     * Set multiple tags
     *
     * @param  array $tags
     * @return Tags
     */
    public function setTags(array $tags)
    {
        foreach ($tags as $tag) {
            $this->addTag($tag);
        }

        return $this;
    }

    /**
     * (optional)
     * Add a single tag
     *
     * @param  string $tag
     * @return Tags
     */
    public function addTag($tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Run before actual request
     */
    protected function beforeTags()
    {
        if ($this->tags) {
            $this->setGet('tags', implode(',', $this->tags), false);
        }
    }

}
