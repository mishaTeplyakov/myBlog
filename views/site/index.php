<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>

<!--main content start-->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <?php foreach ($models as $model):?>
                    <article class="post">
                        <div class="post-thumb">
                            <a href="<?=Url::toRoute(['site/view','id'=>$article->id]);?>"><img src="<?=$model->getImage();?>" alt=""></a>

                            <a href="<?=Url::toRoute(['site/view','id'=>$article->id]);?>" class="post-thumb-overlay text-center">
                                <div class="text-uppercase text-center">Просмотреть пост</div>
                            </a>
                        </div>
                        <div class="post-content">
                            <header class="entry-header text-center text-uppercase">
                                <h6><a href="<?=Url::toRoute(['site/category', 'id'=>$article->category->id])?>"><?=$model->category->title;?></a></h6>

                                <h1 class="entry-title"><a href="<?=Url::toRoute(['site/view','id'=>$article->id]);?>"><?=$model->title?></a></h1>

                            </header>
                            <div class="entry-content">
                                <p><?=$model->description?> </p>

                                <div class="btn-continue-reading text-center text-uppercase">
                                    <a href="<?=Url::toRoute(['site/view','id'=>$article->id]);?>" class="more-link">Продолжить читать...</a>
                                </div>
                            </div>
                            <div class="social-share">
                                <span class="social-share-title pull-left text-capitalize">От <a href="#"><?=$article->author->name?></a> в <?=$model->getDate();?></span>
                                <ul class="text-center pull-right">
                                    <li><a class="s-facebook" href="#"><i class="fa fa-eye"></i></a></li><?= (int) $model->viewed?>
                                </ul>
                            </div>
                        </div>
                    </article>
                <?php endforeach;?>
                <?php
                echo LinkPager::widget([
                    'pagination' => $pages,
                ]);
                ?>
            </div>
            <div class="col-md-4" data-sticky_column>
                <div class="primary-sidebar">

                    <aside class="widget">
                        <h3 class="widget-title text-uppercase text-center">Популярные посты</h3>
                        <?php foreach ($popular as $article):?>
                            <div class="popular-post">


                            <a href="#" class="popular-img"><img src="<?=$article->getImage();?>" alt="">

                                <div class="p-overlay"></div>
                            </a>

                            <div class="p-content">
                                <a href="#" class="text-uppercase"><?=$article->title?></a>
                                <span class="p-date"><?=$article->getDate(); ?></span>
                            </div>
                        </div>
                        <?php endforeach;?>
                    </aside>
                    <aside class="widget pos-padding">
                        <h3 class="widget-title text-uppercase text-center">Новые посты</h3>
                        <?php foreach ($recent as $item)?>
                        <div class="thumb-latest-posts">
                            <div class="media">
                                <div class="media-left">
                                    <a href="#" class="popular-img"><img src="<?=$item->getImage();?>" alt="">
                                        <div class="p-overlay"></div>
                                    </a>
                                </div>
                                <div class="p-content">
                                    <a href="#" class="text-uppercase"><?=$item->title?></a>
                                    <span class="p-date"><?=$item->getDate();?></span>
                                </div>
                            </div>
                        </div>

                    </aside>
                    <aside class="widget border pos-padding">
                        <h3 class="widget-title text-uppercase text-center">Категории</h3>
                        <ul>
                            <?php foreach ($category as $categor):?>
                            <li>
                                <a href="<?=Url::toRoute("site/category")?>""><?=$categor->title?></a>
                                <span class="post-count pull-right"> (<?= $categor->getArticles()->count(); ?>)</span>
                            </li>
                            <?php endforeach;?>
                        </ul>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end main content-->