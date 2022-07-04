<?php


namespace API\Core\Render;



use API\Core\Container\MicroDI;
use API\Core\Utils\NavBuilder\NavBuilder;
use API\Interfaces\RenderInterface;

class PHPRender implements RenderInterface
{
    private array $globals = [];
    private string $path;
    public array $styleSheets = [];
    public array $scripts = [];
    private PHPRenderExtensions $extensions;
    private array $functions;
    public function __construct(PHPRenderExtensions $extensions){
        $this->path = APP_VIEWS;
        $this->extensions = $extensions;
        $this->loadExtensions();
    }
    public function loadExtensions()
    {
        foreach ($this->extensions->getFunctions() as $extension) {
            $this->functions[$extension->getName()] = $extension;
        }
    }
    public function render(string $view, array $params = []): bool|array|string
    {



//        dump('WE START HERE');
//        die;
        return $this->compile($view,APP_PHP_VIEWS,$params);
    }
    public function template($templateName, $params = []): bool|array|string
    {
        return $this->compile($templateName,APP_VIEWS_PARTIALS,$params);
    }
    public function layout($templateName, $params = []): bool|array|string
    {
        return $this->compile($templateName,APP_NAV_TEMPLATE,$params);
    }
    private function compile(string $view, string $path, array $params = []): array|bool|string
    {
        $level = ob_get_level();
        ob_start();
        $renderer = $this;
//        $ioc = MicroDI::getInstance([]);
        try {
            extract($params);
            extract($this->globals);
            require($path.$view.'.php');
            $content = ob_get_clean();
        } catch (\Error $e) {
            while (ob_get_level() > $level) {
                ob_end_clean();
            }
            throw $e;
        }
        $regex = '/\{\{(.*?)\}\}/';
        $matches = [];
        preg_match_all($regex,$content, $matches);
        foreach ($matches[1] as $key => $match){
            $parsed = $this->extensions->parseRule($match);
            $func = $this->functions[$parsed[0]];
            $res = call_user_func([$func->getClass(),$func->getMethod()],$parsed[1]);
            $content = str_replace($matches[0][$key],$res,$content);
        }
        return $content;
    }
    public function addStyle(string $style): self
    {
        $this->styleSheets[] = $style;
        return $this;
    }
    public function addSScript(string $script): self
    {
        $this->scripts[] = $script;
        return $this;
    }
    public function addPath(string $path): void
    {
        // TODO: Implement addPath() method.
    }
    public function addGlobal(string $key, $value): void
    {
        // TODO: Implement addGlobal() method.
    }
}