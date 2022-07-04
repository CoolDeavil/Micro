
<?php
use API\Core\Render\PHPRender;
/**@var $renderer PHPRender */
/**@var $params array */
?>

<?= $renderer->render('layout/header')  ?>
<div class="sectionSeparator"></div>
<div class="title">Error404 <small>You request was not found</small></div>
<hr>
Failed URL: <strong><?= $params['ip']  ?></strong>
<hr>
<?= $renderer->render('layout/footer')  ?>
