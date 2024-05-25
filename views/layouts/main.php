<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\BootstrapAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

use function PHPUnit\Framework\isNull;
$this->title = 'PicBox';
$this->registerCssFile('css/pic.css', ['depends' => [BootstrapAsset::class]]);
AppAsset::register($this);
$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.png')]);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header id="header">
        <?php
        NavBar::begin([
            'brandLabel' => Html::img('@web/uploads/Vector.svg'),
            'brandUrl' => Yii::$app->homeUrl,
            'options' => ['class' => 'navbar-expand-md header-top']
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav align-items-center ms-auto'],
            'items' => [
                Yii::$app->user->isGuest
                ?
                ['label' => 'Регистрация', 'url' => ['/site/reg'], 'options' => ['class' => 'button-submain']]
                :
                ['label' => Yii::$app->user->identity->login, 'url' => ['/cabinet/index'], 'options' => ['class' => 'button-submain']],
                '<li class="vr"></li>',
                Yii::$app->user->isGuest
                ?
                ['label' => 'Вход', 'url' => ['/site/login'], 'options' => ['class' => 'button-main']]
                :
                Html::img('@web/uploads/' . !isNull(Yii::$app->user->identity->img_url) ? '../web/uploads/' . Yii::$app->user->identity->img_url : '', ['class' => 'avatar']) .
                Html::beginForm(['/site/logout'])
                . Html::submitButton(
                    'Выход',
                    ['class' => 'button-submain']
                )
                . Html::endForm()

            ]
        ]);
        NavBar::end();
        ?>
    </header>

    <main id="main" class="flex-shrink-0" role="main">
        <div class="container">
            <?php if (!empty($this->params['breadcrumbs'])): ?>
                <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
            <?php endif ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>



    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>
<!-- Html::beginForm(['/site/logout'])
                    . Html::submitButton(
                        'Logout (' . Yii::$app->user->identity->login . ')',
                        ['class' => 'nav-link btn btn-link logout']
                    )
                    . Html::endForm() -->