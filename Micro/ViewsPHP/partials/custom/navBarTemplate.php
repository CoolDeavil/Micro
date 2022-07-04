<?php
/**@var $params array */
?>
<div class="appNavigation">
    <ul class="menu">
        <li class="disabled_">
            <a class="">
               <span class="navLogo"></span>
            </a>
        </li>
    </ul>
    <ul class="menu">
        <?=$params['navLinks']?>
    </ul>
    <ul class="menu admin">
        <?=$params['multi_language']?>
        <?=$params['authLinks']?>
    </ul>
    <ul class="menu responsive">
        <li>
            <a class="lnk">
                <span class="js_hamburger" style="font-size: 1.4rem">☰</span>
            </a>
        </li>
    </ul>
</div>


