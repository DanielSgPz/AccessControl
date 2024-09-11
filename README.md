## AccessControl
AccessControl es un sistema de control de acceso diseñado para verificar si una persona tiene permiso de ingresar a un área específica donde se encuentra implementado el sistema.

### Funcionalidades
**Superusuario:** El sistema incluye un control de superusuario que puede crear administradores. Solo el superusuario tiene el privilegio de eliminar administradores.
**Administradores:** Los administradores pueden crear, delegar permisos de acceso y desactivar usuarios. Las eliminaciones no eliminan los datos, ya que se requiere mantener un historial de los accesos.
**Historial de accesos:** Se registra un historial de entradas y cualquier intento de acceso al área protegida.
**Asociación de empleados:** Cada empleado está asociado a un departamento. Es necesario crear departamentos antes de registrar empleados.
**Carga masiva:** Permite la carga masiva de empleados mediante un archivo CSV.
**Reportes:** Genera reportes en PDF con el historial de acceso de empleados.
**Simulación de acceso:** Provee una ruta especial para simular accesos, evaluando si un empleado tiene los permisos necesarios para ingresar.
**Middleware de autenticación:** El sistema incluye un middleware de seguridad para la autenticación y administración del superusuario.
#### Instalación
Para usar este sistema, sigue estos pasos:

1. Clonar el repositorio
2. Instalar las dependencias de Composer
3. Generar la clave de la aplicación
4. Configurar la base de datos en el archivo .env.
5. Ejecutar las migraciones
6. Ejecutar el seeder para crear el superusuario

#### Uso
Luego de ejecutar el seeder, inicia sesión con las credenciales proporcionadas en el archivo de seed o con las que hayas configurado.
Una vez dentro, serás redirigido a la sección de creación de administradores, donde podrás crear, editar o eliminar administradores.
Los administradores pueden crear registros de empleados desde la opción "Admin Users". Cada empleado debe estar asociado a un departamento, por lo que debes crear los departamentos antes.
Es posible cargar usuarios de manera masiva utilizando un archivo CSV.
En la sección de Dashboard, puedes visualizar el registro de ingresos y generar reportes en PDF con el historial de un empleado.
Para simular un ingreso, utiliza la ruta /accessControlRoom donde ingresarás el ID del empleado y el sistema determinará si se le otorga acceso según sus permisos.
Seguridad
El superusuario está protegido por un middleware que asegura que solo este tipo de usuario pueda realizar acciones críticas, como la eliminación de administradores.
