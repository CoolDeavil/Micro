<?php
use API\Core\Render\PHPRender;
/**@var $renderer PHPRender */
/**@var $params array */
?>
<div class="card" style="width: 18rem;">
    <div class="card-body">
        <h5 class="card-title"><?=$params['cardTitle']?></h5>
        <p class="card-text">Some quick example text to build on {{ bolder(the card title and make up the)}} bulk of the card's content.</p>
    </div>
</div>

