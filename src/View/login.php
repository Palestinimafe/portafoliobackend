<h1>Iniciar Sesión</h1>
<?= $this->Form->create() ?>
<?= $this->Form->control('username', ['label' => 'Nombre de usuario']) ?>
<?= $this->Form->control('password', ['label' => 'Contraseña']) ?>
<?= $this->Form->button(__('Login')) ?>
<?= $this->Form->end() ?>
