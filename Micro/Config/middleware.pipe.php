<?php

return [
    \API\Middleware\CORSHandler::class,
    \API\Middleware\LastIntent::class,
    \API\Middleware\KeepMeLogged::class,
    \API\Middleware\TrailingSlash::class,
];
