<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Url;
use common\models\Permission;

AppAsset::register($this);
// Fetch permissions for logged-in user
$permissions = [];
if (!Yii::$app->user->isGuest) {
    $roleId = Yii::$app->user->identity->role_id;
    $permissions = Permission::find()
        ->alias('p')
        ->select(['p.id', 'p.name', 'p.parent_id', 'p.route'])
        ->innerJoin('role_permissions rp', 'rp.permission_id = p.id')
        ->where(['rp.role_id' => $roleId, 'p.status' => 10])
        ->andWhere(['or',
            ['like', 'LOWER(p.name)', 'create'],
            ['like', 'LOWER(p.name)', 'list'],
            ['like', 'LOWER(p.name)', 'management']
        ])
        ->orderBy(['p.parent_id' => SORT_ASC, 'p.id' => SORT_ASC])
        ->asArray()
        ->all();
}

// Organize permissions by parent-child
$menu = [];
foreach ($permissions as $perm) {
    if ($perm['parent_id'] === null) {
        $menu[$perm['id']] = ['label' => $perm['name'], 'children' => []];
    } else {
        $menu[$perm['parent_id']]['children'][] = $perm;
    }
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
        ],
    ]);
    // $menuItems = [
    //     ['label' => 'Home', 'url' => ['/site/index']],
    //     ['label' => 'About', 'url' => ['/site/about']],
    //     ['label' => 'Contact', 'url' => ['/site/contact']],
    // ];
    // if (Yii::$app->user->isGuest) {
    //     $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
    // }

    // echo Nav::widget([
    //     'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
    //     'items' => $menuItems,
    // ]);
    if (!Yii::$app->user->isGuest) {
        echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout text-decoration-none']
            )
            . Html::endForm();        
        //echo Html::tag('div',Html::a('Login',['/site/login'],['class' => ['btn btn-link login text-decoration-none']]),['class' => ['d-flex']]);
    }
    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container">

        <div class="site-index">

            <div class="row">
                <?php     if (!Yii::$app->user->isGuest) { ?>
                <!-- Sidebar -->
                <div class="col-lg-3 sidebar navbar-dark bg-dark" style="max-height: 90vh; overflow-y: auto; border-right:1px solid #ddd;">
                    <h4></h4>
                    <ul class="list-unstyled">
                        <!-- My Profile menu item -->
                            <li>
                                <p class="white-font"><strong>My Profile</strong></p>
                                <ul>
                                    <li>
                                        <a href="<?= Url::to(['/user/view', 'id' => Yii::$app->user->id]) ?>" class="sidebar-link">View Profile</a>
                                    </li>
                                    <li>
                                        <a href="<?= Url::to(['/user/update', 'id' => Yii::$app->user->id]) ?>" class="sidebar-link">Edit Profile</a>
                                    </li>
                                </ul>
                            </li>
                        <?php foreach ($menu as $parent): ?>
                            <li>
                                <p class="white-font"><strong><?= Html::encode($parent['label']) ?></strong></p>
                                <?php if (!empty($parent['children'])): ?>
                                    <ul>
                                        <?php foreach ($parent['children'] as $child): ?>
                                            <li>
                                                <a href="<?= Url::to([$child['route']]) ?>" class="sidebar-link"><?= Html::encode($child['name']) ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php } ?>
                </div>
                <!-- Sidebar end -->

                <!-- Main Content -->
                <div class="col-lg-9 content">
                    <?= Alert::widget() ?>
                    <?= Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]) ?>
                    <div class="body-content" id="main-content">
                        <!-- content section will be rendered here dynamically on click of side bar menu -->
                        <?= $content ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<footer class="footer mt-auto py-3 text-muted">
    <div class="container">
        <p class="float-start">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
        <p class="float-end"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
// Optional: Ajax to load CRUD pages inside body-content on click
$js = <<<JS
$('.sidebar-link').on('click', function(e){
    e.preventDefault();
    var url = $(this).attr('href');
    $('#main-content').load(url);
});
JS;
$this->registerJs($js);
?>
