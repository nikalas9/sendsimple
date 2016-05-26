<?php

namespace core\components;

use core\components\gridBulkActions\GridBulkActions;

class GridView extends \yii\grid\GridView
{
    // public $summary = 'Отображаются <span class="txt-color-darken">{begin}</span> - <span class="txt-color-darken">{end}</span> из <span class="text-primary">{count}</span> записей';
    public $summary = 'Showing <span class="txt-color-darken">{begin}</span> - <span class="txt-color-darken">{end}</span> of <span class="text-primary">{totalCount}</span> item';

    /*public $layout = '{items}
<div class="row">
    <div class="col-sm-6 col-xs-12 hidden-xs">
        <div class="dataTables_info">{summary}</div>
        <div class="dataTables_paginate paging_simple_numbers">{pager}</div>
    </div>
    <div class="col-sm-6 col-xs-12">
    </div>
    </div>';*/

    public $tableOptions = ['class' => 'table table-striped table-bordered table-hover'];


    public function init()
    {
        parent::init();

        if( $this->layout == "{summary}\n{items}\n{pager}" )
        {
            $this->layout = '{items}
<div class="row">
    <div class="col-sm-6">
        <div class="dataTables_info">{summary}</div>
        <div class="dataTables_paginate paging_simple_numbers">{pager}</div>
    </div>
    <div class="col-sm-6">
        <div class="pull-right" style="margin-top: 10px;">'.GridBulkActions::widget().'</div>
    </div>
    </div>';
        }
    }
}