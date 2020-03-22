<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<ul class="vertical-nav-menu">
    <li class="app-sidebar__heading">Registries</li>
    <li>
        <a href="#"><i class="metismenu-icon pe-7s-users"></i>Registries<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i></a>
        <ul>
            <li><?= $this->Html->link('<i class="metismenu-icon pe-7s-user"></i> View all', ['plugin' => 'MakvilleRegistry', 'controller' => 'Registries', 'action' => 'index'], ['escape' => false]); ?></li>
            <li><?= $this->Html->link('<i class="metismenu-icon pe-7s-user"></i> Create registry', ['plugin' => 'MakvilleRegistry', 'controller' => 'Registries', 'action' => 'add'], ['escape' => false]); ?></li>
        </ul>
    </li>
    <li>
        <a href="#"><i class="metismenu-icon pe-7s-users"></i>Lists<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i></a>
        <ul>
            <li><?= $this->Html->link('<i class="metismenu-icon pe-7s-user"></i> View all', ['plugin' => 'MakvilleRegistry', 'controller' => 'RegistryLists', 'action' => 'index'], ['escape' => false]); ?></li>
            <li><?= $this->Html->link('<i class="metismenu-icon pe-7s-user"></i> Create list', ['plugin' => 'MakvilleRegistry', 'controller' => 'RegistryLists', 'action' => 'add'], ['escape' => false]); ?></li>
        </ul>
    </li>
</ul>