<?php

use MASNathan\IFrameYou\IFrameYou;

require_once '../vendor/autoload.php';

$iframe = new IFrameYou('http://www.youtube.com/watch?v=tj7al6MXu7U', [
    'height'      => 315,
    'width'       => 560,
    'frameborder' => 0,
    'allowfullscreen',
    'webkitAllowFullScreen',
    'mozallowfullscreen',
    'class'       => 'my-fancy-iframe'
    ]);

echo $iframe;
