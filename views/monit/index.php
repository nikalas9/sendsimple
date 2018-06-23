<?php

use yii\helpers\Url;
use core\components\GridView;
use core\components\Pjax;
use core\components\gridPageSize\GridPageSize;
use core\helpers\Html;

//use webvimark\modules\UserManagement\models\User;
use app\models\User;

$this->title = 'Monit';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
    <div class="col-sm-12">

        <h2 class="lte-hide-title"><?= Html::encode($this->title) ?></h2>

        <div class="panel panel-default">
            <div class="panel-body">
                <h3>Pre-Contact Process</h3>
                <table class="table table-striped table-bordered detail-view">
                    <tr>
                        <th style="width: 160px;">Process Status</th>
                        <th style="width: 160px;">Process Start</th>
                        <th>Process Live</th>
                    </tr>
                    <tr>
                        <td><?php
                            $row = Yii::$app->redis->executeCommand("GET", ['pre-contact_status']);
                            if ($row == false) {
                                echo '<span class="label label-default">No Run</span>';
                            } else if ($row == 1) {
                                echo '<span class="label label-success">Active</span>';
                            } else  if ($row == 2) {
                                echo '<span class="label label-warning">Sleep</span>';
                            }
                            ?> </td>
                        <td><?php
                            $row = Yii::$app->redis->executeCommand("GET", ['pre-contact_start']);
                            if ($row) {
                                echo date('Y-m-d H:i:s', $row);
                            }
                            ?> </td>
                        <td><?php
                            $row = Yii::$app->redis->executeCommand("GET", ['pre-contact_live']);
                            if ($row) {
                                echo date('Y-m-d H:i:s', $row);
                            }
                            ?> </td>
                    </tr>
                </table>

                <h3>Mail-Send Process</h3>
                <table class="table table-striped table-bordered detail-view">
                    <tr>
                        <th style="width: 160px;">Process Status</th>
                        <th style="width: 160px;">Process Start</th>
                        <th style="width: 160px;">Process Live</th>
                        <th>MailerId</th>
                        <th>Stack</th>
                        <th>Counter</th>
                    </tr>
                    <tr>
                        <td><?php
                            $row = Yii::$app->redis->executeCommand("GET", ['mail-send_status']);
                            if ($row == false) {
                                echo '<span class="label label-default">No Run</span>';
                            } else if ($row == 1) {
                                echo '<span class="label label-success">Active</span>';
                            } else  if ($row == 2) {
                                echo '<span class="label label-warning">Sleep</span>';
                            } else  if ($row == 3) {
                                echo '<span class="label label-primary">Send</span>';
                            }
                            ?> </td>
                        <td><?php
                            $row = Yii::$app->redis->executeCommand("GET", ['mail-send_start']);
                            if ($row) {
                                echo date('Y-m-d H:i:s', $row);
                            }
                            ?> </td>
                        <td><?php
                            $row = Yii::$app->redis->executeCommand("GET", ['mail-send_live']);
                            if ($row) {
                                echo date('Y-m-d H:i:s', $row);
                            }
                            ?> </td>
                        <td><?php
                            $row = Yii::$app->redis->executeCommand("GET", ['mail-send_mailerId']);
                            if ($row) {
                                echo $row;
                            }
                            ?> </td>
                        <td><?php
                            $row = Yii::$app->redis->executeCommand("GET", ['mail-send_stack']);
                            if ($row) {
                                echo $row;
                            }
                            ?> </td>
                        <td><?php
                            $row = Yii::$app->redis->executeCommand("GET", ['mail-send_counter']);
                            if ($row) {
                                echo $row;
                            }
                            ?> </td>
                    </tr>
                </table>

                <h3>Mail-Bounce Process</h3>
                <table class="table table-striped table-bordered detail-view">
                    <tr>
                        <th style="width: 160px;">Process Status</th>
                        <th style="width: 160px;">Process Start</th>
                        <th>Process Live</th>
                    </tr>
                    <tr>
                        <td><?php
                            $row = Yii::$app->redis->executeCommand("GET", ['mail-bounce_status']);
                            if ($row == false) {
                                echo '<span class="label label-default">No Run</span>';
                            } else if ($row == 1) {
                                echo '<span class="label label-success">Active</span>';
                            } else  if ($row == 2) {
                                echo '<span class="label label-warning">Sleep</span>';
                            }
                            ?> </td>
                        <td><?php
                            $row = Yii::$app->redis->executeCommand("GET", ['mail-bounce_start']);
                            if ($row) {
                                echo date('Y-m-d H:i:s', $row);
                            }
                            ?> </td>
                        <td><?php
                            $row = Yii::$app->redis->executeCommand("GET", ['mail-bounce_live']);
                            if ($row) {
                                echo date('Y-m-d H:i:s', $row);
                            }
                            ?> </td>
                    </tr>
                </table>

            </div>
        </div>

    </div>
</div>