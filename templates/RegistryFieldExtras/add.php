<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Registry Field Extras'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Registry Fields'), ['controller' => 'RegistryFields', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Registry Field'), ['controller' => 'RegistryFields', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="registryFieldExtras form large-9 medium-8 columns content">
    <?= $this->Form->create($registryFieldExtra) ?>
    <fieldset>
        <legend><?= __('Add Registry Field Extra') ?></legend>
        <?php
            echo $this->Form->input('registry_field_id', ['options' => $registryFields, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
