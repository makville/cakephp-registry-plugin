<?= $this->Element('MakvilleControlPanel.pages/page-title', ['heading' => 'Registries', 'subHeading' => 'list of all created registries', 'icon' => 'fa fa-list']); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <div class="card-title">
                    <span class="pull-left"><?= __('Registries') ?></span>
                </div>
                <div class="table-responsive">
                    <table class="mb-0 table">
                        <thead>
                            <tr>
                                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('description') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($registries as $registry): ?>
                                <tr>
                                    <td><?= h($registry->name) ?></td>
                                    <td><?= h($registry->description) ?></td>
                                    <td><?= h($registry->created->timeAgoInWords()) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('Fields'), ['controller' => 'RegistryFields', 'action' => 'index', $registry->id], ['escape' => false, 'class' => 'btn btn-sm btn-success']) ?>
                                        <?= $this->Html->link(__('Entries'), ['action' => 'get-registry-data', $registry->id], ['escape' => false, 'class' => 'btn btn-sm btn-info']) ?>
                                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $registry->id], ['escape' => false, 'class' => 'btn btn-sm btn-warning']) ?>
                                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $registry->id], ['escape' => false, 'class' => 'btn btn-sm btn-danger', 'confirm' => __('Are you sure you want to delete # {0}?', $registry->id)]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="paginator">
                    <ul class="pagination">
                        <?= $this->Paginator->first('<< ' . __('first')) ?>
                        <?= $this->Paginator->prev('< ' . __('previous')) ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next(__('next') . ' >') ?>
                        <?= $this->Paginator->last(__('last') . ' >>') ?>
                    </ul>
                    <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>