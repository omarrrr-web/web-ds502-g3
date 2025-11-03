<?php
// Este archivo es una vista parcial que genera la tabla de roles.
// Espera que una variable $roles (array de objetos) esté disponible.
?>
<table class="table table-striped table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nombre del Rol</th>
            <th class="text-center">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($roles)): ?>
            <?php foreach ($roles as $rol): ?>
                <tr>
                    <td><?= htmlspecialchars($rol->id_rol) ?></td>
                    <td><?= htmlspecialchars($rol->nombre_rol) ?></td>
                    <td class="text-center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-info btn-sm btn-mostrar-rol" data-id="<?= $rol->id_rol ?>">
                                <i class="fas fa-eye"></i> Mostrar
                            </button>
                            <a href="form_rol.php?id=<?= $rol->id_rol ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <button type="button" class="btn btn-danger btn-sm btn-eliminar" data-id="<?= $rol->id_rol ?>">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3" class="text-center">No se encontraron roles.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
