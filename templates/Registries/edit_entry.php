<?php
echo $this->Html->script('MakvilleRegistry.jquery-1.12.4.js', ['block' => 'scriptBottom']);
echo $this->Html->script('MakvilleRegistry.jquery-ui.js', ['block' => 'scriptBottom']);
echo $this->Html->css('MakvilleRegistry.plugins/jquery.multicheckbox');
echo $this->Html->css('MakvilleRegistry.plugins/bootstrap-slider');
echo $this->Html->css('MakvilleRegistry.plugins/jquery.timepicki');
echo $this->Html->script('MakvilleRegistry.plugins/jquery.multicheckbox', ['block' => 'scriptBottom']);
echo $this->Html->script('MakvilleRegistry.plugins/bootstrap-slider', ['block' => 'scriptBottom']);
echo $this->Html->script('MakvilleRegistry.plugins/jquery.validate.min', ['block' => 'scriptBottom']);
echo $this->Html->script('MakvilleRegistry.plugins/jquery.numeric.min', ['block' => 'scriptBottom']);
echo $this->Html->script('MakvilleRegistry.plugins/jquery.timepicki', ['block' => 'scriptBottom']);
echo $this->Html->script('MakvilleRegistry.behaviors/form.controls', ['block' => 'scriptBottom']);
echo $this->Html->script('MakvilleRegistry.behaviors/entry', ['block' => 'scriptBottom']);
?>

<?= $this->Element('MakvilleControlPanel.pages/page-title', ['heading' => 'Edit entry', 'subHeading' => 'edit existing entry under registry ' . $registry->name]); ?>
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Edit entry</h5>
                <hr />
                <?php
                echo $this->Form->create(null);
                echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => $data['user_id']]);
                echo $this->Form->control('identity', ['class' => 'form-control', 'label' => 'User id', 'value' => $this->Identity->get('email'), 'disabled' => 'disabled']);
                echo $this->Form->control('id', ['value' => $data['id'], 'type' => 'hidden']);
                foreach ($registry->registry_fields as $field) {
                    echo $this->Input->input($field, $lists, $data[$field->name]);
                }
                ?>
                <p>&nbsp;</p>
                <?= $this->Form->button(__('Save entry'), ['class' => 'btn btn-success pull-right']) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
