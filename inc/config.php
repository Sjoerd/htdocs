<?php

//tijdzone
date_default_timezone_set('Europe/London');
//verbinding
$db = array (
    'host' => 'localhost',
    'dbname' => 'blog',
    'user' => 'root',
    'pass' => ''
);

try
{
    $db = new PDO('mysql:host='.$db['host'].';dbname='.$db['dbname'], $db['user'], $db['pass']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->query("SET SESSION sql_mode = 'ANSI,ONLY_FULL_GROUP_BY'");
}
catch(PDOException $e) {$sMsg = 'Foutmelding: '.$e->getMessage().''; trigger_error($sMsg); }


define('SITENAAM', 'Lokaalhostje');
define('URL', 'localhost');

 ?>
