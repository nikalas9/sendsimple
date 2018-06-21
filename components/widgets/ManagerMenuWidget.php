<?php

namespace app\components\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Url;
//use webvimark\modules\UserManagement\models\User;

class ManagerMenuWidget extends Widget
{

    public function run()
    {
        $list = [];

        $list[] = [
            'title' => 'Dashboard',
            'link' => '/',
            'icon' => 'fa-home',
        ];
        $list[] = [
            'title' => 'Group',
            'link' => Url::to(['/group/index']),
            'icon' => 'fa-globe',
        ];
        $list[] = [
            'title' => 'Base',
            'link' => Url::to(['/base/index']),
            'icon' => 'fa-th-list',
        ];
        $list[] = [
            'title' => 'Clients',
            'link' => Url::to(['/clients/index']),
            'icon' => 'fa-users',
        ];
        $list[] = [
            'title' => 'Import',
            'link' => Url::to(['/import/index']),
            'icon' => 'fa-calendar',
        ];
        $list[] = [
            'title' => 'Mailer',
            'link' => Url::to(['/mailer/index']),
            'icon' => 'fa-cloud',
        ];
        $list[] = [
            'title' => 'Account',
            'link' => Url::to(['/account/index']),
            'icon' => 'fa-cloud',
        ];
        $list[] = [
            'title' => 'Lang',
            'link' => Url::to(['/lang/index']),
            'icon' => 'fa-cloud',
        ];
        $list[] = [
            'title' => 'Custom Fields ',
            'link' => Url::to(['/clients-param/index']),
            'icon' => 'fa-cloud',
        ];
        if(Yii::$app->user->can('admin')){
            $list[] = [
                'title' => 'Users',
                'link' => Url::to(['/user/admin']),
                'icon' => 'fa-cloud-download',
            ];
            $list[] = [
                'title' => 'Monit',
                'link' => Url::to(['/monit/index']),
                'icon' => 'fa-cloud',
            ];
            $list[] = [
                'title' => 'Logger',
                'link' => Url::to(['/logger/index']),
                'icon' => 'fa-cloud',
            ];
        }

        $route = explode('/',Yii::$app->requestedRoute);
        unset($route[count($route)-1]);
        $thisRoute = 'r='.implode('/',$route);

        foreach($list as $k1 => $one) {

            /*if(User::canRoute($one['link']) or $one['all']) {
                $list[$k1]['visible'] = 1;
            }

            if($one['sub']) {

                foreach($one['sub'] as $k2 => $two) {

                    if(User::canRoute($two['link']) or $two['all']) {
                        $list[$k1]['sub'][$k2]['visible'] = 1;
                    }

                    if($two['sub']) {

                        foreach($two['sub'] as $k3 => $three) {

                            if(User::canRoute($three['link']) or $three['all']) {
                                $list[$k1]['sub'][$k2]['sub'][$k3]['visible'] = 1;
                            }

                            if(Yii::$app->request->url == $three['link']) {
                                $list[$k1]['sub'][$k2]['sub'][$k3]['active'] = 1;
                                $list[$k1]['sub'][$k2]['active'] = 1;
                                $list[$k1]['active'] = 1;
                            }
                        }
                    }

                    if(Yii::$app->request->url == $two['link']) {
                        $list[$k1]['sub'][$k2]['active'] = 1;
                        $list[$k1]['active'] = 1;
                    }
                }
            }*/

            $list[$k1]['visible'] = 1;

            $url = parse_url($one['link']);
            if(isset($url['query'])){
                $requestedRoute = urldecode($url['query']);
                $route = explode('/',$requestedRoute);
                unset($route[count($route)-1]);
                $route = implode('/',$route);
            }
            else{
                $route = '';
            }
            if($route == $thisRoute) {
                $list[$k1]['active'] = 1;
            }
        }


        /*echo '<pre>';
        print_r($list);
        exit;*/

        return $this->render('managerMenu',compact('list'));
    }
}