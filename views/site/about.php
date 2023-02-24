<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Uploaded Files';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= Html::beginForm(['site/about'], 'post', ['enctype' => 'multipart/form-data']) ?>
    <?= Html::checkbox('orderByDate', false, ['label' => 'Сортировать по дате']) ?>
    <?= Html::submitButton('Отсортировать', ['class' => 'submit']) ?>
    <?= Html::endForm() ?>
    По умолчанию сортировка выполняется по имени файлов. Если выставлена галочка 'Сортировать по дате' то сортировка будет выполнена соответственно по дате.
    <p>
        Uploaded file list:
    </p>
    <?php
    foreach ($uploadedFiles as $uploadedFile)
    {
        echo "<ul><li><a href=\"uploads\\".$uploadedFile->name."\" target=\"_blank\">" . $uploadedFile->name . "</a>
        <img src=minified/". $uploadedFile->name . " alt=\"image\"> # "
            . $uploadedFile->date_time . '</li></ul>';
    }
    ?>

<!--    <code>--><?//= __FILE__ ?><!--</code>-->
</div>
