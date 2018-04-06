<?php
/**
 * Project: yii2-blog for internal using
 * Author: akiraz2
 * Copyright (c) 2018.
 */

use akiraz2\blog\models\BlogPost;
use akiraz2\blog\traits\IActiveStatus;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use akiraz2\blog\Module;
use akiraz2\blog\models\Status;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\blog\models\BlogPostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('blog', 'Blog Posts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-post-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Module::t('blog', 'Create ') . Module::t('blog', 'Blog Post'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],

            [
                'attribute'=>'category_id',
                'value'=>function ($model) {
                        return $model->category->title;
                    },
                'filter' => Html::activeDropDownList(
                        $searchModel,
                        'category_id',
                        BlogPost::getArrayCategory(),
                        ['class' => 'form-control', 'prompt' => Module::t('blog', 'Please Filter')]
                    )
            ],
            'title',
            // 'content:ntext',
            // 'tags',
            // 'slug',
            // 'click',
            // 'user_id',
            'commentsCount',
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($model) {
                        if ($model->status === IActiveStatus::STATUS_ACTIVE) {
                            $class = 'label-success';
                        } elseif ($model->status === IActiveStatus::STATUS_INACTIVE) {
                            $class = 'label-warning';
                        } else {
                            $class = 'label-danger';
                        }

                        return '<span class="label ' . $class . '">' . $model->getStatus() . '</span>';
                    },
                'filter' => Html::activeDropDownList(
                        $searchModel,
                        'status',
                        BlogPost::getStatusList(),
                        ['class' => 'form-control', 'prompt' => Module::t('blog', 'PROMPT_STATUS')]
                    )
            ],
            'created_at:date',
            // 'update_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
