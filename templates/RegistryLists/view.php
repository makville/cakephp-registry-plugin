<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Registry List'), ['action' => 'edit', $registryList->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Registry List'), ['action' => 'delete', $registryList->id], ['confirm' => __('Are you sure you want to delete # {0}?', $registryList->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Registry Lists'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Registry List'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="registryLists view large-9 medium-8 columns content">
    <h3><?= h($registryList->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($registryList->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Description') ?></th>
            <td><?= h($registryList->description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($registryList->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($registryList->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($registryList->modified) ?></td>
        </tr>
    </table>
</div>
