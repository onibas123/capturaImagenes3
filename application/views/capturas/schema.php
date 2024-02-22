<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('layout/head');?>
    <style>
        .casillas{
            width: 100px !important;
            height: 100px !important;
            max-height: auto;
        }
        .spanSelect2{
            min-width: 300px !important;
            max-width: 800px !important;
            width: 100% !important;
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">  
        <!-- sidebar-->
        <?php $this->load->view('layout/sidebar');?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php $this->load->view('layout/nav');?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid m-2" style="background-color: #fff; min-height: 500px;">
                    <!-- main content -->
                    <h4><?php if(!empty($titulo)) echo $titulo;else echo 'Esquema de Horarios';?></h4>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Organización</label>
                            <select class="form-control" id="select-organizacion">
                                <option value="">Seleccione</option>
                                <?php 
                                    if(!empty($organizaciones)){
                                        foreach($organizaciones as $o){
                                            echo '<option value="'.$o['id'].'">'.$o['nombre'].'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="">Dispositivo</label>
                            <select class="form-control" id="select-dispositivo">
                                <option value="">Seleccione</select>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12 table-responsive">
                            <table id="table-schema" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Hora</th>
                                        <th>Lunes</th>
                                        <th>Martes</th>
                                        <th>Miércoles</th>
                                        <th>Jueves</th>
                                        <th>Viernes</th>
                                        <th>Sábado</th>
                                        <th>Domingo</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-schema">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <button type="button" onclick="guardarEsquema();" class="btn btn-success">Enviar</button>
                            <button class= "btn btn-xs btn-danger" onclick="actualizar();">Cancelar</button>
                        </div>
                    </div>
                    <br>
                    -->
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php $this->load->view('layout/footer');?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <?php $this->load->view('layout/scripts');?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <!-- modales -->
    <div class="modal fade" id="modal-schema-add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModalSchema">Datos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th>Canales</th>
                            <td>
                                <select class="form-control select2-selection select2-selection--multiple" name="add_canales[]" id="select-add-canal" multiple="multiple">
                                    
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Día</th>
                            <td>
                                <select class="form-control select2-selection select2-selection--multiple" name="add-dia[]" id="select-add-dia" multiple="multiple">
                                    <option value="Lun">Lunes</option>
                                    <option value="Mar">Martes</option>
                                    <option value="Mie">Miércoles</option>
                                    <option value="Jue">Jueves</option>
                                    <option value="Vie">Viernes</option>
                                    <option value="Sab">Sábado</option>
                                    <option value="Dom">Domingo</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Hora</th>
                            <td><input type="time" value="<?php echo date('H').':00';?>" id="input-add-hora" name="add-hora" /></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="addSchema();">Agregar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-schema-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModalSchema">Datos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th>Número Canal</th>
                            <td id="td-edit-numero_canal"></td>
                        </tr>
                        <tr>
                            <th>Nombre Canal</th>
                            <td id="td-edit-nombre_canal"></td>
                        </tr>
                        <tr>
                            <th>Día</th>
                            <td>
                                <select class="form-control" name="dia" id="select-dia">
                                    <option value="Lun">Lunes</option>
                                    <option value="Mar">Martes</option>
                                    <option value="Mie">Miércoles</option>
                                    <option value="Jue">Jueves</option>
                                    <option value="Vie">Viernes</option>
                                    <option value="Sab">Sábado</option>
                                    <option value="Dom">Domingo</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Hora</th>
                            <td><input type="time" value="" id="input-hora" name="hota" /></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="editarSchema();">Editar</button>
                    <button type="button" class="btn btn-danger" onclick="eliminarSchema();">Eliminar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        var dia_schema_add = '';
        var id_schema_edit = 0;
        var dia_schema_edit = '';
        $(document).ready(function() {
            $("#select-add-dia").select2();
            inicializarTabla();
            $('#select-organizacion').change(function(){
                let options_dispositivos = '<option value="">Seleccione</select>';
                $.ajax({
                    url: '<?php echo base_url();?>index.php/CapturasController/obtenerDispositivosOrganizacion',
                    data: {organizacion: $('#select-organizacion').val()},
                    type: 'post',
                    dataType: 'json',
                    success: function(response){
                        if(response.length > 0){
                            for(let i=0; i<response.length; i++){
                                options_dispositivos += '<option value="'+response[i]['id']+'">'+response[i]['nombre']+'</option>';
                            }
                        }
                        $('#select-dispositivo').html(options_dispositivos);
                    }
                });
            });

            $('#select-dispositivo').change(function(){
                actualizarTabla();
            });
        });
    
        function actualizarTabla(){
            inicializarTabla();
            $.ajax({
                    url: '<?php echo base_url();?>index.php/CapturasController/obtenerSchema',
                    data:{dispositivo: $('#select-dispositivo').val()},
                    type: 'post',
                    dataType:'json',
                    success: function(response2){
                       
                        if(response2.length > 0){
                            
                            for(let i=0; i<response2.length;i++){

                                if(response2[i]['Lun'] == 1){
                                    let hora_minutos = response2[i]['hora'];
                                    let hora = parseInt(hora_minutos.substring(0, 2));
                                    let button = '<button onclick="abrirModalSchema(2, '+response2[i]['id']+', 1);" title="'+hora_minutos+'" class="btn btn-info w-100 mb-1">'+response2[i]['canal']+'</button>';
                                    $('#Lun_'+hora).append(button);
                                }

                                if(response2[i]['Mar'] == 1){
                                    let hora_minutos = response2[i]['hora'];
                                    let hora = parseInt(hora_minutos.substring(0, 2));
                                    let button = '<button onclick="abrirModalSchema(2, '+response2[i]['id']+', 2);" title="'+hora_minutos+'" class="btn btn-info w-100 mb-1">'+response2[i]['canal']+'</button>';
                                    $('#Mar_'+hora).append(button);
                                }

                                if(response2[i]['Mie'] == 1){
                                    let hora_minutos = response2[i]['hora'];
                                    let hora = parseInt(hora_minutos.substring(0, 2));
                                    let button = '<button onclick="abrirModalSchema(2, '+response2[i]['id']+', 3);" title="'+hora_minutos+'" class="btn btn-info w-100 mb-1">'+response2[i]['canal']+'</button>';
                                    $('#Mie_'+hora).append(button);
                                }

                                if(response2[i]['Jue'] == 1){
                                    let hora_minutos = response2[i]['hora'];
                                    let hora = parseInt(hora_minutos.substring(0, 2));
                                    let button = '<button onclick="abrirModalSchema(2, '+response2[i]['id']+', 4);" title="'+hora_minutos+'" class="btn btn-info w-100 mb-1">'+response2[i]['canal']+'</button>';
                                    $('#Jue_'+hora).append(button);
                                }

                                if(response2[i]['Vie'] == 1){
                                    let hora_minutos = response2[i]['hora'];
                                    let hora = parseInt(hora_minutos.substring(0, 2));
                                    let button = '<button onclick="abrirModalSchema(2, '+response2[i]['id']+', 5);" title="'+hora_minutos+'" class="btn btn-info w-100 mb-1">'+response2[i]['canal']+'</button>';
                                    $('#Vie_'+hora).append(button);
                                }

                                if(response2[i]['Sab'] == 1){
                                    let hora_minutos = response2[i]['hora'];
                                    let hora = parseInt(hora_minutos.substring(0, 2));
                                    let button = '<button onclick="abrirModalSchema(2, '+response2[i]['id']+', 6);" title="'+hora_minutos+'" class="btn btn-info w-100 mb-1">'+response2[i]['canal']+'</button>';
                                    $('#Sab_'+hora).append(button);
                                }

                                if(response2[i]['Dom'] == 1){
                                    let hora_minutos = response2[i]['hora'];
                                    let hora = parseInt(hora_minutos.substring(0, 2));
                                    let button = '<button onclick="abrirModalSchema(2, '+response2[i]['id']+', 7);" title="'+hora_minutos+'" class="btn btn-info w-100 mb-1">'+response2[i]['canal']+'</button>';
                                    $('#Dom_'+hora).append(button);
                                }
                            }
                        }
                    }
                });
        }

        function removerHora(canal, hora){
            $('#row_'+canal+'_'+hora).remove();
        }

        function agregarHora(canal){
            let elementos_horas = $('.horas');
            let hora = 1;
            for(let i=0; i< elementos_horas.length; i++){
                if($(elementos_horas[i]).attr('canal') == canal){
                    hora = $(elementos_horas[i]).attr('hora');
                }
            }

            hora++;
            let row = '';
            row  += '<div class="row" id="row_'+canal+'_'+hora+'">';
            row  += '<div class="col-md-8">';
            row  += '<input canal="'+canal+'" hora="'+hora+'" class="horas" id="hora-'+canal+'_'+hora+'" class="form-contron" type="time" value="06:00">';
            row  += '</div>';
            row  += '<div class="col-md-4"><button class="btn btn-danger btn-sm round" onclick="removerHora('+canal+','+hora+');">-</button></div>';
            row  += '</div>';

            $('#td-horas-'+canal).append(row);
        }

        function agregarHora2(canal){
            let elementos_horas = $('.horas');
            let hora = 0;
            for(let i=0; i< elementos_horas.length; i++){
                if($(elementos_horas[i]).attr('canal') == canal){
                    hora++;
                }
            }

            hora++;
            let row = '';
            row  += '<div class="row" id="row_'+canal+'_'+hora+'">';
            row  += '<div class="col-md-8">';
            row  += '<input canal="'+canal+'" hora="'+hora+'" class="horas" id="hora-'+canal+'_'+hora+'" class="form-contron" type="time" value="06:00">';
            row  += '</div>';
            if(hora > 1)
                row  += '<div class="col-md-4"><button class="btn btn-danger btn-sm round" onclick="removerHora('+canal+','+hora+');">-</button></div>';
            else
                row  += '<div class="col-md-4"><button onclick="agregarHora('+canal+');" class="btn btn-primary btn-sm round">+</button></div>';
            row  += '</div>';

            $('#td-horas-'+canal).append(row);
            return 'hora-'+canal+'_'+hora;
        }

        function actualizar(){
            location.reload();
        }

        function guardarEsquema(){
            if(confirm('Confirme esta operación')){
                let arreglo = [];
                let horas = [];
                let filas = $('.tr-canales');
                if(filas.length > 0){
                    for(let i=0; i<filas.length; i++){
                        let canal = $(filas[i]).attr('canal');
                        let lun = $('#input-check-lun_'+canal).is(':checked');
                        let mar = $('#input-check-mar_'+canal).is(':checked');
                        let mie = $('#input-check-mie_'+canal).is(':checked');
                        let jue = $('#input-check-jue_'+canal).is(':checked');
                        let vie = $('#input-check-vie_'+canal).is(':checked');
                        let sab = $('#input-check-sab_'+canal).is(':checked');
                        let dom = $('#input-check-dom_'+canal).is(':checked');
                        
                        let horas = $('input[canal="'+canal+'"]');
                        let temp_horas = [];
                        if(horas.length > 0){
                            for(let j=0; j<horas.length; j++){
                                temp_horas.push($(horas[j]).val());
                            }    
                        }
                        arreglo.push({'canal': canal, 'lun': lun, 'mar': mar, 'mie': mie, 'jue': jue, 'vie': vie, 'sab': sab, 'dom': dom, 'horas': temp_horas});
                    }

                    $.ajax({
                        url: '<?php echo base_url();?>index.php/CapturasController/guardarSchema',
                        type: 'post',
                        data: {'schema': arreglo, 'organizacion': $('#select-organizacion').val(), 'dispositivo': $('#select-dispositivo').val()},
                        dataType: 'text',
                        success: function(response){
                            if(response == 1){
                                alert('Se ha generado el equema de horarios');
                                location.reload();
                            }     
                        }
                    });
                }
                else
                    alert('Debe existir al menos un Canal con su esquema de horarios');
            }
        }
        //Cambio en esquema 17-02-2024
        function inicializarTabla(){
            let tbody = '';
            for(let i=0; i<=23; i++){
                tbody += '<tr>';
                tbody += '<td style="width: 50px;">'+((i < 10) ? '0'+i+':00' : i+':00')+'</td>';
                tbody += '<td class="casillas text-center" hora="'+i+'" dia="Lun" id="Lun_'+i+'"><button onclick="abrirModalSchema(1,null, 1);" title="Agregar" class="btn btn-primary btn-sm mb-2">+</button></td>';
                tbody += '<td class="casillas text-center" hora="'+i+'" dia="Mar" id="Mar_'+i+'"><button onclick="abrirModalSchema(1,null, 2);" title="Agregar" class="btn btn-primary btn-sm mb-2">+</button></td>';
                tbody += '<td class="casillas text-center" hora="'+i+'" dia="Mie" id="Mie_'+i+'"><button onclick="abrirModalSchema(1,null, 3);" title="Agregar" class="btn btn-primary btn-sm mb-2">+</button></td>';
                tbody += '<td class="casillas text-center" hora="'+i+'" dia="Jue" id="Jue_'+i+'"><button onclick="abrirModalSchema(1,null, 4);" title="Agregar" class="btn btn-primary btn-sm mb-2">+</button></td>';
                tbody += '<td class="casillas text-center" hora="'+i+'" dia="Vie" id="Vie_'+i+'"><button onclick="abrirModalSchema(1,null, 5);" title="Agregar" class="btn btn-primary btn-sm mb-2">+</button></td>';
                tbody += '<td class="casillas text-center" hora="'+i+'" dia="Sab" id="Sab_'+i+'"><button onclick="abrirModalSchema(1,null, 6);" title="Agregar" class="btn btn-primary btn-sm mb-2">+</button></td>';
                tbody += '<td class="casillas text-center" hora="'+i+'" dia="Dom" id="Dom_'+i+'"><button onclick="abrirModalSchema(1,null, 7);" title="Agregar" class="btn btn-primary btn-sm mb-2">+</button></td>';
                tbody += '</tr>';
            }
            $('#tbody-schema').html(tbody);
        }

        function abrirModalSchema(operacion, id = null, dia = null){
            if(operacion == 1){
                if($('#select-dispositivo').val() == ''){
                    alert('Debe seleccionar un dispositivo.');
                    return false;
                }

                dia_schema_add = '';
                if(dia != null){
                    switch(dia) {
                        case 1:
                            dia_schema_add = 'Lun';
                            break;
                        case 2:
                            dia_schema_add = 'Mar';
                            break;
                        case 3:
                            dia_schema_add = 'Mie';
                            break;
                        case 4:
                            dia_schema_add = 'Jue';
                            break;
                        case 5:
                            dia_schema_add = 'Vie';
                            break;
                        case 6:
                            dia_schema_add = 'Sab';
                            break;
                        case 7:
                            dia_schema_add = 'Dom';
                            break;
                        default:
                    }
                }

                $.ajax({
                    url: '<?php echo base_url();?>index.php/CapturasController/obtenerCantidadCanalesDispotivo3',
                    type: 'post',
                    data: {dispositivo: $('#select-dispositivo').val()},
                    dataType: 'text',
                    success: function(response){
                        $('#select-add-canal').html(response);
                        $("#select-add-canal").select2({placeholder: "Seleccione..."});
                        $('span.select2').addClass('spanSelect2');
                    }
                });

                $('#modal-schema-add').modal('show');
            }   
            else{
                id_schema_edit = id;
                if(dia != null){
                    switch(dia) {
                        case 1:
                            dia_schema_edit = 'Lun';
                            break;
                        case 2:
                            dia_schema_edit = 'Mar';
                            break;
                        case 3:
                            dia_schema_edit = 'Mie';
                            break;
                        case 4:
                            dia_schema_edit = 'Jue';
                            break;
                        case 5:
                            dia_schema_edit = 'Vie';
                            break;
                        case 6:
                            dia_schema_edit = 'Sab';
                            break;
                        case 7:
                            dia_schema_edit = 'Dom';
                            break;
                        default:
                    }
                }
                $.ajax({
                    url: '<?php echo base_url();?>index.php/CapturasController/obtenerDataSchema',
                    data: {id: id_schema_edit},
                    dataType: 'json',
                    type: 'post',
                    success: function(data){
                        $('#td-edit-numero_canal').html(data[0]['canal']);
                        $('#td-edit-nombre_canal').html(data[0]['nombre_canal']);
                        $('#select-dia').val(dia_schema_edit);
                        $('#input-hora').val(data[0]['hora']);
                    }
                });
                $('#modal-schema-edit').modal('show');
            }         
        }

        function editarSchema(){
            let dispositivo = $('#select-dispositivo').val();
            let canal =  $('#td-edit-numero_canal').html();
            let dia = $('#select-dia').val();
            let hora = $('#input-hora').val();

            $.ajax({
                url: '<?php echo base_url();?>index.php/CapturasController/editarDataSchema',
                data: {id: id_schema_edit, dispositivo: dispositivo, canal: canal, dia_actual: dia_schema_edit, dia: dia, hora: hora},
                type: 'post',
                success: function(response){
                    $('#modal-schema-edit').modal('hide');
                    actualizarTabla();
                }
            });
        }

        function eliminarSchema(){
            if(confirm('Confirme esta operación')){
                let dispositivo = $('#select-dispositivo').val();
                let canal =  $('#td-edit-numero_canal').html();
                let dia = $('#select-dia').val();
                let hora = $('#input-hora').val();

                $.ajax({
                    url: '<?php echo base_url();?>index.php/CapturasController/eliminarDataSchema',
                    data: {id: id_schema_edit, dispositivo: dispositivo, canal: canal, dia_actual: dia_schema_edit, dia: dia, hora: hora},
                    type: 'post',
                    success: function(response){
                        $('#modal-schema-edit').modal('hide');
                        actualizarTabla();
                    }
                });
            }
        }

        function addSchema(){
            let dispositivo = $('#select-dispositivo').val();
            let canal =  $('#select-add-canal').val();
            let dia = $('#select-add-dia').val();
            let hora = $('#input-add-hora').val();

            $.ajax({
                url: '<?php echo base_url();?>index.php/CapturasController/addDataSchema',
                data: {dispositivo: dispositivo, canal: canal, dia: dia, hora: hora},
                type: 'post',
                success: function(response){
                    $('#modal-schema-add').modal('hide');
                    actualizarTabla();
                }
            });
        }
    </script>
</body>
</html>