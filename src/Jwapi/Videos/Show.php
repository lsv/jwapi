<?php
namespace Jwapi\Videos;

use Jwapi\Api\Api;
use Jwapi\Traits;

class Show extends Api
{
    use Traits\VideoKey;

    protected $url = '/videos/show';

}