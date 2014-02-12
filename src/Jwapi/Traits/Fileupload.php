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

use Jwapi\Api\Upload;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class Fileupload
 * @package Jwapi\Traits
 */
trait Fileupload
{

    /**
     * File
     * @var SplFileInfo
     */
    protected $file;

    /**
     * {@inherit}
     */
    protected function afterRun()
    {
        if ($this->file instanceof SplFileInfo) {
            $upload = new Upload($this, $this->file, $this->fileupload);
            return $upload->send(false);
        }

        return parent::afterRun();
    }

} 