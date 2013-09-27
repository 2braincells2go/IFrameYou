<?php

require_once 'IFrameYou.php';

echo new IFrameYou( "http://www.youtube.com/watch?v=tj7al6MXu7U", 'config.php' );
echo new IFrameYou( "http://vimeo.com/32397612", 'config.php' );
echo new IFrameYou( "http://this_is_a_url.com/", 'config.php' );
echo new IFrameYou( "http://www.dailymotion.com/video/xzz28x_roubo-milionario-em-cannes_news", 'config.php' );
echo new IFrameYou( "http://www.ted.com/talks/eli_beer_the_fastest_ambulance_a_motorcycle.html", 'config.php' );
echo new IFrameYou( "http://www.break.com/video/the-drunkest-russian-fight-you-ll-see-today-2502499", 'config.php' );
echo new IFrameYou( "http://www.gamespot.com/events/game-crib-tsm-snapdragon/gamecrib-season-2-tsm-episode-5-out-of-range-6412285/", 'config.php' );
echo new IFrameYou( "http://www.twitch.tv/tsm_dyrus", 'config.php' );
echo new IFrameYou( "https://vine.co/v/hmI1p39TaIi", 'config.php' );

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
