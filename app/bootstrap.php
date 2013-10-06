<?php
/**
 * Created by PhpStorm.
 * User: madesst
 * Date: 28.09.13
 * Time: 16:48
 */
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../lib/Application.php';
require_once __DIR__ . '/../lib/BaseController.php';

$app = EA\Application::getInstance();

if (!defined('ENVIRONMENT')) {
	define('ENVIRONMENT', 'dev');
}

if (ENVIRONMENT == 'dev') {
	$app['debug'] = true;
}

// регистрируем все сервисы для приложения
require_once 'configs/services.php';

// роутинги
require_once 'configs/routes.php';

if (ENVIRONMENT == 'cli') {
	return $app->boot();
}

$app->run();