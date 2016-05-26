<?php

namespace app\models;

use Yii;

class User extends \amnah\yii2\user\models\User
{


    public static function canRoute(){

        return true;
    }
}