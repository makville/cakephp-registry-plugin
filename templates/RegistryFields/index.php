<?= $this->Element('MakvilleControlPanel.pages/page-title', ['heading' => 'Registry fields', 'subHeading' => 'fields under registry ' . $registry->name, 'icon' => 'fa fa-list']); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <div class="card-title">
                    <span class="pull-left"><?= __('Registries') ?></span>
                    <span class="pull-right table-action">
                        <?= $this->Html->link('New field', ['action' => 'add', $registry->id], ['escape' => false, 'class' => 'btn btn-sm btn-info']); ?>
                    </span>
                </div>
                <div class="table-responsive">
                    <table registry="<?= $registry->id; ?>" id="registry-fields" class="mb-0 table">
                        <thead>
                            <tr>
                                <th scope="col"><?= $this->Paginator->sort('label', ['name' => 'Question']) ?></th>
                                <th scope="col"><?= $this->Paginator->sort('data_type', ['name' => 'Response Type']) ?></th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody class="sortable">
                            <?php foreach ($registryFields as $registryField): ?>
                                <tr field="<?= $this->Number->format($registryField->id) ?>">
                                    <td><?= h($registryField->label) ?></td>
                                    <td><?= h($answerTypes[$registryField->data_type]) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('View'), ['action' => 'view', $registryField->id, $registry->id], ['escape' => false, 'class' => 'btn btn-sm btn-info']) ?>
                                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $registryField->id, $registry->id], ['escape' => false, 'class' => 'btn btn-sm btn-warning']) ?>
                                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $registryField->id, $registry->id], ['escape' => false, 'class' => 'btn btn-sm btn-danger', 'confirm' => __('Are you sure you want to delete # {0}?', $registryField->id)]) ?>
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