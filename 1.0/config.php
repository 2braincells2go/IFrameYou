<?php

/**
 * This is a base configuration file
 * 
 * @package	IFrameYou
 * @author	André Filipe <andre.r.flip@gmail.com>
 * @link	https://github.com/ReiDuKuduro/IFrameYou
 * @license	GPL v2
 * @version	1.0
 */

$config = array(
	/**
	 * Youtube player configurations
	 * @link https://developers.google.com/youtube/player_parameters
	 */
	'youtube' 	=> array(
		'parameters'	=> array(
			/**
			 * This parameter indicates whether the video controls will automatically hide after a video begins playing.
			 * @link https://developers.google.com/youtube/player_parameters#autohide
			 */
			'autohide'		=> 2,
			/**
			 * Sets whether or not the initial video will autoplay when the player loads.
			 * @link https://developers.google.com/youtube/player_parameters#autoplay
			 */
			'autoplay'		=> 0,
			/**
			 * This parameter specifies the color that will be used in the player's video progress bar to highlight the amount of the video that the viewer has already seen. 
			 * @link https://developers.google.com/youtube/player_parameters#color
			 */
			'color'			=> '',
			/**
			 * This parameter indicates whether the video player controls will display.
			 * @link https://developers.google.com/youtube/player_parameters#controls
			 */
			'controls'		=> 1,
			/**
			 * Setting this to 1 will enable the Javascript API.
			 * @link https://developers.google.com/youtube/player_parameters#enablejsapi
			 */
			'enablejsapi'	=> 0,
			/**
			 * Setting to 1 will cause video annotations to be shown by default, whereas setting to 3 will cause video annotation to not be shown by default.
			 * @link https://developers.google.com/youtube/player_parameters#iv_load_policy
			 */
			'iv_load_policy'=> 1,
			/**
			 * In the case of a single video player, a setting of 1 will cause the player to play the initial video again and again. In the case of a playlist player (or custom player), the player will play the entire playlist and then start again at the first video.
			 * @link https://developers.google.com/youtube/player_parameters#loop
			 */
			'loop'			=> 0,
			/**
			 * This parameter lets you use a YouTube player that does not show a YouTube logo.
			 * @link https://developers.google.com/youtube/player_parameters#modestbranding
			 */
			'modestbranding'=> 0,
			/**
			 * This parameter indicates whether the player should show related videos when playback of the initial video ends.
			 * @link https://developers.google.com/youtube/player_parameters#rel
			 */
			'rel'			=> 1,
			/**
			 * If you set the parameter value to 0, then the player will not display information like the video title and uploader before the video starts playing.
			 * @link https://developers.google.com/youtube/player_parameters#showinfo
			 */
			'showinfo'		=> 1,
			/**
			 * This parameter causes the player to begin playing the video at the given number of seconds from the start of the video.
			 * @link https://developers.google.com/youtube/player_parameters#start
			 */
			'start'			=> 0,
			/**
			 * This parameter indicates whether the embedded player will display player controls (like a 'play' button or volume control) within a dark or light control bar.
			 * @link https://developers.google.com/youtube/player_parameters#theme
			 */
			'theme'			=> 'dark',
		),
		'properties'	=> array(
			'height'		=> 315,
			'width'			=> 560,
			'frameborder'	=> 0,
			'allowfullscreen',
			'webkitAllowFullScreen',
			'mozallowfullscreen',
		),
	),
	/**
	 * Vimeo player configurations
	 * @link http://developer.vimeo.com/player/embedding
	 */
	'vimeo' 	=> array(
		'parameters'	=> array(
			/**
			 * Show the title on the video.
			 */
			'title'			=> 1,
			/**
			 * Show the user’s byline on the video.
			 */
			'byline'		=> 1,
			/**
			 * Show the user’s portrait on the video.
			 */
			'portrait'		=> 1,
			/**
			 * Specify the color of the video controls. Make sure that you don’t include the #.
			 */
			'color'			=> '00adef',
			/**
			 * Play the video automatically on load.
			 */
			'autoplay'		=> 0,
			/**
			 * Play the video again when it reaches the end.
			 */
			'loop'			=> 0,
			/**
			 * Set to 1 to enable the Javascript API.
			 * @link http://developer.vimeo.com/player/js-api
			 */
			'api'			=> 0,
			/**
			 * An unique id for the player that will be passed back with all Javascript API responses.
			 * @link http://developer.vimeo.com/player/js-api
			 */
			'player_id'		=> '',
		),
		'properties'	=> array(
			'height'		=> 315,
			'width'			=> 560,
			'frameborder'	=> 0,
			'allowfullscreen',
			'webkitAllowFullScreen',
			'mozallowfullscreen',
		),
	),
	'other' 	=> array(
		'height'		=> 315,
		'width'			=> 560,
		'allowfullscreen',
		'webkitAllowFullScreen',
		'mozallowfullscreen',
	),
);
