<?php

use MASNathan\IFrameYou\IFrameYou;

//require_once 'IFrameYou.php';
require_once '../vendor/autoload.php';

/*
//Setthing special configs on the fly
$my_configs = array(
	IFrameYou::DOMAIN_OTHER => array(
		'height'		=> 315,
		'width'			=> 560,
		'scrolling'		=> 'no',
	),
);

$scrolless_iframe = new IFrameYou("http://masnathan.users.phpclasses.org/", $my_configs);

echo $scrolless_iframe;
*/

$urls = array(
	"http://www.youtube.com/watch?v=tj7al6MXu7U",
	"http://vimeo.com/32397612",
	"http://this_is_a_url.com/",
	"http://www.dailymotion.com/video/xzz28x_roubo-milionario-em-cannes_news",
	"http://www.ted.com/talks/eli_beer_the_fastest_ambulance_a_motorcycle.html",
	"http://www.break.com/video/the-drunkest-russian-fight-you-ll-see-today-2502499",
	"http://www.gamespot.com/events/game-crib-tsm-snapdragon/gamecrib-season-2-tsm-episode-5-out-of-range-6412285/",
	"http://www.twitch.tv/tsm_dyrus",
	"https://vine.co/v/hmI1p39TaIi",
);

class MyCostumIFrame extends IFrameYou
{

	public function __construct($url)
	{
		parent::__construct($url);

		$properties = array(
			'height'		=> 315,
			'width'			=> 560,
			'frameborder'	=> 0,
			'allowfullscreen',
			'webkitAllowFullScreen',
			'mozallowfullscreen',
		);

		$this->setProperties('*', $properties);

		$this->addTemplate('youtube', '//www.youtube.com/embed/{query:v}', $properties, array(
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
			));
	}
}


foreach ($urls as $url) {
	//$iframe = new IFrameYou($url);
	$iframe = new MyCostumIFrame($url);
	/*
	echo '<pre>';	
	print_r($iframe->getDomain());
	echo PHP_EOL;
	print_r($iframe->getTemplateOptions());
	echo PHP_EOL;
	print_r(htmlentities($iframe));
	echo '</pre>';
	//*/
	echo $iframe;
}

