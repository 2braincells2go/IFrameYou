<?php

function dump( $o )
{
  echo '<pre>';
	print_r( $o );
	echo '</pre>';
}

class IFrameYou
{
	
	const DOMAIN_YOUTUBE	= 'youtube';
	const DOMAIN_OTHER		= 'other';
	
	private $_configs = array();
	
	private $_urlInfo = null;
	
	private $_url = null;
	
	function __construct( $url, $myConfig = null )
	{
		$this -> _url		= $url;
		$this -> _urlInfo	= parse_url( $url );
		if ( isset( $this -> _urlInfo['query'] ) )
			parse_str( $this -> _urlInfo['query'], $this -> _urlInfo['query'] );
		
		dump( $this -> _urlInfo );
		
		if ( is_string( $myConfig ) ) {
			if ( pathinfo( $myConfig, PATHINFO_EXTENSION ) != 'php' )
				throw new Exception( "Config file not supported!" );
			
			if ( !is_file( $myConfig ) )
				throw new Exception( "Config file does not exist!" );
			
			include $myConfig;
			
			$filename = pathinfo( $myConfig, PATHINFO_BASENAME );
			 
			if ( !isset( $$filename ) || !is_array( $$filename ) )
				throw new Exception( "Config file should have an array called \"$filename\"!" );
			
			$this -> _configs = $$filename;
		} elseif ( is_array( $myConfig ) ) {
			$this -> _configs = $myConfig;
		} elseif ( !is_null( $myConfig ) ) {
			throw new Exception( "The Config parameter should be either an \"array\" or a \"string\"!" );
		}
	}
	
	function __toString()
	{
		switch ( $this -> _getDomain() ) {
			case 'value':
				
				break;
			
			default:
				
				break;
		}
		return '';
	}
	
	private function _getDomain()
	{
		if ( strpos( $this -> _urlInfo['host'], self::DOMAIN_YOUTUBE ) )
			return self::DOMAIN_YOUTUBE;
		else
			return self::DOMAIN_OTHER;
	}
	
	private function _frameYoutube()
	{
		$src = "http://www.youtube.com/embed/" . $this -> _urlInfo['query']['v'];
		
	}
	
	private function _frameOther()
	{
		
	}
	
	/**
	 * Builds the html tag for the iframe element
	 */
	private function _iFrameTemplate( $src, array $properties = array() )
	{
		$template = '<iframe src="%s" %s ></iframe>';
		
		$tmp = array();
		foreach ( $properties as $property => $value )
			$tmp[] = sprintf( '%s="%s"', $property, $value );
		
		$properties = implode( ' ', $tmp );
		
		return sprintf( $template, $src, $properties );
	}
}
