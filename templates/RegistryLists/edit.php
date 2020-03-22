<?= $this->Element('MakvilleControlPanel.pages/page-title', ['heading' => 'Edit registry', 'subHeading' => 'edit an existing registry list']); ?>
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Edit registry list</h5>
                <hr />
                <?= $this->Form->create($registryList) ?>
                <fieldset>
                    <?php
                    echo $this->Form->control('name', ['class' => 'form-control']);
                    echo $this->Form->control('description', ['class' => 'form-control']);
                    ?>
                </fieldset>
                <p>&nbsp;</p>
                <?= $this->Form->button(__('Edit registry list'), ['class' => 'btn btn-success pull-right']) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
