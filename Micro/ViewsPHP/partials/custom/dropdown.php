<?php
/**@var $params array */
?>
<li class="<?=$params['active']?>">
    <div class="dropdown">
        <a class="lnk dropBtn "><?=$params['label']?> <i class="fas fa-caret-down"></i></a>
        <div class="dropdown-content" style="left:0;">
            <?php
            foreach ($params['dropLinks'] as $link ){
                if(is_array($link)){
                    echo "<a class='dropLnk $link[active]' href='$link[route]'><i class='fas $link[icon]'></i>&nbsp;$link[label]</a>";
                }else {
                    echo '<a class="dropLnk separator" href="">&#9473;&#9473;&#9473;&#9473;&#9473;&#9473;&#9473;&#9473;&#9473;&#9473;&#9473;</a>';
                }
            }
            ?>
        </div>
    </div>
</li>
