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
     * Fileupload key
     * @var string
     */
    protected $fileupload = '';

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
            $upload->send();
            return $upload->getResponse();
        }

        return parent::afterRun();
    }

} 