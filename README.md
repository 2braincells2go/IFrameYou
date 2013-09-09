IFrameYou <a href="https://www.gittip.com/ReiDuKuduro/" target="__blank" alt="ReiDuKuduro @gittip" ><img alt="ReiDuKuduro @gittip" src="http://bottlepy.org/docs/dev/_static/Gittip.png" /></a>
=========


Simple class that generates the frames html...

It's realy simple to use, you just need to create an object like this.
```
$iframe = new IFrameYou( "http://some.url.com", "/path/to/config/file.php" );
```

The second parameter is optional, and you can either pass the path to you configuration file as a ```string``` or as an ```array```.

If you choose the use an array as second parameter, you may need to know what structure is needed, check it out at ```1.0/config.php```, not that diferent versions may have diferent structures.

Once you create the object you just need to output it to display the iframe html:
```echo $iframe```

#Video players supported
- Youtube
- Vimeo
- Dailymotion
- Ted
- Break
- GameSpot
- Twitch

You can also include regular webpages on iframes with ```IFrameYou```, if you want to set some costum configurations, use the key ```other``` for that.

#Add me to your project
git submodule add git@github.com:ReiDuKuduro/IFrameYou.git path/to/my/thingy
