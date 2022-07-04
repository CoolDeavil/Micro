<?php
return [
    'LINK' => '<li class="{{active }}">
    <a href="{{route}}" class="lnk">
        <span class="label">{{ label }}&thinsp;</span>
        <i class="fas {{icon}}"></i>
    </a>
    </li>',
    'DROP'=>'<li class="{{active}}">
    <div class="dropdown">
        <a class="lnk dropBtn">{{dropdownLabel}} <i class="fas fa-caret-down"></i></a>
        <div class="dropdown-content" style="left:0;">
        __LINKS__
        </div>
    </div>
</li>',
    'DROP_ITEM' => '<a class="dropLnk {{active}}" href="{{link}}"><i class="fas {{icon}}"></i>&nbsp;{{label}}</a>',
    'LANGUAGE' => '<li>
            <div class="dropdown">
                <a class="lnk dropBtn"><span class="drop_language {{active_language}}"></span></a>
                <div class="dropdown-content" style="right:0;">
                __LANGUAGES__
                </div>
            </div>
        </li>',
    'LANGUAGE_ITEM' => '<a class="dropLnk {{active}}" href="/">
 <div class="language {{language}}"> {{languageLabel}}</div>
  </a>',
    'ALINK' => '<li>
    <a href="{{ route }}" class="lnk">
        <img src="{{ avatar }}" class="nav_avatar" alt="">
    </a>
</li>
',
    'NAVBAR' => '<div class="appNavigation">
    <ul class="menu">
        <li class="disabled_">
            <a class="">
                <img src="./microUI_files/microLogo.jpg" class="navLogo" alt="">
            </a>
        </li>
    </ul>
    <ul class="menu">
    __NAV_LINKS__
    </ul>
    <ul class="menu admin">
    __MULTILINGUAL__
    __NAV_ADMIN_LINKS__
    </ul>
    <ul class="menu responsive">
        <li>
            <a class="lnk">
                <span class="js_hamburger" style="font-size: 1.4rem">☰</span>
            </a>
        </li>
    </ul>
</div>'
];