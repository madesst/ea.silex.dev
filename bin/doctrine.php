<?php
/**
 * Created by PhpStorm.
 * User: madesst
 * Date: 28.09.13
 * Time: 18:34
 */

use Symfony\Component\Console\Helper\HelperSet;

$commands = array();
$helperSet = require __DIR__.'/../app/configs/cli-config.php';

if ( ! ($helperSet instanceof HelperSet)) {
	foreach ($GLOBALS as $helperSetCandidate) {
		if ($helperSetCandidate instanceof HelperSet) {
			$helperSet = $helperSetCandidate;
			break;
		}
	}
}

\Doctrine\ORM\Tools\Console\ConsoleRunner::run($helperSet, $commands);
