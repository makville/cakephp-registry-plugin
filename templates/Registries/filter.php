<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
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
                <?= $this->Form->create(null, []); ?>
                <?= $this->Form->input('registry_id', ['value' => $registry->id, 'type' => 'hidden']); ?>
                <?= $this->Form->input('filter_mode', ['options' => ['permissive' => 'Permissive', 'restrictive' => 'Restrictive']]); ?>
                <div><strong>Define filter parameters: </strong></div>
                <table>
                    <thead>
                        <tr>
                            <td>Question</td>
                            <td>Operator</td>
                            <td>Operand</td>
                        </tr>
                    </thead>
                <?php foreach ( $registry->registry_fields as $field) : ?>
                    <?php $id = $field->id;?>
                    <tr>
                        <td><?= $field->label;?><?= $this->Form->input("Parameters.$id.column", ['type' => 'hidden', 'value' => $field->name]); ?></td>
                        <td><?= $this->Filter->operators($field); ?></td>
                        <td><?= $this->Filter->operands($field, $lists); ?></td>
                    </tr>
                <?php endforeach;?>
                </table>
                <?= $this->Form->button(__('Apply Filter'), ['class' => 'tiny']); ?>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
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
                <?php if ( isset($data)):?>
                <table title="Spreadsheet 1">
                    <thead>
                        <tr>
                            <th></th>
                                <?php foreach ( $columns as $column ): ?>
                            <th scope="col"><?= $column->label; ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ( $data as $row ) : ?>
                        <tr>
                            <td><?= $this->Html->link('Edit', ['plugin' => 'registry', 'controller' => 'registries', 'action' => 'edit-entry', $registry->id, $row['id']]); ?> | Delete</td>
                            <?php foreach ($columns as $column ) : ?>
                            <td><?= $this->Output->output($column, $lists, $row[$column->name]); ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>