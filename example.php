<?php

use MASNathan\IFrameYou\IFrameYou;

//require_once 'IFrameYou.php';
require_once 'vendor/autoload.php';

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
	//"http://www.youtube.com/watch?v=tj7al6MXu7U",
	//"http://vimeo.com/32397612",
	"http://this_is_a_url.com/",
	//"http://www.dailymotion.com/video/xzz28x_roubo-milionario-em-cannes_news",
	//"http://www.ted.com/talks/eli_beer_the_fastest_ambulance_a_motorcycle.html",
	//"http://www.break.com/video/the-drunkest-russian-fight-you-ll-see-today-2502499",
	//"http://www.gamespot.com/events/game-crib-tsm-snapdragon/gamecrib-season-2-tsm-episode-5-out-of-range-6412285/",
	//"http://www.twitch.tv/tsm_dyrus",
	//"https://vine.co/v/hmI1p39TaIi",
);


foreach ($urls as $url) {
	$iframe = new IFrameYou($url);

	echo '<pre>';	
	print_r($iframe->getDomain());
	echo PHP_EOL;
	print_r($iframe->getTemplateOptions());
	echo PHP_EOL;
	print_r(htmlentities($iframe));
	echo '</pre>';

	echo $iframe;
}
