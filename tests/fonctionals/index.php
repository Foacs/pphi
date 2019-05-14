<?php
require_once dirname(dirname(__DIR__)) . '/vendor/autoload.php';

use PPHI\FonctionalTest\Runner;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

$whoops = new Run();
$whoops->pushHandler(new PrettyPageHandler());
$whoops->register();
$runner = new Runner();

?>
<!DOCTYPE html>
<html>
<head>
    <title>PPHI Functional Tests</title>
</head>
<body>
<h1>PPHI Functional Tests</h1>
</body>
</html>