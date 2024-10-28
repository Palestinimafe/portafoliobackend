<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Usuario $usuario
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Usuario'), ['action' => 'edit', $usuario->id_usuario]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Usuario'), ['action' => 'delete', $usuario->id_usuario], ['confirm' => __('Are you sure you want to delete # {0}?', $usuario->id_usuario)]) ?> </li>
        <li><?= $this->Html->link(__('List Usuarios'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Usuario'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Habilidades'), ['controller' => 'Habilidades', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Habilidade'), ['controller' => 'Habilidades', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="usuarios view large-9 medium-8 columns content">
    <h3><?= h($usuario->username) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Username') ?></th>
            <td><?= h($usuario->username) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($usuario->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id Usuario') ?></th>
            <td><?= $this->Number->format($usuario->id_usuario) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fecha Alta') ?></th>
            <td><?= h($usuario->fecha_alta) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Password') ?></h4>
        <?= $this->Text->autoParagraph(h($usuario->password)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Habilidades') ?></h4>
        <?php if (!empty($usuario->habilidades)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id Habilidad') ?></th>
                <th scope="col"><?= __('Nombre') ?></th>
                <th scope="col"><?= __('Descripcion') ?></th>
                <th scope="col"><?= __('Nivel') ?></th>
                <th scope="col"><?= __('Fichero') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($usuario->habilidades as $habilidades): ?>
            <tr>
                <td><?= h($habilidades->id_habilidad) ?></td>
                <td><?= h($habilidades->nombre) ?></td>
                <td><?= h($habilidades->descripcion) ?></td>
                <td><?= h($habilidades->nivel) ?></td>
                <td><?= h($habilidades->fichero) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Habilidades', 'action' => 'view', $habilidades->id_habilidad]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Habilidades', 'action' => 'edit', $habilidades->id_habilidad]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Habilidades', 'action' => 'delete', $habilidades->id_habilidad], ['confirm' => __('Are you sure you want to delete # {0}?', $habilidades->id_habilidad)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
