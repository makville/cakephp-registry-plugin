<?= $this->Element('MakvilleControlPanel.pages/page-title', ['heading' => 'Edit list entry', 'subHeading' => 'edit an existing list entry']); ?>
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Edit list entry</h5>
                <hr />
                <?= $this->Form->create($entry) ?>
                <fieldset>
                    <?php
                    echo $this->Form->control('name', ['class' => 'form-control']);
                    ?>
                </fieldset>
                <p>&nbsp;</p>
                <?= $this->Form->button(__('Edit list entry'), ['class' => 'btn btn-success pull-right']) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
