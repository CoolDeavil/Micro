<?php
/**@var $builder NavBuilder */

use API\Core\Container\MicroDI;
use API\Core\Utils\NavBuilder\NavBuilder;

$ioc = MicroDI::getInstance([]);
$builder = $ioc->get(NavBuilder::class);
$nav='<div class="appNavigation"></div>';
if(RENDER_NAV){$nav = $builder->render();}
?>
<?=$nav?>
