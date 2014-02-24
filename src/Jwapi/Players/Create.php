<?php
/**
 * This file is part of JW API.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license http://opensource.org/licenses/MIT
 * @author Martin Aarhof <martin.aarhof@gmail.com>
 * @package Jwapi
 */
namespace Jwapi\Players;

use Jwapi\Api\Api;
use Jwapi\Traits;

/**
 * Create video player.
 * @package Jwapi\Players
 */
class Create extends Api
{
    use Traits\CustomParameters;

    /**
     * JW Player 5
     * @var string
     */
    const VERSION_5 = '5';

    /**
     * JW Player 6
     * @var string
     */
    const VERSION_6 = '6';

    /**
     * Player versions
     * @var array
     */
    private static $versions = array(
        self::VERSION_5,
        self::VERSION_6
    );

    /**
     * No controlbar.
     * @var string
     */
    const CONTROLBAR_NONE = 'none';

    /**
     * Controlbar is below the video.
     * @var string
     */
    const CONTROLBAR_BOTTOM = 'bottom';

    /**
     * Controlbar is over the video.
     * @var string
     */
    const CONTROLBAR_OVER = 'over';

    /**
     * Constrol bar positions
     * @var array
     */
    private static $controlbars = array(
        self::CONTROLBAR_NONE,
        self::CONTROLBAR_BOTTOM,
        self::CONTROLBAR_OVER
    );

    /**
     * No playlist.
     * @var string
     */
    const PLAYLISTPOSITION_NONE = 'none';

    /**
     * Playlist is below the video.
     * @var string
     */
    const PLAYLISTPOSITION_BOTTOM = 'bottom';

    /**
     * Playlist is right of the video.
     * @var string
     */
    const PLAYLISTPOSITION_RIGHT = 'right';

    /**
     * Playlist is over the video.
     * @var string
     */
    const PLAYLISTPOSITION_OVER = 'over';

    /**
     * Playlist position
     * @var array
     */
    private static $playlistpositions = array(
        self::PLAYLISTPOSITION_NONE,
        self::PLAYLISTPOSITION_BOTTOM,
        self::PLAYLISTPOSITION_RIGHT,
        self::PLAYLISTPOSITION_OVER
    );

    /**
     * Maintain original dimensions.
     * @var string
     */
    const STRETCHING_NONE = 'none';

    /**
     * Stretch disproportionally to exactly match the display dimensions.
     * @var string
     */
    const STRETCHING_EXACTFIT = 'exactfit';

    /**
     * Stretch proportionally to fill the display (parts are cut off).
     * @var string
     */
    const STRETCHING_FILL = 'fill';

    /**
     * Stretch proportionally to fit the display (black borders)
     * @var string
     */
    const STRETCHING_UNIFORM = 'uniform';

    /**
     * Stretchings
     * @var array
     */
    private static $stretching = array(
        self::STRETCHING_NONE,
        self::STRETCHING_EXACTFIT,
        self::STRETCHING_FILL,
        self::STRETCHING_UNIFORM
    );

    /**
     * Do not display related videos.
     * @var string
     */
    const RELATED_NONE = 'none';

    /**
     * Display related videos when video completes.
     * @var string
     */
    const RELATED_ONCOMPLETE = 'oncomplete';

    /**
     * Add dock button to manually display related videos.
     * @var string
     */
    const RELATED_DOCK = 'dock';

    /**
     * Add dock button to manually display related videos and also display related videos when video completes.
     * @var string
     */
    const RELATED_DOCK_ONCOMPLETE = 'dock-oncomplete';

    /**
     * Related video positions
     * @var array
     */
    private static $relatedVidoes = array(
        self::RELATED_NONE,
        self::RELATED_ONCOMPLETE,
        self::RELATED_DOCK,
        self::RELATED_DOCK_ONCOMPLETE
    );

    /**
     * Stop playback after every video.
     * @var string
     */
    const REPEAT_NONE = 'none';

