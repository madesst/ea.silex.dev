<?php
/**
 * Created by PhpStorm.
 * User: madesst
 * Date: 28.09.13
 * Time: 18:14
 */

use \Doctrine\ORM\Tools\Console\ConsoleRunner;

define('ENVIRONMENT', 'cli');

require_once __DIR__.'/../bootstrap.php';

$em = $app['orm.em'];

return ConsoleRunner::createHelperSet($em);