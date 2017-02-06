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
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
        [
            'label' => 'Квартиры',
            'items' => [
                ['label' => 'Поиск квартир', 'url' => ['/apartment/search']],
                ['label' => 'Добавить квартиру', 'url' => ['/apartment/update']],
            ]
        ],
        
        [
            'label' => 'Edit',
            'items' => [
                ['label' => 'Condit', 'url' => ['/condit']],
                ['label' => 'Cource', 'url' => ['/cource']],
                ['label' => 'Layout', 'url' => ['/layout']],
                ['label' => 'Locality', 'url' => ['/locality']],
                ['label' => 'Mediator', 'url' => ['/mediator']],
                ['label' => 'Metro', 'url' => ['/metro']],
                ['label' => 'Region', 'url' => ['/region']],
                ['label' => 'Region Kharkiv', 'url' => ['/region-kharkiv']],
                ['label' => 'Region Kharkiv Admin', 'url' => ['/region-kharkiv-admin']],
                ['label' => 'Source Info', 'url' => ['/source-info']],
                ['label' => 'Street', 'url' => ['/street']],
                ['label' => 'Type Object', 'url' => ['/type-object']],
                ['label' => 'Wall Material', 'url' => ['/wall-material']],
                ['label' => 'Wc', 'url' => ['/wc']],
                
            ]
        ],
        [
            'label' => 'Admin',
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
        ];

        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
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

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
