<?php
namespace Jwapi\Traits;

use Jwapi\Api\Upload;
use Symfony\Component\Finder\SplFileInfo;

trait Fileupload
{

    protected $fileupload = '';
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