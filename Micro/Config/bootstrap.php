<?php

use API\Controllers\MicroController;
use API\Core\Router\MRoute;
use API\Core\App\{
    Dispatcher,
    Micro
};;
use API\Core\Database\Database;
use API\Core\Render\{PHPRender, PHPRenderExtensions, TwigRenderer, TwigRendererExtensions};
use API\Core\Router\MRouter;
use API\Core\Utils\{NavBuilder\NavBuilder, ScriptLoader, Translate, Validator};
use API\Interfaces\{ContainerInterface, RenderInterface, RouterInterface};
use API\Middleware\{ CORSHandler, KeepMeLogged, LastIntent, TrailingSlash};
use API\Repository\{GeneralRepository};

use GuzzleHttp\Psr7\ServerRequest;
use Twig\{
    Environment,
    Extension\DebugExtension,
    Loader\FilesystemLoader
};

return [
    // App System
    Micro::class => function(ContainerInterface $container){
        return new Micro($container);
    },
    Translate::class => function () {
        return Translate::getInstance();
    },
    Validator::class => function(ContainerInterface $ioc){
        return new Validator($ioc);
    },
    ScriptLoader::class => function(){
        return ScriptLoader::getInstance();
    },
    NavBuilder::class => function (ContainerInterface $container) {
        $router = $container->get(RouterInterface::class);
        $render = new PHPRender(new PHPRenderExtensions($container));
        $translate = $container->get(Translate::class);
        return new NavBuilder($router, $render, $translate);
    },
    // Interfaces
    RouterInterface::class => function (ContainerInterface $container) {
        return MRouter::getInstance(ServerRequest::fromGlobals(),$container);
    },
    MRoute::class => function($args){
        extract($args);
        /** @var $route */
        /** @var $callable */
        /** @var $method */
        /** @var $name */
        return new MRoute($route, $callable, $method, $name);
    },
    RenderInterface::class => function (ContainerInterface $container) {
        $loader = new FilesystemLoader(APP_VIEWS);
        $twig = new Environment($loader, [
            'cache' => false,
            'debug' => true,
        ]);
        $twig->addExtension(new DebugExtension());
        $twig->addExtension(new TwigRendererExtensions($container));
        return new TwigRenderer($loader, $twig,$container);

//        return new PHPRender(new PHPRenderExtensions($container));
    },
    // Repos
    GeneralRepository::class => function(){
        return new GeneralRepository(Database::getInstance());
    },
    // Controllers
    MicroController::class => function ($args, ContainerInterface $ioc ){
        extract($args);
        /** @var $router RouterInterface */
        /** @var $render RenderInterface */
        return new MicroController(
            $router,
            $render,
            new Validator($ioc)
        );
    },
    // System Middleware
    Dispatcher::class => function(ContainerInterface $ioc){
        return new Dispatcher($ioc);
    },
    // Middleware
    LastIntent::class => function () {
        $ignored = [
            '/error404',
        ];
        return new LastIntent($ignored);
    },
    CORSHandler::class => function(){
        return new CORSHandler();
    },
    TrailingSlash::class => function(){
        return new TrailingSlash();
    },
    KeepMeLogged::class => function(){
        return new KeepMeLogged();
    },
    // Validations
    'minLength' => function(ContainerInterface $container){
        $translate = $container->get(Translate::class);
        return new \API\Validation\MinLength($translate);
    },
    'notEmpty' => function(ContainerInterface $container){
        $translate = $container->get(Translate::class);
        return new \API\Validation\NotEmpty($translate);
    },
    'range' => function(ContainerInterface $container){
        $translate = $container->get(Translate::class);
        return new \API\Validation\Range($translate);
    },
    'securePass' => function(ContainerInterface $container){
        $translate = $container->get(Translate::class);
        return new \API\Validation\SecurePass($translate);
    },
    'checkEmail' => function(ContainerInterface $container){
        $translate = $container->get(Translate::class);
        return new \API\Validation\ValidEMail($translate);
    },
    'noZeroSelection' => function(ContainerInterface $container){
        $translate = $container->get(Translate::class);
        return new \API\Validation\NoZeroSelection($translate);
    },
    'checked' => function(ContainerInterface $container){
        $translate = $container->get(Translate::class);
        return new \API\Validation\Checked($translate);
    },
    'equalTo' => function (ContainerInterface $container) {
        return new \API\Validation\EqualTo( $container->get(Translate::class));
    },
];

