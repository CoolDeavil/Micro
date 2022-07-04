<?php
include  __DIR__.'/../../vendor/autoload.php';
//include  __DIR__.'/../../Micro/Config/php_globals.php';
use API\Core\Utils\Logger;

function dummyJob($data ) {


    Logger::log('DUMMY JOB STARTED EXECUTION '.$data->log );
    Logger::log('Time Start '.time() );
    sleep(5);
    Logger::log('Time End  '.time() );

}
