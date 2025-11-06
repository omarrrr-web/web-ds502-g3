<?php
// Este archivo es una vista parcial que genera la tabla de roles.
// Espera que una variable $roles (array de objetos) esté disponible.
?>
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th class="text-center">ID</th>
                <th>Nombre del Rol</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($roles)):
                foreach ($roles as $rol):
            ?>
                    <tr class="align-middle">
                        <td class="text-center"><?= htmlspecialchars($rol->id_rol) ?></td>
                        <td><?= htmlspecialchars($rol->nombre_rol) ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-info btn-sm btn-mostrar-rol" title="Mostrar Detalles" data-id="<?= $rol->id_rol ?>">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <a href="form_rol.php?id=<?= $rol->id_rol ?>" class="btn btn-success btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm btn-eliminar" title="Eliminar" data-id="<?= $rol->id_rol ?>">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
            <?php 
                endforeach;
            else:
            ?>
                <tr>
                    <td colspan="3" class="text-center">No se encontraron roles.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>