<?php
// Este archivo es una vista parcial que genera la tabla de empleados.
// Espera que una variable $empleados (array de objetos) esté disponible.
?>
<table class="table table-striped table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Email</th>
            <th>Rol</th>
            <th class="text-center">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($empleados)): ?>
            <?php foreach ($empleados as $emp): ?>
                <tr>
                    <td><?= htmlspecialchars($emp->id_empleado) ?></td>
                    <td><?= htmlspecialchars($emp->nombre) ?></td>
                    <td><?= htmlspecialchars($emp->apellido) ?></td>
                    <td><?= htmlspecialchars($emp->email) ?></td>
                    <td><?= htmlspecialchars($emp->roles) ?></td>
                    <td class="text-center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-info btn-sm btn-mostrar" data-id="<?= $emp->id_empleado ?>">
                                <i class="fas fa-eye"></i> Mostrar
                            </button>
                            <a href="form_empleado.php?id=<?= $emp->id_empleado ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <?php if ($emp->activo): ?>
                                <button type="button" class="btn btn-danger btn-sm btn-desactivar" data-id="<?= $emp->id_empleado ?>">
                                    <i class="fas fa-trash"></i> Desactivar
                                </button>
                            <?php else: ?>
                                <button type="button" class="btn btn-success btn-sm btn-activar" data-id="<?= $emp->id_empleado ?>">
                                    <i class="fas fa-check-circle"></i> Activar
                                </button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center">No se encontraron empleados.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
