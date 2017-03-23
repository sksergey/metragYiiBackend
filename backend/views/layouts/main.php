<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::t('yii', 'Metrag'),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => Yii::t('yii', 'Login'), 'url' => ['/site/login']];
    } else {
        $menuItems = [
        ['label' => Yii::t('yii', 'Home'), 'url' => ['/site/index']],
        [
            'label' => 'Квартиры',
            'items' => [
                ['label' => Yii::t('yii', 'Apartment Search'), 'url' => ['/apartment/search']],
                ['label' => Yii::t('yii', 'Create Apartment'), 'url' => ['/apartment/create']],
            ]
        ],
        
        [
            'label' => Yii::t('yii', 'Edit'),
            'items' => [
                ['label' => Yii::t('yii', 'Condit'), 'url' => ['/condit']],
                ['label' => Yii::t('yii', 'Cource'), 'url' => ['/course']],
                ['label' => Yii::t('yii', 'Layout'), 'url' => ['/layout']],
                ['label' => Yii::t('yii', 'Locality'), 'url' => ['/locality']],
                ['label' => Yii::t('yii', 'Mediator'), 'url' => ['/mediator']],
                ['label' => Yii::t('yii', 'Metro'), 'url' => ['/metro']],
                ['label' => Yii::t('yii', 'Region'), 'url' => ['/region']],
                ['label' => Yii::t('yii', 'Region Kharkiv'), 'url' => ['/region-kharkiv']],
                ['label' => Yii::t('yii', 'Region Kharkiv Admin'), 'url' => ['/region-kharkiv-admin']],
                ['label' => Yii::t('yii', 'Source Info'), 'url' => ['/source-info']],
                ['label' => Yii::t('yii', 'Street'), 'url' => ['/street']],
                ['label' => Yii::t('yii', 'Type Object'), 'url' => ['/type-object']],
                ['label' => Yii::t('yii', 'Wall Material'), 'url' => ['/wall-material']],
                ['label' => Yii::t('yii', 'Wc'), 'url' => ['/wc']],
                
            ]
        ],
        [
            'label' => Yii::t('yii', 'Administration'),
            'items' => [
                 ['label' => Yii::t('yii', 'Create user'), 'url' => ['/admin/user/create-user']],
                 '<li class="divider"></li>',
                 '<li class="dropdown-header">Options</li>',
                 ['label' => Yii::t('yii', 'Routes'), 'url' => ['/admin/route']],
                 ['label' => Yii::t('yii', 'Permissions'), 'url' => ['/admin/permission']],
                 ['label' => Yii::t('yii', 'Roles'), 'url' => ['/admin/role']],
                 '<li class="divider"></li>',
                 ['label' => Yii::t('yii', 'Users'), 'url' => ['/admin/user']],
        ],
        ],
        [
            'label' => Yii::t('yii', 'Parser'),
            'items' => [
                 ['label' => Yii::t('yii', 'OLX apartments'), 'url' => ['/olxparser']],
                 
            ],
        ],
        ];

        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                \Yii::t('yii', 'Logout') .'(' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
        

    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container-fluid" style="margin-top: 60px; ">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Yii::t('yii', 'Metrag')?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
