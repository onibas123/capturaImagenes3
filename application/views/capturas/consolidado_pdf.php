<!DOCTYPE html>
<html>
<head>
	<title>Listado de Capturas Consolidadas</title>
	<meta charset="utf-8">

	<style type="text/css">
  fieldset 
  {
        border: 1px solid #ddd !important;
        margin: 0;
        xmin-width: 0;
        padding: 10px;       
        position: relative;
        border-radius:4px;
        //background-color:#f5f5f5;
        padding-left:10px!important;
    }
    legend
    {
        font-size:14px;
        font-weight:bold;
        margin-bottom: 0px; 
        width: 35%; 
        border: 1px solid #ddd;
        border-radius: 4px; 
        padding: 5px 5px 5px 10px; 
        background-color: #ffffff;
    }
    .form-control {
      background-color: #ffffff;
      border: 1px solid #light;
      border-radius: 0px;
      box-shadow: none;
      color: #565656;
      height: 20px;
      width: 100%;
      max-width: 100%;
      padding: 7px 12px;
      transition: all 300ms linear 0s;
      font-size: 11px;
  }
  .table {
      width: 100%;
      max-width: 100%;
      margin-bottom: 20px;
      border-spacing: 0;
      border-collapse: collapse;
      display: table;
      border-collapse: separate;
      border-spacing: 2px;
      border-color: grey;
      font-size: 11px;
  }
  table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
  }
</style>
</head>
<body>
<center>
  <table class="table">
    <tr>
      <td><img src="<?php echo base_url();?>assets/img/logo.png" class="img-responsive" width="50" height="50" /><b style="font-size: 14px;"><?php echo $datos_empresa['nombre_empresa'];?></b></td>
      <td></td>
    </tr>
    <tr>
      <td>
        <b style="font-size: 12px;"><?php echo $datos_empresa['direccion_empresa'];?></b><br>
        <b style="font-size: 12px;"><?php echo 'Email: '.$datos_empresa['email_empresa'].', Teléfono: '.$datos_empresa['telefono_empresa'];?></b>
      </td>
    </tr>
  </table>
</center>
<br>
<center>
	<h3>
		<?php
		if(!empty($title))
			echo $title;
		?>
	</h3>
</center>
<hr>
<center>
  <fieldset>
    <legend>Datos Organización:</legend>
    <table class="table">
      <tr>
        <td><b>R.U.T:</b> </td>
        <td><u><?php echo $datos_organizacion[0]['rut'];?></u></td>

        <td><b>Contacto:</b> </td>
        <td><u><?php echo $datos_organizacion[0]['contacto'];?></u></td>
      </tr>

      <tr>
        <td><b>Razón Social:</b> </td>
        <td colspan="3"><u><?php echo $datos_organizacion[0]['razon_social'];?></u></td>
      </tr>

      <tr>
        <td><b>Dirección:</b> </td>
        <td><u><?php echo $datos_organizacion[0]['direccion'];?></u></td>

        <td><b>Tel Contacto:</b> </td>
        <td><u><?php echo $datos_organizacion[0]['telefono'];?></u></td>
      </tr>
    </table>
  </fieldset>
</center>
<br>
<table border="1" class="table">
  <thead>
    <tr>
      <th>Imagen</th>
      <th>Ubicación</th>
      <th>Cámara</th>
      <th>Observación</th>
      <th>Fecha</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if(!empty($datos)){
      foreach($datos as $d){
        echo '<tr>';
        echo '<td><center><img src="'.base_url().'assets/imagenes_capturadas/'.$d['imagen'].'" class="img-responsive" width="100" height="100"/></center></td>';
        echo '<td>'.$d['ubicacion'].'</td>';
        echo '<td>'.$d['canal'].'</td>';
        echo '<td>'.$d['observacion'].'</td>';
        echo '<td>'.$d['fecha_hora'].'</td>';
        echo '</tr>';
      }
    }
    ?>
  </tbody>
</table>
</body>
</html>