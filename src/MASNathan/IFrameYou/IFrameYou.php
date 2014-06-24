<?php

namespace MASNathan\IFrameYou;

/**
 * This class can help you with the iframes, can handle the youtube video player, vimeo, and basic iframes includes
 * 
 * @package    IFrameYou
 * @author    André Filipe <andre.r.flip@gmail.com>
 * @link    https://github.com/ReiDuKuduro/IFrameYou Github Repo
 * @link    https://packagist.org/packages/masnathan/iframeyou Packagist
 * @license    MIT
 * @version    2.0
 */
class IFrameYou
{
    /**
     * Iframe URL
     * @var string
     */
    protected $url;

    /**
     * Holds all the URL parts
     * @var string
     */
    protected $url_info;

    /**
     * Holds all the possible iframe configuration templates
     * @var string
     */
    protected $templates = array();

    /**
     * This is the constructor, it does a bunch of stuff like defining the default templates and such
     * @param string $url
     * @param array $properties
     */
    public function __construct($url, array $properties = array())
    {
        $this->url = $url;

        $this->url_info = \parse_url(\trim($url)); 
           if (isset($this->url_info['path'])) {
            $this->url_info['path'] = \explode('/', \trim($this->url_info['path'], '/'));
        }
        if (isset($this->url_info['query'])) {
            \parse_str($this->url_info['query'], $this->url_info['query']);
        }

        //Default Templates
        $this->addTemplate('youtube',         '//www.youtube.com/embed/{query:v}', $properties);
        $this->addTemplate('vimeo',         '//player.vimeo.com/video/{path:0}', $properties);
        $this->addTemplate('dailymotion',     '//www.dailymotion.com/embed/video/{path:1}', $properties);
        $this->addTemplate('ted',             '//embed.ted.com/{path}', $properties);
        $this->addTemplate('break',         '//www.break.com/embed/{query:id}', $properties);
        $this->addTemplate('gamespot',         '//www.gamespot.com/videoembed/{query:id}', $properties);
        $this->addTemplate('twitch',         '//www.twitch.tv/widgets/live_embed_player.swf?channel={path:0}', $properties);
        $this->addTemplate('vine',             '//vine.co/v/{path:1}/embed/simple', $properties);
        $this->addTemplate('other',         $url, $properties);

        //Exceptions
        switch ($this->getDomain()) {
            case 'break':
                $tmp = explode('-', $this->url_info['path'][1]);
                
                $this->url_info['query']['id'] = end($tmp);
                break;
            case 'gamespot':
                $tmp = explode('-', $this->url_info['path'][2]);
                
                $this->url_info['query']['id'] = end($tmp);
                break;
        }
    }

    /**
     * Allows you to add a template for any kind of iframe
     * @param string $domain
     * @param string $template
     * @param array $properties
     * @param string $parameter
     * @return IframeYou
     */
    public function addTemplate($domain, $template, array $properties = array(), array $parameters = array())
    {
        $this->templates[$domain] = array(
                'url'        => $template,
                'properties' => $properties,
                'parameters' => $parameters
            );

        return $this;
    }

    /**
     * Allows you to set some domain specific properties
     * @param string $domain
     * @param array $properties
     * @return IframeYou
     */
    public function setProperties($domain, array $properties)
    {
        if ($domain == '*') {
            foreach ($this->templates as &$configs) {
                $configs['properties'] = $properties;
            }
        } elseif (isset($this->templates[$domain])) {
            $this->templates[$domain]['properties'] = $properties;
        }

        return $this;
    }

    /**
     * Allows you to set some domain specific parameters
     * @param string $domain
     * @param array $parameters
     * @return IframeYou
     */
    public function setParameters($domain, array $parameters)
    {
        if (isset($this->templates[$domain])) {
            $this->templates[$domain]['parameters'] = $parameters;
        }

        return $this;
    }

    /**
     * This is a magic function, you probably now what it does
     * @return string
     */
    public function __toString()
    {
        $myCostumTemplate = $this->templates[$this->getDomain()];

        $url    = $this->parseUrlTemplate($myCostumTemplate['url'], $myCostumTemplate['parameters']);
        $iframe = $this->parseHtmlTemplate($url, $myCostumTemplate['properties']);

        return $iframe;
    }

    /**
     * Parses the template with the options available (e.g.: {path}, {query}) and the url parameters passed
     * @param string $template_url
     * @param array $parameters
     * @return string
     */
    protected function parseUrlTemplate($template_url, array $parameters = array())
    {
        foreach ($this->getTemplateOptions() as $key => $value) {
            $template_url = str_replace($key, $value, $template_url);
        }

        return trim($template_url . '?' . http_build_query($parameters), '?');
    }

    /**
     * Generates the iframe HTML
     * @param string $url
     * @param array $properties
     * @return string
     */
    protected function parseHtmlTemplate($url, array $properties = array())
    {
        $tmp = array();
        foreach ($properties as $property => $value)
            if (is_string($property)) {
                $tmp[] = sprintf('%s="%s"', $property, $value);
            } else {
                $tmp[] = $value;
            }
        
        $properties = implode(' ', $tmp);

        return sprintf('<iframe src="%s" %s ></iframe>', $url, $properties);
    }

    /**
     * Returns the domain of the URL that's being used
     * @return string
     */
    public function getDomain()
    {
        foreach ($this->templates as $domain => $properties) {
            if (strpos($this->url_info['host'], $domain) !== false) {
                return $domain;
            }
        }
        return 'other';
    }

    /**
     * Returns all the available options for the URL template
     * @return array
     */
    public function getTemplateOptions()
    {
        $needles = array();
        if (isset($this->url_info['path'])) {
            $needles['{path}'] = implode('/', $this->url_info['path']);
            foreach ($this->url_info['path'] as $key => $value) {
                $needles[sprintf('{path:%s}', $key)] = $value;
            }
        }
        if (isset($this->url_info['query'])) {
            $needles['{query}'] = implode('/', $this->url_info['query']);
            foreach ($this->url_info['query'] as $key => $value) {
                $needles[sprintf('{query:%s}', $key)] = $value;
            }
        }

        return $needles;
    }
}