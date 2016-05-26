<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>

<!-- User info -->
<div class="login-info">
    <span> <!-- User image size is adjusted inside CSS, it should stay as it -->

        <a href="<?= Url::toRoute('/user/account');?>" id="show-shortcut">
            <img src="/app/img/avatars/sunny.png" alt="me" class="online" />
            <span>
                <?= Yii::$app->user->displayName;?>
            </span>
            <i class="fa fa-angle-down"></i>
        </a>
    </span>
</div>
<!-- end user info -->

<?php if($list):?>
<!-- NAVIGATION : This navigation is also responsive -->
<nav>
    <ul>
    <?php foreach($list as $one):?>

        <?php if(isset($one['visible']) and $one['visible']):?>

            <li <?php if(isset($one['active']) and $one['active']) echo 'class="active"';?> >
                <?= Html::a('<i class="fa fa-lg fa-fw '.$one['icon'].'"></i> <span class="menu-item-parent">'.$one['title'].'</span>',$one['link']);?>

                <?php if(isset($one['sub']) and $one['sub']):?>
                    <ul>
                    <?php foreach($one['sub'] as $two):?>

                        <?php if(isset($two['visible']) and $two['visible']):?>
                            <li <?php if($two['active']) echo 'class="active"';?> >
                                <?= Html::a($two['title'], $two['link']);?>

                                <?php if($two['sub']):?>
                                <ul>
                                    <?php foreach($two['sub'] as $three):?>

                                        <?php if($three['visible']):?>
                                            <li <?php if($three['active']) echo 'class="active"';?> >
                                                <?= Html::a($three['title'], $three['link']);?>
                                            </li>
                                        <?php endif;?>

                                    <?php endforeach;?>
                                </ul>
                                <?php endif;?>
                            </li>
                        <?php endif;?>
                    <?php endforeach;?>
                    </ul>
                <?php endif;?>
            </li>
        <?php endif;?>
    <?php endforeach;?>
    </ul>
</nav>
<?php endif;?>