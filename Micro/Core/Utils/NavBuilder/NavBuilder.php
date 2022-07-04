<?php


namespace API\Core\Utils\NavBuilder;


use API\Core\Render\PHPRender;
use API\Core\Session\Session;
use API\Core\Utils\Translate;
use API\Interfaces\RenderInterface;
use API\Interfaces\RouterInterface;

class NavBuilder
{
    private RouterInterface $router;
    private PHPRender $render;
    private bool $translate;
    private string $currentURL;
    private Translate $tr;
    private array $navigation = [];

//    private array $config = [];
    private array $rendered = [];
    private array $renderedAuth = [];

    public function __construct(RouterInterface $router, PHPRender $render, Translate $tr)
    {
        $this->router = $router;
        $this->render = $render;
        $this->translate = TRANSLATE;
        $this->tr = $tr;
        $this->currentURL = (string) parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
    public function link($label, $url, $icon, $usage = null ): Link
    {
        return $this->navigation[] = new Link($label, $url, $icon, $usage);
    }
    public function drop($label): Drop
    {
        return $this->navigation[] = new Drop($label);
    }
    public function admin(): Auth
    {
        return $this->navigation[] = new Auth();
    }

    public function render() : string
    {
        $this->navigation = [];
        self::build();
        $templated = '';
        foreach ($this->rendered as $html) {
            $templated .= $html;
        }
        $authTemplated = '';
        foreach ($this->renderedAuth as $html) {
            $authTemplated .= $html;
        }
        return $this->render->layout('navBarTemplate', [
            'navLinks' => $templated,
            'authLinks' => $authTemplated,
            'multi_language' => MULTI_LANGUAGE?$this->render->layout('multiLanguage',[
                'aLang' => Session::get('ACTIVE_LANG')
            ]):'',
        ],
        );
    }

    private function build(): void
    {
        $nav = $this;
        include(APP_NAVBAR_FILE);
        $this->rendered = [];
        foreach ($this->navigation as $link) {
            switch (get_class($link)) {
                case PSR4.'\Core\Utils\NavBuilder\Link':
                    $this->rendered[] = self::buildLink($link);
                    break;
                case PSR4.'\Core\Utils\NavBuilder\Drop':
                    $this->rendered[] = self::buildDrop($link);
                    break;
                case PSR4.'\Core\Utils\NavBuilder\Auth':
                    $this->renderedAuth[] = self::buildAuth($link);
                    break;
            }
        }
    }
    private function buildAuth(Auth $link): string
    {
        $usage = Session::get('loggedIn') ? 'USER' : 'GUEST';
//        $usage = 'GUEST';
        $authLinks = [];
        foreach ($link->getLinks() as $link_) {
            if ($link_->getUsage() === $usage) {
                $authLinks[] = $link_;
            }
        }
        $authLinksTemplate = '';
        for($i=0; $i<count($authLinks); $i++){
            switch (get_class($authLinks[$i])){
                case PSR4.'\Core\Utils\NavBuilder\ALink':
                    $authLinksTemplate .= $this->render->layout('aLink',[
                        'route' =>  $this->router->generateURI($authLinks[$i]->getURL(),$authLinks[$i]->getParams()),
                        'avatar' => Session::loggedUserAvatar()
                    ]);
                    break;
                case PSR4.'\Core\Utils\NavBuilder\Link':
                    $lData = [
                        'active' => self::isActive($this->router->generateURI($authLinks[$i]->getURL(), $authLinks[$i]->getParams())),
                        'route' => $this->router->generateURI($authLinks[$i]->getURL(),$authLinks[$i]->getParams()),
                        'label' => TRANSLATE?
                            rawurlencode($this->tr::translate($authLinks[$i]->getLabel())):
                            rawurlencode($authLinks[$i]->getLabel()),
                        'icon' => $authLinks[$i]->getIcon(),
                    ];
                    $authLinksTemplate .= $this->render->layout('link',$lData);
                    break;
            }

        }
        return $authLinksTemplate;
    }
    private function buildLink(Link $link): string
    {
        $lData = [
          'active' => self::isActive($this->router->generateURI($link->getURL(), $link->getParams())),
          'route' => $this->router->generateURI($link->getURL(),$link->getParams()),
          'label' => TRANSLATE?
              rawurlencode($this->tr::translate($link->getLabel())):
              rawurlencode($link->getLabel()),
          'icon' => $link->getIcon(),
        ];
        return $this->render->layout('link',$lData);
    }
    private function buildDrop(Drop $drop): string
    {
        $active = '';
        $separators = $drop->getSeparator();
        $getSeparator = function()  use(&$separators) {
            if(!empty($separators)){
                return array_shift($separators);
            }
            return false;
        };

        $dropLinksArr = $drop->getLinks();
        $sep =$getSeparator();
        $dropLinks = [];
        for($link=0;$link<count($dropLinksArr);$link++){
            $lData = [
                'active' => self::isActive($this->router->generateURI($dropLinksArr[$link]->getURL(), $dropLinksArr[$link]->getParams())),
                'route' => $this->router->generateURI($dropLinksArr[$link]->getURL(),$dropLinksArr[$link]->getParams()),
                'label' => TRANSLATE?
                    rawurlencode($this->tr::translate($dropLinksArr[$link]->getLabel())):
                    rawurlencode($dropLinksArr[$link]->getLabel()),
                'icon' => $dropLinksArr[$link]->getIcon()
            ];
            $dropLinks[] = $lData;
            if($lData['active'] === ACTIVE_NAV_LINK_CLASS){
                $active = ACTIVE_NAV_LINK_CLASS;
            }
            if($sep){
                if($link === (int)$sep-1){
                    $dropLinks[] = '<a class="dropLnk separator" href="">&#9473;&#9473;&#9473;&#9473;&#9473;&#9473;&#9473;&#9473;&#9473;&#9473;&#9473;</a>';
                    $sep =$getSeparator();
                }
            }
        }
        return $this->render->layout('dropDown',[
            'dropLinks' => $dropLinks,
            'active' => $active,
            'label' =>  TRANSLATE?
                rawurlencode($this->tr::translate($drop->getLabel())):
                rawurlencode($drop->getLabel())
        ]);
    }
    private function isActive(string $link): string
    {
        if ($link === $this->currentURL) {
            return ACTIVE_NAV_LINK_CLASS;
        }
        return '';
    }
}