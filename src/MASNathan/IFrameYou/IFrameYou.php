<?php

namespace MASNathan\IFrameYou;

class IFrameYou
{
	protected $url;

	protected $url_info;

	protected $templates = array();

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
        $this->addTemplate('youtube', '//www.youtube.com/embed/{query:v}', $properties);
	}

	public function addTemplate($domain, $template, $properties = array(), $parameters = array())
	{
		$this->templates[$domain] = array(
				'url'        => $template,
				'properties' => $properties,
				'parameters' => $parameters
			);

		return $this;
	}

	public function setProperties($domain, $properties)
	{
		if (isset($this->templates[$domain])) {
			$this->templates[$domain]['properties'] = $properties;
		}

		return $this;
	}

	public function setParameters($domain, $parameters)
	{
		if (isset($this->templates[$domain])) {
			$this->templates[$domain]['parameters'] = $parameters;
		}

		return $this;
	}

	public function __toString()
	{
		$myCostumTemplate = $this->templates[$this->getDomain()];

		$url    = $this->parseUrlTemplate($myCostumTemplate['url'], $myCostumTemplate['parameters']);
		$iframe = $this->parseHtmlTemplate($url, $myCostumTemplate['properties']);

		return $iframe;
	}

	protected function parseUrlTemplate($template_url, array $parameters = array())
	{
		foreach ($this->getTemplateOptions() as $key => $value) {
			$template_url = str_replace($key, $value, $template_url);
		}

		return \trim($template_url . '?' . http_build_query($parameters), '?');
	}

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

	public function getDomain()
	{
		foreach ($this->templates as $domain => $properties) {
			if (strpos($this->url_info['host'], $domain) !== false) {
				return $domain;
			}
		}
	}

	public function getTemplateOptions()
	{
		$needles = array();
		if (isset($this->url_info['path'])) {
			foreach ($this->url_info['path'] as $key => $value) {
				$needles[sprintf('{path:%s}', $key)] = $value;
			}
		}
		if (isset($this->url_info['query'])) {
			foreach ($this->url_info['query'] as $key => $value) {
				$needles[sprintf('{query:%s}', $key)] = $value;
			}
		}

		return $needles;
	}
}