<?php

/**
 * This class can help you with the iframes, can handle the youtube video player, vimeo, and basic iframes includes
 * 
<<<<<<< HEAD
 * @package  IFrameYou
 * @author   André Filipe <andre.r.flip@gmail.com>
 * @link     https://github.com/ReiDuKuduro/IFrameYou
 * @license  GPL v2
 * @version  1.1
=======
 * @package	IFrameYou
 * @author	André Filipe <andre.r.flip@gmail.com>
 * @link	https://github.com/ReiDuKuduro/IFrameYou Github Repo
 * @link	http://masnathan.users.phpclasses.org/package/8249-PHP-Generate-HTML-to-embed-video-players.html PHP Classes
 * @license	GPL v2
 * @version	1.0
>>>>>>> a25801f286dc22e6b5451d45880a4b84dad5ef97
 */

class IFrameYou
{
    
    const DOMAIN_YOUTUBE     = 'youtube';
    const DOMAIN_VIMEO       = 'vimeo';
    const DOMAIN_DAILYMOTION = 'dailymotion';
    const DOMAIN_TED         = 'ted';
    const DOMAIN_BREAK       = 'break';
    const DOMAIN_GAMESPOT    = 'gamespot';
    const DOMAIN_TWITCH      = 'twitch';
    const DOMAIN_VINE        = 'vine';
    const DOMAIN_OTHER       = 'other';
    
    /**
     * Holds all the configurations
     * @var array
     */
    private $_configs = array();
    
    /**
     * Holds the url parts
     * @var array
     */
    private $_urlInfo = null;
    
    /**
     * Iframe url
     * @var string
     */
    private $_url = null;
    
    /**
     * This is the constructor, it does a bunch of stuff
     * @param string $url
     * @param string|array $myConfig You can set either the configuration file path or an array as configuration
     */
    function __construct( $url, $myConfig = null )
    {
        $this -> _url        = $url;
        $this -> _urlInfo    = parse_url( $url );
        if ( isset( $this -> _urlInfo['path'] ) )
            $this -> _urlInfo['path'] = explode( '/', trim( $this -> _urlInfo['path'], '/' ) );
        if ( isset( $this -> _urlInfo['query'] ) )
            parse_str( $this -> _urlInfo['query'], $this -> _urlInfo['query'] );
        
        if ( is_string( $myConfig ) ) {
            if ( pathinfo( $myConfig, PATHINFO_EXTENSION ) != 'php' )
                throw new Exception( "Config file not supported!" );
            
            if ( !is_file( $myConfig ) )
                throw new Exception( "Config file does not exist!" );
            
            include $myConfig;
            
            $filename = pathinfo( $myConfig, PATHINFO_FILENAME );
            
            if ( !isset( $$filename ) || !is_array( $$filename ) )
                throw new Exception( "Config file should have an array called \"$filename\"!" );
            
            $this -> _configs = $$filename;
        } elseif ( is_array( $myConfig ) ) {
            $this -> _configs = $myConfig;
        } elseif ( !is_null( $myConfig ) ) {
            throw new Exception( "The Config parameter should be either an \"array\" or a \"string\"!" );
        }
    }
    
    /**
     * Magic function, will return the iframe HTML
     * @return string Surprise
     */
    function __toString()
    {
        switch ( $this -> _getDomain() ) {
            case self::DOMAIN_YOUTUBE :
                return $this -> _frameYoutube();
            break;
            
            case self::DOMAIN_VIMEO :
                return $this -> _frameVimeo();
            break;
            
            case self::DOMAIN_DAILYMOTION :
                return $this -> _frameDailymotion();
            break;
            
            case self::DOMAIN_TED :
                return $this -> _frameTed();
            break;
            
            case self::DOMAIN_BREAK :
                return $this -> _frameBreak();
            break;
            
            case self::DOMAIN_GAMESPOT :
                return $this -> _frameGamespot();
            break;
            
            case self::DOMAIN_TWITCH :
                return $this -> _frameTwitch();
            break;
            
            case self::DOMAIN_VINE :
                return $this -> _frameVine();
            break;
            
            case self::DOMAIN_OTHER :
            default:
                return $this -> _frameOther();
            break;
        }
    }
    
