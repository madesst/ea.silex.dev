<?php
/**
 * Created by PhpStorm.
 * User: madesst
 * Date: 28.09.13
 * Time: 17:12
 */

namespace EA;

use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Symfony\Component\Translation\Loader\XliffFileLoader;

$app = Application::getInstance();

$app->register(new UrlGeneratorServiceProvider());

$app->register(new FormServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new TranslationServiceProvider(), array(
	'locale' => 'ru',
	'translator.domains' => array(),
));

$app->register(new DoctrineServiceProvider(), array(
	"db.options" => array(
		"driver" => "pdo_pgsql",
		'user' => 'ea',
		'dbname' => 'ea'
	)
));

$app->register(new DoctrineOrmServiceProvider(), array(
	"orm.em.options" => array(
		"mappings" => array(
			// Using actual filesystem paths
			array(
				"type" => "yml",
				"namespace" => "Model",
				"path" => __DIR__."/../../doctrine/mapping/"
			),
		)
	)
));


$app->register(new TwigServiceProvider(), array(
	'twig.path' => __DIR__ . '/../views',
	'twig.options' => array(
		'env' => ENVIRONMENT
	)
));

$app->register(new ServiceControllerServiceProvider());

// Контроллеры

$app->before(function () use ($app) {
	$app['translator']->addLoader('xlf', new XliffFileLoader());
	$app['translator']->addResource('xlf', __DIR__.'/../../vendor/symfony/validator/Symfony/Component/Validator/Resources/translations/validators.ru.xlf', 'ru', 'validators');
});

$app['iframe.controller'] = $app->share(function() use ($app){
	require_once __DIR__ . '/../controllers/IframeController.php';
	return new HomeController($app);
});