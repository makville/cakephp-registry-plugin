<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Registry Field Extra'), ['action' => 'edit', $registryFieldExtra->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Registry Field Extra'), ['action' => 'delete', $registryFieldExtra->id], ['confirm' => __('Are you sure you want to delete # {0}?', $registryFieldExtra->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Registry Field Extras'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Registry Field Extra'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Registry Fields'), ['controller' => 'RegistryFields', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Registry Field'), ['controller' => 'RegistryFields', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="registryFieldExtras view large-9 medium-8 columns content">
    <h3><?= h($registryFieldExtra->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Registry Field') ?></th>
            <td><?= $registryFieldExtra->has('registry_field') ? $this->Html->link($registryFieldExtra->registry_field->name, ['controller' => 'RegistryFields', 'action' => 'view', $registryFieldExtra->registry_field->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($registryFieldExtra->id) ?></td>
        </tr>
    </table>
</div>
