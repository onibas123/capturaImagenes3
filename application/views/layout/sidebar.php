<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo base_url();?>index.php/ConfiguracionesController/index">
    <div class="sidebar-brand-icon">
    <!-- <div class="sidebar-brand-icon rotate-n-15"> -->
        <!--<i class="fas fa-cogs"></i>-->
        <img src="<?php echo base_url();?>assets/img/logo.png" class="img-responsive" width="75px;"/>
    </div>
    <div class="sidebar-brand-text mx-3">Panel Control<sup></sup></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="#">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Administración</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Interface
</div>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-cog"></i>
        <span>Configuración</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Configuración</h6>
            <a class="collapse-item" href="<?php echo base_url();?>index.php/ConfiguracionesController/index">Paramétrica</a>
            <a class="collapse-item" href="<?php echo base_url();?>index.php/UsuariosController/index">Usuarios</a>
            <a class="collapse-item" href="<?php echo base_url();?>index.php/RolesController/index">Roles</a>
            <a class="collapse-item" href="<?php echo base_url();?>index.php/OpcionesController/index">Opciones</a>
            <a class="collapse-item" href="<?php echo base_url();?>index.php/RolesController/permisos">Permisos</a>
            <a class="collapse-item" href="<?php echo base_url();?>index.php/OrganizacionesController/index">Organizaciones</a>
            <a class="collapse-item" href="<?php echo base_url();?>index.php/TipoDispositivoController/index">Tipo Dispositivo</a>
            <a class="collapse-item" href="<?php echo base_url();?>index.php/MarcasController/index">Marcas</a>
            <a class="collapse-item" href="<?php echo base_url();?>index.php/DispositivosController/index">Dispositivos</a>
        </div>
    </div>
</li>
<!-- Nav Item - Utilities Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
        aria-expanded="true" aria-controls="collapseUtilities">
        <i class="fas fa-fw fa-wrench"></i>
        <span>Gestión</span>
    </a>
    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Gestión</h6>
            <a class="collapse-item" href="<?php echo base_url();?>index.php/CapturasController/schema">Esquema de Horarios</a>
            <a class="collapse-item" href="<?php echo base_url();?>index.php/CapturasController/index">Capturas</a>
            <a class="collapse-item" href="<?php echo base_url();?>index.php/CapturasController/consolidate">Consolidar</a>
        </div>
    </div>
</li>
<!-- Divider -->
<hr class="sidebar-divider">
<!-- Heading -->
<div class="sidebar-heading">
    Reportes
</div>
<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
        aria-expanded="true" aria-controls="collapsePages">
        <i class="fas fa-fw fa-folder"></i>
        <span>Entidad</span>
    </a>
    <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Capturas Consolidadas</h6>
            <a class="collapse-item"  href="<?php echo base_url();?>index.php/CapturasController/report">Registros</a>
            <div class="collapse-divider"></div>
            <h6 class="collapse-header">Información Log</h6>
            <a class="collapse-item" href= "<?php echo base_url();?>index.php/LogsController/index">Logs</a>
        </div>
    </div>
</li>
<!-- Nav Item - Charts -->
<!--
<li class="nav-item">
    <a class="nav-link" href="charts.html">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Charts</span></a>
</li>
-->
<!-- Nav Item - Tables -->
<!--
<li class="nav-item">
    <a class="nav-link" href="tables.html">
        <i class="fas fa-fw fa-table"></i>
        <span>Tables</span></a>
</li>
-->
<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">
</ul>
<!-- End of Sidebar -->