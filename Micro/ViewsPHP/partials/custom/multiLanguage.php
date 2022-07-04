<?php
/**@var $params array */

$lang = $params['aLang'];
$isActive = function(string $l) use($lang){
    return $lang === $l;
}
?>
<li>
    <div class="dropdown">
        <a class="lnk dropBtn"><span class="drop_language <?=$lang?>"></span></a>
        <div class="dropdown-content" style="right:0;">
            <a class="dropLnk <?=$isActive('pt')?'active':''?>" href="">
                <div class="language pt"> Portuguese </div>
            </a>
            <a class="dropLnk <?=$isActive('en')?'active':''?>" href="">
                <div class="language en"> English</div>
            </a>
            <a class="dropLnk <?=$isActive('fr')?'active':''?>" href="">
                <div class="language fr"> French</div>
            </a>
        </div>
    </div>
</li>
