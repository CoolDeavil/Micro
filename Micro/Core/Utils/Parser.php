<?php


namespace API\Core\Utils;



use API\Core\Session\Session;
use API\Models\NavEntry;

class Parser
{
    private array $templates = [];
    private $languages= ['pt','en','fr'];
    private $labels= [
        'pt'=>'Portuguese',
        'en'=>'English',
        'fr'=>'French',
    ];
    private string $regex = '/\{\{(.*?)\}\}/';
    private array $matches = [];
    public function __construct()
    {
        $this->templates = include_once APP_NAVBAR_TEMPLATES;;
    }
    public function buildNav(array $viewData): string
    {
        $templated =  $this->templates['NAVBAR'];
        $nav = preg_replace('#__NAV_LINKS__#',$viewData['nav_links'],$templated);
        $nav = preg_replace('#__NAV_ADMIN_LINKS__#',$viewData['nav_admin_links'],$nav);
        if($viewData['multi_language']){
            return preg_replace('#__MULTILINGUAL__#',$viewData['translation'],$nav);
        }else {
            return preg_replace('#__MULTILINGUAL__#','',$nav);
        }
    }
    public function template(string $template, array|NavEntry $data): string
    {

        return match ($template) {
            'LINK', 'DROP_ITEM' => $this->templateLink($template, $data),
            'DROP' => $this->templateDrop($template, $data),
            'LANGUAGE' => $this->templateLanguage(Session::get('ACTIVE_LANG')),
            'ALINK' => $this->templateAlink($data),
            default => '',
        };
    }
    private function templateAlink(array $avatar): string
    {
        $this->getMatches('ALINK');
        $templated = $this->templates['ALINK'];
        return $this->parse($templated, $avatar);
    }
    public function templateLanguage(string $activeLang): array|string|null
    {
        $this->getMatches('LANGUAGE');
        $curLanguage = [
            'active_language' => $activeLang
        ];
        $templated = $this->templates['LANGUAGE'];
        for($i=0;$i<count($this->matches[0]);$i++){
            $pattern = "#". $this->matches[0][$i].'#';
            $templated = preg_replace($pattern,$curLanguage[trim($this->matches[1][$i])],$templated);
        }
        $languageBody = $templated;
        $this->getMatches('LANGUAGE_ITEM');
        $langOptions = '';
       foreach ($this->languages as $lang) {
           $link = [
             'active' => $lang === $activeLang?ACTIVE_NAV_LINK_CLASS:'',
             'language' => $lang,
             'languageLabel' => $this->labels[$lang],
           ];
           $templated = $this->templates['LANGUAGE_ITEM'];
           for($i=0;$i<count($this->matches[0]);$i++){
               $pattern = "#". $this->matches[0][$i].'#';
               $templated = preg_replace($pattern,$link[trim($this->matches[1][$i])],$templated);
           }
           $langOptions .= $templated;
       }
       return  preg_replace('#__LANGUAGES__#',$langOptions,$languageBody);
    }
    private function templateDrop(string $template,array $data): string
    {
        $this->getMatches($template);
        $dropBody = [
            'dropdownLabel' => $data['dropdownLabel'],
            'active' => $data['active'],
        ];
        $templated = $this->templates[$template];
        for($i=0;$i<count($this->matches[0]);$i++){
            $pattern = "#". $this->matches[0][$i].'#';
            $templated = preg_replace($pattern,$dropBody[trim($this->matches[1][$i])],$templated);
        }
        $dropLinks = '';
        $this->getMatches('DROP_ITEM');
        foreach ($data['entry'] as $entry){
            $dropLinks  .= $this->templateDropLink($entry);
        }
        return preg_replace('#__LINKS__#',$dropLinks,$templated);
    }
    private function templateDropLink(NavEntry $data) : string {
        $link = [
            'active' => $data->getActive(),
            'link' => $data->getLink(),
            'icon' => $data->getIcon(),
            'label' => $data->getLabel(),
        ];
        $templated = $this->templates['DROP_ITEM'];
        return $this->parse($templated,$link);
    }
    private function templateLink(string $template, array $data) : string {
        $this->getMatches($template);
        $templated = $this->templates[$template];
        return $this->parse($templated,$data);
    }
    private function parse(string $template, array $data): array|string|null
    {
        for($i=0;$i<count($this->matches[0]);$i++){
            $pattern = "#". $this->matches[0][$i].'#';
            $template = preg_replace($pattern,$data[trim($this->matches[1][$i])],$template);
        }
        return $template;
    }
    private function getMatches(string $template) : void {
        preg_match_all($this->regex,$this->templates[$template], $this ->matches);
    }
}
