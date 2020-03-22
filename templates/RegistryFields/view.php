<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Registry Field'), ['action' => 'edit', $registryField->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Registry Field'), ['action' => 'delete', $registryField->id], ['confirm' => __('Are you sure you want to delete # {0}?', $registryField->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Registry Fields'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Registry Field'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Registries'), ['controller' => 'Registries', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Registry'), ['controller' => 'Registries', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Registry Field Extras'), ['controller' => 'RegistryFieldExtras', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Registry Field Extra'), ['controller' => 'RegistryFieldExtras', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="registryFields view large-9 medium-8 columns content">
    <h3><?= h($registryField->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Registry') ?></th>
            <td><?= $registryField->has('registry') ? $this->Html->link($registryField->registry->name, ['controller' => 'Registries', 'action' => 'view', $registryField->registry->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($registryField->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Label') ?></th>
            <td><?= h($registryField->label) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tip') ?></th>
            <td><?= h($registryField->tip) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Data Type') ?></th>
            <td><?= h($registryField->data_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Control Type') ?></th>
            <td><?= h($registryField->control_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Options') ?></th>
            <td><?= h($registryField->options) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($registryField->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Registry Field Extras') ?></h4>
        <?php if (!empty($registryField->registry_field_extras)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Registry Field Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($registryField->registry_field_extras as $registryFieldExtras): ?>
            <tr>
                <td><?= h($registryFieldExtras->id) ?></td>
                <td><?= h($registryFieldExtras->registry_field_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'RegistryFieldExtras', 'action' => 'view', $registryFieldExtras->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'RegistryFieldExtras', 'action' => 'edit', $registryFieldExtras->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'RegistryFieldExtras', 'action' => 'delete', $registryFieldExtras->id], ['confirm' => __('Are you sure you want to delete # {0}?', $registryFieldExtras->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
