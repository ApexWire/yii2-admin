<?php
/* @var $this \yii\web\View */
/* @var $content string */

/** @type yii\web\Controller $controller */
$controller = $this->context;
/** @type mdm\admin\Module $module */
$module = $controller->module;
$menus = $module->menus;
$route = $controller->route;
foreach ($menus as $i => $menu) {
    $menus[$i]['active'] = strpos($route, trim($menu['url'][0], '/')) === 0;
}
$this->params['nav-items'] = $menus;
$this->params['top-menu'] = true;
?>
<?php $this->beginContent($module->mainLayout) ?>
<div class="row">
    <div class="col-sm-12">
        <?= $content ?>
    </div>
</div>
<?php $this->endContent(); ?>
