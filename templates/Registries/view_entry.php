<?php
echo $this->Html->css('MakvilleRegistry.plugins/jquery.multicheckbox');
echo $this->Html->css('MakvilleRegistry.plugins/bootstrap-slider');
echo $this->Html->script('MakvilleRegistry.plugins/jquery.multicheckbox', ['block' => 'scriptBottom']);
echo $this->Html->script('MakvilleRegistry.plugins/bootstrap-slider', ['block' => 'scriptBottom']);
echo $this->Html->script('MakvilleRegistry.behaviours/form.controls', ['block' => 'scriptBottom']);
?>
<?= $this->Element('MakvilleControlPanel.pages/page-title', ['heading' => 'View registry entry', 'subHeading' => '']); ?>
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">View entry</h5>
                <hr />
                <div class="table-responsive">
                    <table class="mb-0 table">
                        <tr>
                            <td><b>User Id: </b></td>
                            <td><?= $this->Identity->get('email'); ?></td>
                        </tr>
                        <?php foreach ($registry->registry_fields as $field): ?>
                            <tr>
                                <td><b><?= $field->label; ?>: </b></td>
                                <td><?= $this->Output->output($field, $lists, $data[$field->name]); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>