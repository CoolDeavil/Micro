<?php
###################################
# App General Settings
###################################
const APP_LANG = 'pt';
const CAPTCHA_LENGTH = 8;
const APP_TITTLE = 'API';


const STYLE = 0;
const SCRIPT = 1;

const BUILD_RELEASE = true;
const DEV_SERVER_PORT = 3000;
//define("DEV_SERVER_URL", "http://$_SERVER[HTTP_HOST]" . ':'.DEV_SERVER_PORT.'/');
const DEV_SERVER_URL = "http://localhost" . ':' . DEV_SERVER_PORT . '/';

// Include Files
const BOOTSTRAP = 'bootstrap.php';
const ROUTE_FILE = 'routes.php';
const NAV_MENU = 'navigation.php';
const ALLOWED_CORS = 'cors.config.php';
const MIDDLEWARE = 'middleware.pipe.php';
const MODULES = 'modules.pipe.php';
const TEMPLATES = 'micro.nav.php';
//const TEMPLATES = 'pure.nav.php';
//const TEMPLATES = 'twitter.nav.php';
//const TEMPLATES = 'bulma.nav.php';
const AVATAR_IMG = 'default_avatar.png';

const APP_VIEWS = APP_ROOT . "Views" . DIRECTORY_SEPARATOR;
const APP_PHP_VIEWS = APP_ROOT . "ViewsPHP" . DIRECTORY_SEPARATOR;
const APP_PHP_LAYOUT = APP_ROOT . "ViewsPHP/layout" . DIRECTORY_SEPARATOR;

define('APP_ASSET_BASE', "http://$_SERVER[HTTP_HOST]/");
const PATH_BUILD_TABLES = APP_ROOT . 'Database' . DIRECTORY_SEPARATOR;

define('APP_CONFIG', realpath('..' . DIRECTORY_SEPARATOR . PSR4_FOLDER) . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR);
define('ALLOWED_CORS_FILE', realpath('..' . DIRECTORY_SEPARATOR . PSR4_FOLDER) . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR. ALLOWED_CORS);
define('MIDDLEWARE_PIPE', realpath('..' . DIRECTORY_SEPARATOR . PSR4_FOLDER) . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR. MIDDLEWARE);
define('MODULES_PIPE', realpath('..' . DIRECTORY_SEPARATOR . PSR4_FOLDER) . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR. MODULES);
define('APP_ROUTES_FILE', realpath('..' . DIRECTORY_SEPARATOR . PSR4_FOLDER) . DIRECTORY_SEPARATOR . ROUTE_FILE );
define('APP_BOOTSTRAP', realpath('..' . DIRECTORY_SEPARATOR . PSR4_FOLDER) . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR. BOOTSTRAP);
define('APP_NAVBAR_TEMPLATES', realpath('..' . DIRECTORY_SEPARATOR . PSR4_FOLDER) . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR. TEMPLATES);
define('APP_NAVBAR_FILE', realpath('..' . DIRECTORY_SEPARATOR . PSR4_FOLDER) . DIRECTORY_SEPARATOR . NAV_MENU );
define('APP_PUB_HTML', "http://$_SERVER[HTTP_HOST]/");
define('APP_ASSET', realpath('..'.DIRECTORY_SEPARATOR.'assets/').DIRECTORY_SEPARATOR);
define('APP_STORAGE_USER', realpath('..'.DIRECTORY_SEPARATOR) .DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'users'.DIRECTORY_SEPARATOR);
define('DEF_AVATAR_PATH', realpath('..'.DIRECTORY_SEPARATOR.'public').DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR);

define('APP_STORAGE_DOWNLOADS', realpath('../') .DIRECTORY_SEPARATOR. 'storage'.DIRECTORY_SEPARATOR.'downloads'.DIRECTORY_SEPARATOR);
define('APP_STORAGE_CACHED', realpath('../') .DIRECTORY_SEPARATOR. 'storage'.DIRECTORY_SEPARATOR.'cashed_files'.DIRECTORY_SEPARATOR);
define('STORAGE_CACHE', realpath('../') .DIRECTORY_SEPARATOR. 'storage'.DIRECTORY_SEPARATOR.'cashed_files'.DIRECTORY_SEPARATOR);

define('AVATAR_FILTER_PATH', realpath('../').DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'circle_avatar_mask.png');

const ACTIVE_NAV_TEMPLATE = 'custom';
const APP_NAV_TEMPLATE = APP_ROOT . "ViewsPHP" . DIRECTORY_SEPARATOR. "partials". DIRECTORY_SEPARATOR .ACTIVE_NAV_TEMPLATE.DIRECTORY_SEPARATOR;
const APP_VIEWS_PARTIALS = APP_ROOT . "ViewsPHP" . DIRECTORY_SEPARATOR. "partials". DIRECTORY_SEPARATOR;


const CAPTCHA_FONT = './fonts/AnonymousClippings.ttf';

define('NAV_LINKS_PATH', realpath('..'.DIRECTORY_SEPARATOR.'Micro').DIRECTORY_SEPARATOR);
const NAV_BUILD_FILE = 'navigation.php';

const ACTIVE_NAV_LINK_CLASS = 'active';
const RENDER_NAV = true;
const MULTI_LANGUAGE = true;
const TRANSLATE = false;
const RENDER_SIDE_NAV = false;
const LOG_NAV_CONFIG = false;
const NAV_CONFIG_COOKIE = false;

########################
# App Crypt
########################
const APP_SECRET_KEY = 'Some-Secret-String';
const APP_KEY = 'A1f05ac35a38eZee5167be11a27aae9d';
const APP_KEY_ALGORITHM = 'md5';



