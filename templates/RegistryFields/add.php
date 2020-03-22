<?= $this->Html->script('MakvilleRegistry.jquery-1.12.4.js', ['block' => 'scriptBottom']); ?>
<?= $this->Html->script('MakvilleRegistry.jquery-ui.js', ['block' => 'scriptBottom']); ?>
<?= $this->Html->script('MakvilleRegistry.behaviors/fields', ['block' => 'scriptBottom']); ?>
<?= $this->Element('MakvilleControlPanel.pages/page-title', ['heading' => 'New registry field', 'subHeading' => 'create new field under ' . $registry->name]); ?>
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Create new field</h5>
                <hr />
                <?= $this->Form->create($registryField) ?>
                <fieldset>
                    <?php
                    echo $this->Form->control('registry_id', ['value' => $registry->id, 'type' => 'hidden']);
                    echo $this->Form->control('label', ['label' => 'Question', 'class' => 'form-control']);
                    echo $this->Form->control('data_type', ['label' => 'Answer Type', 'options' => $answerTypes, 'class' => 'form-control']);
                    ?>
                    <div id="list-options" style="display: none;">
                        <?= $this->Form->control('source', ['label' => 'How do you want to specify the choices for this question', 'options' => ['typed' => 'Let me type in a list of choices', 'existing' => 'Load from an existing list', 'new' => 'Create a new list. I will populate the list later'], 'empty' => true, 'class' => 'form-control']) ?>
                        <div id="typed" style="display: none;">
                            <?= $this->Form->control('options', ['type' => 'textarea', 'placeholder' => 'Type a set of choices. Each choice on a new line', 'class' => 'form-control']); ?>
                        </div>
                        <div id="existing" style="display: none;">
                            <?= $this->Form->control('lists', ['options' => $lists, 'empty' => true, 'label' => 'Select a list to load choices from', 'class' => 'form-control']); ?>
                        </div>
                        <div id="new" style="display: none;">
                            <?= $this->Form->control('list_name', ['label' => 'Create a new list', 'placeholder' => 'Enter your new list\'s name.', 'class' => 'form-control']); ?>
                        </div>
                    </div>
                    <div id="linear-options" style="display: none;">
                        <?= $this->Form->control('linear_start', ['label' => 'From', 'empty' => true, 'options' => ['0' => '0', '1' => '1'], 'class' => 'form-control']); ?>
                        <?= $this->Form->control('linear_stop', ['label' => 'To', 'empty' => true, 'options' => ['2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10'], 'class' => 'form-control']); ?>
                        <?= $this->Form->control('linear_start_label', ['label' => 'Label for minimum value', 'class' => 'form-control']); ?>
                        <?= $this->Form->control('linear_stop_label', ['label' => 'Label for Maximium value', 'class' => 'form-control']); ?>
                    </div>
                    <div id="grid-options" style="display: none;">

                    </div>
                </fieldset>
                <p>&nbsp;</p>
                <?= $this->Form->button(__('Create field'), ['class' => 'btn btn-success pull-right']) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>