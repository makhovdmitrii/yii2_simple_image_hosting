<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Uploaded Files';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Uploaded file list:
    </p>
    <?php
    foreach ($uploaded_files as $uploaded_file)
    {
        echo "<ul><li>". $uploaded_file->name . " # " . $uploaded_file->date_time . '</li></ul>';
    }
    ?>

<!--    <code>--><?//= __FILE__ ?><!--</code>-->
</div>
