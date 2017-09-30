
<!--main content start-->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <?php foreach ($articles as $article):?>
                <article class="post post-list">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="post-thumb">
                                <a href="<?=\yii\helpers\Url::toRoute(['site/view','id'=>$article->id])?>"><img src="<?=$article->getImage();?>" alt="" class="pull-left"></a>

                                <a href="<?=\yii\helpers\Url::toRoute(['site/view','id'=>$article->id])?>" class="post-thumb-overlay text-center">
                                    <div class="text-uppercase text-center">Просмотреть пост</div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="post-content">
                                <header class="entry-header text-uppercase">
                                    <h6><a href="<?=\yii\helpers\Url::toRoute(['site/view','id'=>$article->category->id])?>"> <?=$article->category->title?></a></h6>

                                    <h1 class="entry-title"><a href="<?=\yii\helpers\Url::toRoute(['site/view','id'=>$article->id])?>">Дом - спокойное место
                                        </a></h1>
                                </header>
                                <div class="entry-content">
                                    <p><?=$article->description?>
                                    </p>
                                </div>
                                <div class="social-share">
                                    <span class="social-share-title pull-left text-capitalize"><?=$article->author->name?> On <?=$article->getDate();?></span>

                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                <?php endforeach;?>
                <?php
                echo \yii\widgets\LinkPager::widget([
                    'pagination' => $pagination,
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
                                <a href="#"><?=$categor->title?></a>
                                <span class="post-count pull-right"> (<?= $categor->getArticles()->count(); ?>)</span>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end main content-->