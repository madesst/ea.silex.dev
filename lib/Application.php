<?php
/**
 * Created by PhpStorm.
 * User: madesst
 * Date: 28.09.13
 * Time: 16:37
 */

namespace EA;

class Application
{
	private static $app = null;

	public static function getInstance()
	{
		if (!self::$app){
			self::$app = new \Silex\Application();
			return self::$app;
		}

		return self::$app;
	}
}