    /**
     * Continuously repeat only the current video.
     * @var string
     */
    const REPEAT_SINGLE = 'single';

    /**
     * Play all entries in the channel once.
     * @var string
     */
    const REPEAT_LIST = 'list';

    /**
     * Continuously repeat all videos in channel.
     * @var string
     */
    const REPEAT_ALWAYS = 'always';

    /**
     * Repeat methods
     * @var array
     */
    private static $repeats = array(
        self::REPEAT_NONE,
        self::REPEAT_SINGLE,
        self::REPEAT_LIST,
        self::REPEAT_ALWAYS
    );

    /**
     * Only display sharing shortcuts buttons in the dock.
     * @var string
     */
    const SHARING_DOCK = 'dock';

    /**
     * Display on screen sharing dialog with the video link field and sharing shortcuts buttons.
     * @var string
     */
    const SHARING_SCREEN = 'screen';

    /**
     * Display on screen sharing dialog with the video link field, embed code field and sharing shortcuts buttons.
     * @var string
     */
    const SHARING_SCREEN_EMBED = 'screen-embed';

    /**
     * Sharing methods
     * @var array
     */
    private static $sharings = array(
        self::SHARING_DOCK,
        self::SHARING_SCREEN,
        self::SHARING_SCREEN_EMBED
    );

    /**
     * Do not show captions.
     * @var string
     */
    const CAPTION_NONE = 'none';

    /**
     * Show captions and render them with a thin black outline.
     * @var string
     */
    const CAPTION_OUTLINE = 'outline';

    /**
     * Show captions and draw a black box around them.
     * @var string
     */
    const CAPTION_BLOCK = 'block';

    /**
     * Caption displays
     * @var array
     */
    private static $captions = array(
        self::CAPTION_NONE,
        self::CAPTION_OUTLINE,
        self::CAPTION_BLOCK
    );

    /**
     * Position watermark in the top left corner of the video player.
     * @var string
     */
    const WATERMARK_TOP_LEFT = 'top-left';

    /**
     * Position watermark in the top right corner of the video player.
     * @var string
     */
    const WATERMARK_TOP_RIGHT = 'top-right';

    /**
     * Position watermark in the bottom right corner of the video playe
     * @var string
     */
    const WATERMARK_BOTTOM_RIGHT = 'bottom-right';

    /**
     * Position watermark in the bottom left corner of the video player.
     * @var string
     */
    const WATERMARK_BOTTOM_LEFT = 'bottom-left';

    /**
     * Watermark positions
     * @var array
     */
    private static $watermarks = array(
        self::WATERMARK_TOP_LEFT,
        self::WATERMARK_TOP_RIGHT,
        self::WATERMARK_BOTTOM_RIGHT,
        self::WATERMARK_BOTTOM_LEFT
    );

    /**
     * No ad clied. Ads will not be served.
     * @var string
     */
    const ADVERTISING_NONE = 'none';

    /**
     * VAST/VPAID ad client. Ads served by a VAST-compliant video ad server.
     * @var string
     */
    const ADVERTISING_VAST = 'vast';

    /**
     * Google IMA ad client. In-video ads served by Google’s Dart For Publishers (DFP).
     * @var string
     */
    const ADVERTISING_GOOGLE = 'googima';

    /**
     * Advertising clients
     * @var array
     */
    private static $advertisingclients = array(
        self::ADVERTISING_NONE,
        self::ADVERTISING_VAST,
        self::ADVERTISING_GOOGLE,
    );

    /**
     * {@inherit}
     */
    protected $path = '/players/create';

    /**
     * {@inherit}
     */
    protected $required = array(
        'name'
    );

    /**
     * (required)
     * Name of the video player.
     *
     * @param string $name
     * @return Create
     */
    public function setName($name)
    {
        $this->setGet('name', $name);

        return $this;
    }

    /**
     * (optional)
     * Player version
     *
     * @param  string $version
     * @return Create
     * @throws \InvalidArgumentException
     */
    public function setVersion($version = self::VERSION_6)
    {
        if (! in_array($version, self::$versions)) {
            throw new \InvalidArgumentException('Version ' . $version . ' is not valid');
        }

        $this->setGet('version', $version);

        return $this;
    }

