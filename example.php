<?php

require_once '1.0/IFrameYou.php';

echo new IFrameYou( "http://www.youtube.com/watch?v=tj7al6MXu7U", '1.0/config.php' );
echo new IFrameYou( "http://vimeo.com/32397612", '1.0/config.php' );
echo new IFrameYou( "http://this_is_a_url.com/", '1.0/config.php' );

