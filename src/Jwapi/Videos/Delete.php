<?php
namespace Jwapi\Videos;

use Jwapi\Api\Api;
use Jwapi\Traits;

class Delete extends Api
{
    use Traits\VideoKey;

    protected $url = '/videos/delete';

} 