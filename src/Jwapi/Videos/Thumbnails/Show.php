<?php
namespace Jwapi\Videos\Thumbnails;

use Jwapi\Api\Api;
use Jwapi\Traits;

class Show extends Api
{
    use Traits\VideoKey;

    protected $url = '/videos/thumbnails/show';

} 