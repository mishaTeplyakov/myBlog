<?php
use yii\helpers\Url; ?>


<!--main content start-->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <article class="post">
                    <div class="post-thumb">
                        <a href="#"><img src="<?=$article->getImage();?>" alt=""></a>
                    </div>
                    <div class="post-content">
                        <header class="entry-header text-center text-uppercase">
                            <h6><a href="<?=Url::toRoute(['site/category', 'id'=>$article->category->id])?> "> <?=$article->category->title?></a></h6>

                            <h1 class="entry-title"><a href="<?=Url::toRoute(['site/view', 'id'=>$article->id])?>"><?=$article->title?></a></h1>


                        </header>
                        <div class="entry-content">
                            <?= $article->content?>
                        </div>

                        <div class="social-share">
							<span
                                class="social-share-title pull-left text-capitalize"><?=$article->author->name?> от <?=$article->getDate()?></span>
                            <ul class="text-center pull-right">
                                <li><a class="s-facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a class="s-twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a class="s-google-plus" href="#"><i class="fa fa-google-plus"></i></a></li>
                                <li><a class="s-linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>
                                <li><a class="s-instagram" href="#"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </article>


                <?php if(!empty($comments)):?>
                    <?php foreach ($comments as $comment):?>
                        <div class="bottom-comment"><!--bottom comment-->

                            <div class="comment-img">
                                <img class="img-circle" src="<?=$comment->user->image;?>" alt="">
                            </div>

                            <div class="comment-text">
                                <a href="#" class="replay btn pull-right"> Ответить</a>
                                <h5><?=$comment->user->name;?></h5>

                                <p class="comment-date">
                                    <?=$comment->getDate();?>
                                </p>


                                <p class="para"><?=$comment->text;?></p>
                            </div>
                        </div>
                    <?endforeach;?>
                <?php endif;?>


                <div class="leave-comment"><!--leave comment-->
                    <h4>Оставить комментарий</h4>
                    <?php $form =  \yii\widgets\ActiveForm::begin(
                            [
                                'action' => ['site/comment','id'=>$article->id],
                                'options' => ['class'=>'form-horizontal contact-form','role'=>'form']
                            ]
                    )?>
                        <div class="form-group">
                            <div class="col-md-12">
                        <?= $form->field($commentForm,'comment')
                            ->textarea([
                                'class'=>'form-control',
                                'placeholder'=>'Write Massage'
                            ])
                            ->label(false);

                        ;?>
                            </div>
                        </div>
                        <button class="btn send-btn">Отправить</button>
                    <?php \yii\widgets\ActiveForm::end();?>
                    </form>
                </div><!--end leave comment-->
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
                            <?php foreach ($category as $categor)?>
                            <li>
                                <a href="#"><?=$categor->title?></a>
                                <span class="post-count pull-right"> (<?= $categor->getArticles()->count(); ?>)</span>
                            </li>
                        </ul>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end main content-->