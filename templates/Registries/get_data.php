<?php

//$this->layout = false; ?>
<table title="Spreadsheet 1">
    <thead>
        <tr>
            <th></th>
            <?php foreach ( $columns as $column ): ?>
            <th scope="col"><?= $column->label; ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ( $data as $row ) : ?>
        <tr>
            <td><?= $this->Html->link('Edit', ['plugin' => 'registry', 'controller' => 'registries', 'action' => 'edit-entry', $registry->id, $row['id']]); ?> | Delete</td>
            <?php foreach ($columns as $column ) : ?>
            <td><?= $this->Output->output($column, $lists, $row[$column->name]); ?></td>
            <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>