<?php
use API\Core\Render\PHPRender;
/**@var $renderer PHPRender */
/**@var $params array */
?>

<?= $renderer->render('layout/header')  ?>
<div class="sectionSeparator"></div>
<div class="title">Site Root<small><strong><?=$params['appName']?></strong><span style="color: crimson;font-weight: bolder">PHP</span> SandBox </small></div>
<hr style="border-bottom: solid 1px orangered">
<div class="row">
    <div class="col-4">
        <h4>Lorem</h4>
        <p>{{ trans(TRANSLATE) }}</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad {{ bolder(aliquid amet consequuntur delectus dolor) }} doloribus, enim magnam magni nihil nulla, numquam porro praesentium quis quo, ullam. Atque dicta quaerat sunt.</p>
    </div>
    <div class="col-4">
        <?= $renderer->template('template',['cardTitle' => 'Templated'])  ?>
        <br>
        <img src="{{ asset(images/mvc_small.jpg) }}" alt="" class="img-fluid">
    </div>
    <div class="col-4">
                <h4>Lorem</h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad aliquid amet consequuntur delectus dolor doloribus, enim magnam magni nihil nulla, numquam porro praesentium quis quo, ullam. Atque dicta quaerat sunt.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad aliquid amet consequuntur delectus dolor doloribus, enim magnam magni nihil nulla,{{ bolder( numquam porro praesentium quis) }} quo, ullam. Atque dicta quaerat sunt.</p>

    </div>
</div>
<div class="sectionSeparator"></div>
<?= $renderer->render('layout/footer')  ?>