    /**
     * (optional)
     * Video player width
     *
     * @param int $width
     * @return Create
     */
    public function setWidth($width = 320)
    {
        $this->setGet('width', (int) $width);

        return $this;
    }

    /**
     * (optional)
     * Video player height
     *
     * @param int $height
     * @return Create
     */
    public function setHeight($height = 260)
    {
        $this->setGet('height', (int) $height);

        return $this;
    }

    /**
     * (optional)
     * Key of the skin that should be used by the player
     *
     * @param string $skinkey
     * @return Create
     */
    public function setSkin($skinkey)
    {
        $this->setGet('skin_key', $skinkey);

        return $this;
    }

    /**
     * (optional)
     * Key of the video conversion template used by this player
     *
     * @param string $template
     * @return Create
     */
    public function setTemplateKey($template)
    {
        $this->setGet('template_key', $template);

        return $this;
    }

    /**
     * (optional)
     * Controlbar position
     *
     * @param  string $controlbar
     * @return Create
     * @throws \InvalidArgumentException
     */
    public function setControlbarPosition($controlbar = self::CONTROLBAR_BOTTOM)
    {
        if (! in_array($controlbar, self::$controlbars)) {
            throw new \InvalidArgumentException('Controlbar ' . $controlbar . ' is not valid');
        }

        $this->setGet('controlbar', $controlbar);

        return $this;
    }

    /**
     * (optional)
     * Playlist position
     *
     * @param  string $position
     * @return Create
     * @throws \InvalidArgumentException
     */
    public function setPlaylistPosition($position = self::PLAYLISTPOSITION_NONE)
    {
        if (! in_array($position, self::$playlistpositions)) {
            throw new \InvalidArgumentException('Playlist position ' . $position . ' is not valid');
        }

        $this->setGet('playlist', $position);

        return $this;
    }

    /**
     * (optional)
     * Playlist size in pixels
     *
     * @param int $size
     * @return Create
     */
    public function setPlaylistSize($size = 200)
    {
        $this->setGet('playlistsize', (int) $size . 'px');

        return $this;
    }

    /**
     * (optional)
     * Defines how videos or thumbnails should be stretched
     *
     * @param  string $stretching
     * @return Create
     * @throws \InvalidArgumentException
     */
    public function setStretching($stretching = self::STRETCHING_UNIFORM)
    {
        if (! in_array($stretching, self::$stretching)) {
            throw new \InvalidArgumentException('Stretching ' . $stretching . ' is not valid');
        }

        $this->setGet('stretching', $stretching);

        return $this;
    }

    /**
     * (optional)
     * Defines player aspect ratio.
     * If you set the ratio, the responsive player will be used
     * Set ratio fx '16:9', '16:10', '4:3'
     *
     * @param string $ratio
     * @return Create
     */
    public function setAspectratio($ratio = '16:9')
    {
        $this->setGet('responsive', $this->setBoolean(true));
        $this->setGet('aspectratio', $ratio);

        return $this;
    }

    /**
     * (optional)
     * Defines whether video playback should start on player load
     *
     * @param boolean $autostart
     * @return Create
     */
    public function setAutostart($autostart)
    {
        $this->setGet('autostart', $this->setBoolean($autostart));

        return $this;
    }

    /**
     * (optional)
     * Defines whether player should show related videos:
     *
     * @param  string $related
     * @return Create
     * @throws \InvalidArgumentException
     */
    public function setShowRelatedVideos($related = self::RELATED_NONE)
    {
        if (! in_array($related, self::$relatedVidoes)) {
            throw new \InvalidArgumentException('Show related videos ' . $related . ' is not valid');
        }

        $this->setGet('related_videos', $related);

        return $this;
    }