    /**
     * Returns the domain of the url
     * @return string
     */
    private function _getDomain()
    {
        if ( strpos(     $this -> _urlInfo['host'], self::DOMAIN_YOUTUBE )      !== false )
            return self::DOMAIN_YOUTUBE;
        elseif ( strpos( $this -> _urlInfo['host'], self::DOMAIN_VIMEO )        !== false )
            return self::DOMAIN_VIMEO;
        elseif ( strpos( $this -> _urlInfo['host'], self::DOMAIN_DAILYMOTION )  !== false )
            return self::DOMAIN_DAILYMOTION;
        elseif ( strpos( $this -> _urlInfo['host'], self::DOMAIN_TED )          !== false )
            return self::DOMAIN_TED;
        elseif ( strpos( $this -> _urlInfo['host'], self::DOMAIN_BREAK )        !== false )
            return self::DOMAIN_BREAK;
        elseif ( strpos( $this -> _urlInfo['host'], self::DOMAIN_GAMESPOT )     !== false )
            return self::DOMAIN_GAMESPOT;
        elseif ( strpos( $this -> _urlInfo['host'], self::DOMAIN_TWITCH )       !== false )
            return self::DOMAIN_TWITCH;
        elseif ( strpos( $this -> _urlInfo['host'], self::DOMAIN_VINE )         !== false )
            return self::DOMAIN_VINE;
        else
            return self::DOMAIN_OTHER;
    }
    
    /**
     * Builds the html tag for the iframe element
     */
    private function _iFrameTemplate( $src )
    {
        $template    = '<iframe src="%s" %s ></iframe>';
        $domain     = $this -> _getDomain();
        $src        = $this -> _addParams( $src, $domain );
        $properties = $this -> _getProperties( $domain );

        $tmp = array();
        foreach ( $properties as $property => $value )
            if ( is_string( $property ) )
                $tmp[] = sprintf( '%s="%s"', $property, $value );
            else
                $tmp[] = $value;
        
        $properties = implode( ' ', $tmp );
        
        return sprintf( $template, $src, $properties );
    }
    
    /**
     * Appends the parameters to the url, this parameter shoud be on configurations
     * @param string $url
     * @param string $domain
     * @return string
     */
    private function _addParams( $url, $domain )
    {
        if ( isset( $this -> _configs[ $domain ]['parameters'] ) )
            $url .= '?' . http_build_query( $this -> _configs[ $domain ]['parameters'] );
        
        return $url;
    }
    
    /**
     * Returns the iframe properties
     * @param string $domain
     * @return array
     */
    private function _getProperties( $domain )
    {
        if ( isset( $this -> _configs[ $domain ]['properties'] ) )
            return $this -> _configs[ $domain ]['properties'];
        else
            return array(
                'height'        => 315,
                'width'            => 560,
                'frameborder'    => 0,
            );
    }
    
    /**
     * Returns the iframe formated to youtube player
     */
    private function _frameYoutube()
    {
        $src        = "http://www.youtube.com/embed/" . $this -> _urlInfo['query']['v'];
        
        return $this -> _iFrameTemplate( $src );
    }
    
    /**
     * Returns the iframe formated to vimeo player
     */
    private function _frameVimeo()
    {
        $src        = "http://player.vimeo.com/video/" . reset( $this -> _urlInfo['path'] );

        return $this -> _iFrameTemplate( $src );
    }
    
    /**
     * Returns the iframe formated to dailymotion player
     */
    private function _frameDailymotion()
    {
        $id         = explode( '_', $this -> _urlInfo['path'][1] );
        $src         = "http://www.dailymotion.com/embed/video/" . reset( $id );
        
        return $this -> _iFrameTemplate( $src );
    }
    
    /**
     * Returns the iframe formated to TED player
     */
    private function _frameTed()
    {
        $src     = "http://embed.ted.com/" . implode( $this -> _urlInfo['path'], '/' );
        
        return $this -> _iFrameTemplate( $src );
    }
    
    /**
     * Returns the iframe formated to Break player
     */
    private function _frameBreak()
    {
        $id     = explode( '-', $this -> _urlInfo['path'][1] );
        $src    = "http://www.break.com/embed/" . end( $id );
        
        return $this -> _iFrameTemplate( $src );
    }

    /**
     * Returns the iframe formated to GameSpot player
     */
    private function _frameGamespot()
    {
        $id     = explode( '-', end( $this -> _urlInfo['path'] ) );
        $src     = "http://www.gamespot.com/videoembed/" . end( $id );
        
        return $this -> _iFrameTemplate( $src );
    }

    /**
     * Returns the iframe formated to Twitch tv player
     */
    private function _frameTwitch()
    {
        $src     = "http://www.twitch.tv/widgets/live_embed_player.swf?channel=" . reset( $this -> _urlInfo['path'] );
        
        return $this -> _iFrameTemplate( $src );
    }

    /**
     * Returns the iframe formated to Vine player
     */
    private function _frameVine()
    {
    	array_shift($this -> _urlInfo['path']);
        $src     = sprintf("https://vine.co/v/%s/embed/simple", reset( $this -> _urlInfo['path'] ));
        
        return $this -> _iFrameTemplate( $src );
    }

    /**
     * Returns the iframe html
     */
    private function _frameOther()
    {
        $properties    = $this -> _getProperties( self::DOMAIN_OTHER );
        
        return $this -> _iFrameTemplate( $this -> _url , $properties );
    }
    
}
