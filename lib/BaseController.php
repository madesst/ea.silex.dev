<?php
/**
 * Created by PhpStorm.
 * User: madesst
 * Date: 28.09.13
 * Time: 16:38
 */
namespace EA;

class BaseController
{
	protected $app = null;

	public function __construct(\Silex\Application $app)
	{
		$this->app = $app;
	}

	protected function getParam($key)
	{
		return $this->app['request']->get($key);
	}

	protected function render($templateName, $data = array())
	{
		if (strpos($templateName, '.twig') === false)
			$templateName .= '.twig';

		// пробрасываем объект request в шаблоны
		if (!isset($data['request']))
			$data['request'] = $this->app['request'];

		return $this->app['twig']->render($templateName, $data);
	}

	protected function path($routeName, $params = array())
	{
		return $this->app['url_generator']->generate($routeName, $params);
	}

	protected function url($routeName, $params = array())
	{
		return $this->app['url_generator']->generate($routeName, $params, true);
	}
}