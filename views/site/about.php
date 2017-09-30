<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
</div>
<div class="col-lg-6">
    <div class="input-group">
        <form action="<?=\yii\helpers\Url::to(['site/search'])?>" method="get" role="search">
            <input id="search-field" name="q" class="form-control" placeholder="Search for...">
        </form>
    </div><!-- /input-group -->
</div><!-- /.col-lg-6 -->