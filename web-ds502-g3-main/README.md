# web-ds502-g3
Desarrollo de Aplicaciones Web - Entregable 01 - Rama de Omar

# Propuesta de Proyecto: Sistema de Gestión de Activos de T.I. (GATI)

**Empresa:** Consultoría Ágil S.A.
**Fecha:** 31 de octubre de 2025
**Documento:** Propuesta de Desarrollo Interno

---

## 1. Resumen Ejecutivo

Este documento describe la necesidad crítica de implementar un **Sistema de Gestión de Activos de T.I. (GATI)**. Actualmente, la empresa sufre de ineficiencias, gastos innecesarios y riesgos de seguridad debido a la falta de un sistema centralizado para el rastreo de hardware y software. La solución propuesta es una aplicación web interna basada en operaciones CRUD (Crear, Leer, Actualizar, Eliminar) que proporcionará un control total y una fuente única de verdad para todo el inventario de T.I.

---

## 2. Problemática Actual

La gestión de activos en "Consultoría Ágil S.A." se ha vuelto insostenible a medida que la empresa ha crecido. El método actual depende de herramientas manuales y descentralizadas, generando los siguientes conflictos:

### Situación Actual

* **Herramientas:** Hojas de cálculo (Excel/Google Sheets) compartidas, hilos de correo electrónico y registros en papel.
* **Proceso:** Manual, lento y altamente propenso a errores humanos.
* **Visibilidad:** Nula. No existe un dashboard o reporte en tiempo real del estado del inventario.

### Puntos Críticos de Dolor

1.  **Desconocimiento del Inventario (Pérdida de Dinero):**
    * Se realizan compras duplicadas de hardware (laptops, monitores) porque no se puede confirmar el stock disponible en bodega.
    * Se renuevan licencias de software costosas (JetBrains, Adobe) para empleados que ya no las necesitan o que han dejado la empresa.

2.  **Asignación Ineficiente (Pérdida de Tiempo):**
    * El proceso de *onboarding* (asignación de equipo a un nuevo empleado) es lento, requiriendo que T.I. "cace" físicamente los activos.
    * El proceso de *offboarding* (recuperación de equipo) es inseguro; no hay un registro claro de qué debe devolver el empleado, aumentando el riesgo de pérdida de activos.

3.  **Mantenimiento Nulo (Riesgo Operativo):**
    * No se rastrea la fecha de compra ni el historial de reparaciones.
    * Esto lleva a fallas inesperadas de equipos obsoletos, causando costosos parones de trabajo para los consultores y desarrolladores.

---

## 3. Justificación del Proyecto (El Porqué)

La implementación del GATI no es una mejora técnica, sino una **necesidad estratégica de negocio**. Este sistema se justifica por los siguientes beneficios directos:

* **Reducción de Costos:** Elimina las compras duplicadas y optimiza el gasto en licencias de software, pagando solo por lo que se usa.
* **Eficiencia Operativa:** Automatiza y acelera drásticamente los procesos de *onboarding* y *offboarding*, liberando horas del equipo de T.I. para tareas de mayor valor.
* **Seguridad y Control:** Proporciona una trazabilidad completa. Se sabrá exactamente quién tiene qué activo, dónde está y desde cuándo.
* **Continuidad del Negocio:** Permite un mantenimiento proactivo al identificar equipos obsoletos antes de que fallen, asegurando que los empleados siempre tengan herramientas funcionales.

---

## 4. Solución Propuesta (El Qué)

Se propone el desarrollo de una aplicación web interna (GATI) con acceso basado en roles (Administradores de T.I. y Empleados) que centralice toda la información.

### Funcionalidad Central (CRUD)

El núcleo del sistema será la capacidad de gestionar el ciclo de vida completo de los activos y empleados mediante operaciones CRUD:

| Entidad | Create (Crear) | Read (Leer) | Update (Actualizar) | Delete (Eliminar/Baja) |
| :--- | :--- | :--- | :--- | :--- |
| **Activos** | Registrar nueva laptop, monitor, licencia. | Ver inventario total, filtrar por estado. | Cambiar estado (ej. "En Mantenimiento"). | Dar de baja un equipo obsoleto. |
| **Empleados** | Añadir nuevo empleado al sistema. | Consultar directorio de empleados. | Asignar/Remover rol de Admin. | Desactivar cuenta de empleado. |
| **Asignaciones** | Asignar un activo a un empleado. | Ver historial de un activo (quién lo tuvo). | Registrar la devolución de un equipo. | (No se elimina, se registra la devolución). |
| **Mantenimiento**| Crear un nuevo registro de servicio. | Ver historial de reparaciones de un activo. | Actualizar el costo o descripción del servicio. | Eliminar un registro de servicio erróneo. |