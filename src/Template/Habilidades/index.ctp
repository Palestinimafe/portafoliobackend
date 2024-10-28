<h1>Lista de Habilidades</h1>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Nivel</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($habilidades as $habilidad): ?>
        <tr>
            <td><?= h($habilidad->id_habilidad) ?></td>
            <td><?= h($habilidad->nombre) ?></td>
            <td><?= h($habilidad->descripcion) ?></td>
            <td><?= h($habilidad->nivel) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
