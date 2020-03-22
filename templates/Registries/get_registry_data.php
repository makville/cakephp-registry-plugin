<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if ($auto == 'yes' || ($this->request->getData('button') == 'excel')) {
    $this->layout = false;
    $excel = new Spreadsheet();
    $excel->setActiveSheetIndex(0);
    $sheet = $excel->getActiveSheet();
    $col = 1;
    $row = 1;
    foreach ($columns as $id => $column) {
        $sheet->setCellValueByColumnAndRow($col, $row, $column->label);
        $col++;
    }
    foreach ($data as $line) {
        $col = 1;
        $row++;
        foreach ($columns as $id => $column) {
            $sheet->setCellValueByColumnAndRow($col, $row, $this->Output->output($column, $lists, $line[$column->name]));
            $col++;
        }
    }
    $writer = new Xlsx($excel);
    if ($auto == 'yes') {
        $writer->save('/home/brother/.backup/dump/africa_backup.xls');
    } else {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="registry_data.xls"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
    exit();
}
?>

<?= $this->Element('MakvilleControlPanel.pages/page-title', ['heading' => 'Registry entries', 'subHeading' => 'entries in registry ' . $registry->name, 'icon' => 'fa fa-list']); ?>
<?php if ($allowFilter) : ?>
<div id="accordion" class="accordion-wrapper mb-3">
    <?= $this->Form->create(null, []); ?>
    <div class="card">
        <div id="headingOne" class="card-header">
            <button type="button" data-toggle="collapse" data-target="#collapseOne1" aria-expanded="true" aria-controls="collapseOne" class="text-left m-0 p-0 btn btn-link btn-block">
                <h5 class="m-0 p-0">Filter options</h5>
            </button>
            <?= $this->Form->button('Download', ['escapeTitle' => true, 'name' => 'button', 'value' => 'excel', 'class' => 'btn btn-sm btn-success pull-right']); ?>
        </div>
        <div data-parent="#accordion" id="collapseOne1" aria-labelledby="headingOne" class="collapse" style="">
            <div class="card-body">
                <div class="card-block">
                    <div class="large-12 columns">
                        <div class="box collapsed-box">
                            <!-- /.box-header -->
                            <div class="box-body ">

                                <?= $this->Form->input('registry_id', ['value' => $registry->id, 'type' => 'hidden']); ?>
                                <?= $this->Form->control('filter_mode', ['options' => ['permissive' => 'Permissive', 'restrictive' => 'Restrictive'], 'empty' => true, 'class' => 'form-control']); ?>
                                <p>&nbsp;</p>
                                <div><strong>Define filter parameters: </strong></div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <td>Question</td>
                                                <td>Operator</td>
                                                <td>Operand</td>
                                            </tr>
                                        </thead>
                                        <?php foreach ($registry->registry_fields as $field) : ?>
                                            <?php $id = $field->id; ?>
                                            <tr>
                                                <td><?= $field->label; ?><?= $this->Form->input("Parameters.$id.column", ['type' => 'hidden', 'value' => $field->name]); ?></td>
                                                <td><?= $this->Filter->operators($field); ?></td>
                                                <td><?= $this->Filter->operands($field, $lists); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                </div>
                                <p>&nbsp;</p>
                                <?= $this->Form->button(__('Apply Filter'), ['name' => 'button', 'value' => 'filter', 'class' => 'btn btn-sm btn-success pull-right']); ?>
                                <p>&nbsp;</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= $this->Form->end(); ?>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <div class="card-title">
                    <span class="pull-left"><?= __('Registry entry') ?></span>
                    <span class="pull-right table-action">
                        <?= $this->Html->link('New entry', ['action' => 'new-entry', $registry->id], ['escape' => false, 'class' => 'btn btn-sm btn-info']); ?>
                    </span>
                </div>
                <div class="table-responsive">
                    <table class="mb-0 table">
                        <thead>
                            <tr>
                                <?php foreach ($columns as $id => $column): ?>
                                    <?php
                                    if ($id > 2) {
                                        break;
                                    }
                                    ?>
                                    <th scope="col"><?= $column->label; ?></th>
                                <?php endforeach; ?>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $row) : ?>
                                <tr>
                                    <?php foreach ($columns as $id => $column) : ?>
                                        <?php
                                        if ($id > 2) {
                                            break;
                                        }
                                        ?>
                                        <td><?= $this->Output->output($column, $lists, $row[$column->name]); ?></td>
                                    <?php endforeach; ?>
                                    <td>
                                        <?= $this->Html->link('View', ['plugin' => 'MakvilleRegistry', 'controller' => 'Registries', 'action' => 'view-entry', $registry->id, $row['id']], ['class' => 'btn btn-sm btn-info']); ?>
                                        <?php
                                        if ($row['created']->wasWithinLast('3 months') || $this->Identity->get('id') == $registry->owner) {
                                            echo $this->Html->link('Edit', ['plugin' => 'MakvilleRegistry', 'controller' => 'Registries', 'action' => 'edit-entry', $registry->id, $row['id']], ['class' => 'btn btn-sm btn-warning']);
                                            echo " ";
                                            echo $this->Form->postLink(__('Delete'), ['plugin' => 'MakvilleRegistry', 'controller' => 'Registries', 'action' => 'delete', $row['id']], ['class' => 'btn btn-sm btn-danger', 'confirm' => __('Are you sure you want to delete this entry')]);
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="paginator">
                    
                </div>
            </div>
        </div>
    </div>
</div>