<?php

/**
 * This class can help you with the iframes, can handle the youtube video player, vimeo, and basic iframes includes
 * 
 * @package	IFrameYou
 * @author	André Filipe <andre.r.flip@gmail.com>
 * @link	https://github.com/ReiDuKuduro/IFrameYou
 * @license	GPL v2
 * @version	1.0
 */

class IFrameYou
{
	
	const DOMAIN_YOUTUBE	= 'youtube';
	const DOMAIN_VIMEO		= 'vimeo';
	const DOMAIN_OTHER		= 'other';
	
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
		$this -> _url		= $url;
		$this -> _urlInfo	= parse_url( $url );
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
		if ( strpos( $this -> _urlInfo['host'], self::DOMAIN_YOUTUBE ) !== false )
			return self::DOMAIN_YOUTUBE;
		elseif ( strpos( $this -> _urlInfo['host'], self::DOMAIN_VIMEO ) !== false )
			return self::DOMAIN_VIMEO;
		else
			return self::DOMAIN_OTHER;
	}
	
	/**
	 * Returns the iframe formated to youtube player
	 */
	private function _frameYoutube()
	{
		$src		= "http://www.youtube.com/embed/" . $this -> _urlInfo['query']['v'];
		$src		= $this -> _addParams( $src, self::DOMAIN_YOUTUBE );
		$properties	= $this -> _getProperties( self::DOMAIN_YOUTUBE );
		
		return $this -> _iFrameTemplate( $src , $properties );
	}
	
	/**
	 * Returns the iframe formated to vimeo player
	 */
	private function _frameVimeo()
	{
		$src		= "http://player.vimeo.com/video/" . reset( $this -> _urlInfo['path'] );
		$src		= $this -> _addParams( $src, self::DOMAIN_VIMEO );
		$properties	= $this -> _getProperties( self::DOMAIN_VIMEO );
		
		return $this -> _iFrameTemplate( $src , $properties );
	}
	
	/**
	 * Returns the iframe html
	 */
	private function _frameOther()
	{
		$properties	= $this -> _getProperties( self::DOMAIN_OTHER );
		
		return $this -> _iFrameTemplate( $this -> _url , $properties );
	}
	
	/**
	 * Builds the html tag for the iframe element
	 */
	private function _iFrameTemplate( $src, array $properties = array() )
	{
		$template = '<iframe src="%s" %s ></iframe>';
		
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
				'height'		=> 315,
				'width'			=> 560,
				'frameborder'	=> 0,
				'allowfullscreen',
			);
	}
}
