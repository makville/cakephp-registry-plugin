<?php

echo $this->Html->css('plugins/jquery.sheet');
echo $this->Html->css('plugins/jquery-ui.theme.min');
echo $this->Html->script('plugins/jquery.sheet', ['block' => 'scriptBottom']);
echo $this->Html->script('plugins/parser', ['block' => 'scriptBottom']);
echo $this->Html->script('plugins/jquery-ui.min', ['block' => 'scriptBottom']);
echo $this->Html->script('plugins/jquery.elastic.min', ['block' => 'scriptBottom']);
echo $this->Html->script('plugins/jquery.scrollTo-min', ['block' => 'scriptBottom']);
echo $this->Html->script('plugins/jquery.scrollTo-min', ['block' => 'scriptBottom']);
echo $this->Html->script('behaviours/sheet', ['block' => 'scriptBottom']);
?>
<style>
    .jSheetUI table tr th, .jSheetUI table tr td {
        padding: 0 !important;
    }
</style>
<div class="row" style="margin-top:-20px">

    <div class="large-12 columns">
        <div class="box">
            <div class="box-header bg-transparent">
                <!-- tools box -->
                <div class="pull-right box-tools">

                    <span class="box-btn" data-widget="collapse"><i class="icon-minus"></i>
                    </span>
                    <span class="box-btn" data-widget="remove"><i class="icon-cross"></i>
                    </span>
                </div>
                <h3 class="box-title"><i class="fontello-th-large-outline"></i>
                    <span>DATA TABLE</span>
                </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body " style="display: block;">
                <div id="jqsheet1" class="jQuerySheet" style="height: 450px;">
                    <input type="hidden" id="registry" value="<?= $id;?>" />
                </div>
            </div>
        </div>
    </div>
</div>