    /**
     * (optional)
     * Defines playback repeating behaviour of the player
     *
     * @param  string $repeat
     * @return Create
     * @throws \InvalidArgumentException
     */
    public function setRepeat($repeat = self::REPEAT_LIST)
    {
        if (! in_array($repeat, self::$repeats)) {
            throw new \InvalidArgumentException('Repeat ' . $repeat . ' is not valid');
        }

        $this->setGet('repeat', $repeat);

        return $this;
    }

    /**
     * (optional)
     * Defines how sharing should be shown and what to be shared
     *
     * @param  string $sharing_player Key of the player that should be used for sharing.
     * @param  string $sharing        Defines options for the sharing plugin
     * @return Create
     * @throws \InvalidArgumentException
     */
    public function setSharing($sharing_player, $sharing = self::SHARING_DOCK)
    {
        if (! in_array($sharing, self::$sharings)) {
            throw new \InvalidArgumentException('Sharing ' . $sharing . ' is not valid');
        }

        $this->setGet('sharing_player_key', $sharing_player);
        $this->setGet('sharing', $sharing);

        return $this;
    }

    /**
     * (optional)
     * Defines whether integration with the Adobe SiteCatalyst should be enabled
     *
     * @param bool $catalyst
     * @return Create
     */
    public function setSiteCatalyst($catalyst = false)
    {
        $this->setGet('sitecatalyst', $this->setBoolean($catalyst));

        return $this;
    }

    /**
     * (optional)
     * Defines whether player should show video captions
     *
     * @param  string $display
     * @return Create
     * @throws \InvalidArgumentException
     */
    public function setDisplayCaption($display = self::CAPTION_OUTLINE)
    {
        if (! in_array($display, self::$captions)) {
            throw new \InvalidArgumentException('Display caption ' . $display . ' is not valid');
        }

        $this->setGet('captions', $display);

        return $this;
    }

    /**
     * (optional)
     * Set watermark key and position
     *
     * @param  string  $key       Key of the watermark that should be used with this video player
     * @param  int     $margin    Watermark margin from the both sides of the video player corner
     * @param  string  $position  Watermark position
     * @param  string  $clicklink TTP link to jump to when the watermark image is clicked.
     * @return Create
     * @throws \InvalidArgumentException
     */
    public function setWatermark($key, $margin = 10, $position = self::WATERMARK_BOTTOM_RIGHT, $clicklink = '')
    {
        if (! in_array($position, self::$watermarks)) {
            throw new \InvalidArgumentException('Watermark position ' . $position . ' is not valid');
        }

        if ($clicklink != '') {
            $this->setGet('watermark_clicklink', $clicklink);
        }

        $this->setGet('watermark_margin', (int) $margin);
        $this->setGet('watermark_key', $key);
        $this->setGet('watermark_position', $position);

        return $this;
    }

    /**
     * (optional)
     * Set advertising client
     *
     * @param  string $tag    URL of the ad tag that contains the pre-roll ad.
     * @param  string $client Advertising client
     * @return Create
     * @throws \InvalidArgumentException
     */
    public function setAdvertisingClient($tag, $client = self::ADVERTISING_NONE)
    {
        if (! in_array($client, self::$advertisingclients)) {
            throw new \InvalidArgumentException('Advertising client ' . $client . ' is not valid');
        }

        $this->setGet('advertising_tag', $tag);
        $this->setGet('advertising_client', $client);

        return $this;
    }

    /**
     * (optional)
     * Google Analytics Web Property ID in the form UA-XXXXX-YY.
     *
     * @param string $code
     * @return Create
     */
    public function setAnalyticscode($code)
    {
        $this->setGet('ga_web_property_id', $code);

        return $this;
    }

    /**
     * (optional)
     * An ID of a LongTail AdSolution channel.
     *
     * @param string $id
     * @return Create
     */
    public function setAdSolutionChannel($id)
    {
        $this->setGet('ltas_channel', $id);

        return $this;
    }

    /**
     * {@inherit}
     */
    protected function beforeRun()
    {
        $this->beforeCustomParameters();
    }
}
