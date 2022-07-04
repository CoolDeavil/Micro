<?php
/**@var $params array */
?>
<li class="nav-item dropdown <?=$params['active']?>">
    <a class="nav-link dropdown-toggle <?=$params['active']?>" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <?=$params['label']?>
    </a>
    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
        <?php
        foreach ($params['dropLinks'] as $link ){
            if(is_array($link)){
                echo "<li><a class='dropdown-item $link[active]' href='$link[route]'>$link[label]</a></li>";
            }else {
                echo '<li><hr class="dropdown-divider"></li>';
            }
        }
        ?>
    </ul>
</li>


