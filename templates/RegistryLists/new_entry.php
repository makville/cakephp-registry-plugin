<?= $this->Element('MakvilleControlPanel.pages/page-title', ['heading' => 'New list entry', 'subHeading' => 'new list entry']); ?>
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">New list entry</h5>
                <hr />
                <?= $this->Form->create(null) ?>
                <fieldset>
                    <?php
                    echo $this->Form->control('name', ['class' => 'form-control']);
                    ?>
                </fieldset>
                <p>&nbsp;</p>
                <?= $this->Form->button(__('New list entry'), ['class' => 'btn btn-success pull-right']) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
