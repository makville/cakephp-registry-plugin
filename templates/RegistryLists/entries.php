<?= $this->Element('MakvilleControlPanel.pages/page-title', ['heading' => 'Registry List (' . $list->name . ')', 'subHeading' => 'entries under ' . $list->name, 'icon' => 'fa fa-list']); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <div class="card-title">
                    <span class="pull-left"><?= __('Registry List Entries') ?></span>
                    <span class="pull-right table-action">
                        <?= $this->Html->link('New list entry', ['controller' => 'RegistryLists', 'action' => 'new-entry', $list->id], ['class' => 'btn btn-sm btn-info']); ?>
                    </span>
                </div>
                <div class="table-responsive">
                    <table class="mb-0 table">
                        <thead>
                            <tr>
                                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $entry): ?>
                                <tr>
                                    <td><?= h($entry->name) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('Edit'), ['action' => 'edit-entry', $list->id, $entry->id], ['class' => 'btn btn-sm btn-warning']) ?>
                                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete-entry', $list->id, $entry->id], ['class' => 'btn btn-sm btn-danger', 'confirm' => __('Are you sure you want to delete # {0}?', $entry->id)]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="paginator">
                    
                </div>
            </div>
        </div>
    </div>
</div>