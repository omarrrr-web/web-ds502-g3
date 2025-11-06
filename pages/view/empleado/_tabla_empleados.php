<?php
// Este archivo es una vista parcial que genera la tabla de empleados.
// Espera que una variable $empleados (array de objetos) esté disponible.
?>
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th class="text-center">ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Rol</th>
                <th class="text-center">Estado</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($empleados)): ?>
                <?php foreach ($empleados as $emp): ?>
                    <tr class="align-middle">
                        <td class="text-center"><?= htmlspecialchars($emp->id_empleado) ?></td>
                        <td><?= htmlspecialchars($emp->nombre) ?></td>
                        <td><?= htmlspecialchars($emp->apellido) ?></td>
                        <td><?= htmlspecialchars($emp->email) ?></td>
                        <td><?= htmlspecialchars($emp->roles) ?></td>
                        <td class="text-center">
                            <?php if ($emp->activo): ?>
                                <span class="badge bg-success">Activo</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Inactivo</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-info btn-sm btn-mostrar" title="Mostrar Detalles" data-id="<?= $emp->id_empleado ?>">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <a href="form_empleado.php?id=<?= $emp->id_empleado ?>" class="btn btn-success btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if ($emp->activo): ?>
                                    <button type="button" class="btn btn-danger btn-sm btn-desactivar" title="Desactivar" data-id="<?= $emp->id_empleado ?>">
                                        <i class="fas fa-user-slash"></i>
                                    </button>
                                <?php else: ?>
                                    <button type="button" class="btn btn-secondary btn-sm btn-activar" title="Activar" data-id="<?= $emp->id_empleado ?>">
                                        <i class="fas fa-user-check"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">No se encontraron empleados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>