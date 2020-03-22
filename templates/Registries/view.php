<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Registry'), ['action' => 'edit', $registry->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Registry'), ['action' => 'delete', $registry->id], ['confirm' => __('Are you sure you want to delete # {0}?', $registry->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Registries'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Registry'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Registry Fields'), ['controller' => 'RegistryFields', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Registry Field'), ['controller' => 'RegistryFields', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="registries view large-9 medium-8 columns content">
    <h3><?= h($registry->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($registry->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Description') ?></th>
            <td><?= h($registry->description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($registry->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($registry->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($registry->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Registry Fields') ?></h4>
        <?php if (!empty($registry->registry_fields)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Registry Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Label') ?></th>
                <th scope="col"><?= __('Tip') ?></th>
                <th scope="col"><?= __('Data Type') ?></th>
                <th scope="col"><?= __('Control Type') ?></th>
                <th scope="col"><?= __('Options') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($registry->registry_fields as $registryFields): ?>
            <tr>
                <td><?= h($registryFields->id) ?></td>
                <td><?= h($registryFields->registry_id) ?></td>
                <td><?= h($registryFields->name) ?></td>
                <td><?= h($registryFields->label) ?></td>
                <td><?= h($registryFields->tip) ?></td>
                <td><?= h($registryFields->data_type) ?></td>
                <td><?= h($registryFields->control_type) ?></td>
                <td><?= h($registryFields->options) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'RegistryFields', 'action' => 'view', $registryFields->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'RegistryFields', 'action' => 'edit', $registryFields->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'RegistryFields', 'action' => 'delete', $registryFields->id], ['confirm' => __('Are you sure you want to delete # {0}?', $registryFields->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
