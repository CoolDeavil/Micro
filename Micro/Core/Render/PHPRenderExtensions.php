<?php


namespace API\Core\Render;

use API\Core\Container\MicroDI;
use API\Core\Utils\Translate;
use API\Models\RenderFunction;
use JetBrains\PhpStorm\Pure;

class PHPRenderExtensions
{
    private MicroDI $ioc;

    public function __construct(MicroDI $ioc)
    {
        $this->ioc = $ioc;
    }

    #[Pure] public function getFunctions() : array
    {
        return [
            new RenderFunction('asset',[$this,'asset']),
            new RenderFunction('bolder',[$this,'bolder']),
            new RenderFunction('trans',[$this,'translate']),
        ];
    }
    public function parseRule(string $rule): array
    {
        $func = trim(substr($rule,0,strpos($rule,'(')));
        $param = trim(substr($rule,strpos($rule,'('),strlen($rule)-1));
        $param = trim($param,'(');
        $param = trim($param,')');
        return [$func,$param];
    }
    public function asset(string $element, $params = []): string
    {
        $element = trim($element,"'");
        return APP_ASSET_BASE .$element;
    }
    public function bolder(string $element, $params = []): string
    {
        return '<strong style="color: orangered">' .$element .'</strong>' ;
    }
    public function translate($key): ?string
    {
        if ($key === null || $key === '') {
            return null;
        }
        /**@var $tr Translate */
        $tr = $this->ioc->get(Translate::class);
        return $tr->translate($key);
    }

}