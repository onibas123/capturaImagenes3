<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('layout/head');?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>
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
                    <h4><?php if(!empty($titulo)) echo $titulo;else echo 'Subir imágenes';?></h4>
                    <hr>
                    
                        <!--
                        <div class="col-md-12">
                            <label for="">Imagen</label>
                            <form id="formularioImagen" enctype="multipart/form-data">
                                <input type="file" name="imagen" id="imagen">
                                <button class="btn btn-primary" type="button" onclick="subirImagen()">Subir Imagen</button>
                            </form>
                            <br>
                            <div class="d-flex justify-content-center">
                                <img style="cursor: pointer;" onclick="abrirGrande(this.src);" width="300" height="300" src="https://aquiporti.ec/dreamlab/wp-content/uploads/2020/02/default-300x300.jpg" id="img-captura" class="img-responsive pull-center"/>
                            </div>
                        </div>
                        -->
                        
                        
                            <!-- Puedes agregar opciones y mensajes adicionales aquí -->
                            <!-- aqui quede, la idea es pasas mediante js en el ambite de dropzone los datos a 
                            inputs hidden...-->
                            
                            <div class="row mt-2">
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
                                        <option value="">Seleccione</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label for="">Canal</label>
                                    <select id="select-canal" class="form-control">
                                        <option value="">Seleccione</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Consolidado</label>
                                    <br>
                                    <input id="input-consolidado" type="checkbox" class="form-control" style="cursor: pointer; width: 35px; height: 35px;">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-8">
                                    <label for="">Sugerencias</label>
                                    <select class="form-control" id="select-sugerencia">
                                            <?php
                                                $this->db->select('*');
                                                $this->db->from('observaciones_sugeridas');
                                                $obs = $this->db->get()->result_array();
                                                if(!empty($obs)){
                                                    foreach($obs as $o){
                                                        echo '<option value="'.$o['id'].'">'.$o['id'].' | '.$o['observacion'].'</option>';
                                                    }
                                                }
                                            ?>
                                    </select>
                                </div>
                                <div class="col-md-2 mt-3">
                                    <button type="button" onclick="utilizarSugerencia();" class="btn btn-primary w-100">Utilizar</button>
                                </div>
                                <div class="col-md-2 mt-3">
                                    <button type="button" onclick="borrar();" class="btn btn-danger w-100">Borrar</button>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <label for="">Observación</label>
                                    <textarea id="area-observacion" class="form-control" rows="4" placeholder="Ingrese observación..."></textarea>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <button id="btnCargar" type="button" class="btn btn-success">Comenzar Carga</button>
                                    <button type="button" class= "btn btn-xs btn-danger" onclick="actualizar();">Cancelar</button>
                                </div>
                            </div>
                            <div class="row mt-2 d-none" id="rowCargar">
                                <form method="post" action="<?php echo base_url();?>index.php/CapturasController/addCaptura" class="dropzone w-100 ml-1 mr-1" id="myDropzone">
                                    <input type="hidden" name="organizacion" id="input-hidden-organizacion">
                                    <input type="hidden" name="dispositivo" id="input-hidden-dispositivo">
                                    <input type="hidden" name="canal" id="input-hidden-canal">
                                    <input type="hidden" name="observacion" id="input-hidden-observacion">
                                    <input type="hidden" name="consolidado" id="input-hidden-consolidado">
                                </form>
                            </div>
                        
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
    <script>
        var img_captura = $('#img-captura');
        var nombre_imagen = '';
        $(document).ready(function() {
            $('.dz-button').html('Mover archivos aquí para subir.');
            $("#select-sugerencia").select2({placeholder: "Seleccione..."});
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
                let option = '<option value="">Seleccione</option>';
                $.ajax({
                    url: '<?php echo base_url();?>index.php/CapturasController/obtenerCantidadCanalesDispotivo',
                    type: 'post',
                    data: {dispositivo: $(this).val()},
                    dataType: 'text',
                    success: function(response){
                        /*
                        let canales = parseInt(response);
                        for(let i=1; i<=canales; i++){
                            option += '<option value="'+i+'">'+i+'</option>';
                        }
                        */
                        $('#select-canal').html(response);
                    }
                });
            });

            // Configurar opciones de Dropzone
            Dropzone.options.myDropzone = {
                autoProcessQueue: false, // Deshabilitar la carga automática para procesar manualmente
                parallelUploads: 15, // Número de subidas simultáneas permitidas
                maxFilesize: 2, // Tamaño máximo del archivo en MB
                acceptedFiles: 'image/*', // Solo permitir imágenes
                addRemoveLinks: true, // Mostrar enlaces para eliminar archivos

                init: function() {
                    var myDropzone = this;

                    // Configurar evento de clic en un botón para iniciar la carga manualmente
                    $('#btnSubir').on('click', function() {
                        myDropzone.processQueue(); // Iniciar carga
                    });

                    // Configurar evento para cuando se completa la carga de archivos
                    this.on('complete', function(file) {
                        myDropzone.removeFile(file); // Eliminar el archivo del área de carga
                    });
                }
            };

            $('#btnCargar').click(function(){
                let org = $('#select-organizacion').val();
                let dev = $('#select-dispositivo').val();
                let canal = $('#select-canal').val();

                if(org == ''){
                    alert('Debe seleccionar una Organización.');
                    return false;
                }

                if(dev == ''){
                    alert('Debe seleccionar un Dispositivo.');
                    return false;
                }

                if(canal == ''){
                    alert('Debe seleccionar un canal.');
                    return false;
                }

                let consolidado = 0;
                if ($('#input-consolidado').is(':checked'))
                    consolidado = 1;
                let observacion = $('#area-observacion').val();

                $('#input-hidden-organizacion').val(org);
                $('#input-hidden-dispositivo').val(dev);
                $('#input-hidden-canal').val(canal);
                $('#input-hidden-consolidado').val(consolidado);
                $('#input-hidden-observacion').val(observacion);
                $('#rowCargar').removeClass('d-none');
            });
        });

        function utilizarSugerencia(){
            let sugerencia = $("#select-sugerencia option:selected").text();
            sugerencia = sugerencia.split('|');
            sugerencia = sugerencia[1];
            $('#area-observacion').append(' '+sugerencia);
        }

        function capturar(){
            let organizacion = $('#select-organizacion').val();
            let dispositivo = $('#select-dispositivo').val();
            let canal = $('#select-canal').val();
            if(canal == ''){
                alert('Debe selecciona un canal');
                return false;
            }
            img_captura.attr('src', '<?php echo base_url();?>assets/img/loading.gif');
            $('#btnCapturar').prop('disabled', true);
            $.ajax({
                url: '<?php echo base_url();?>index.php/CapturasController/obtenerCapturaDispositivoCanal',
                type: 'post',
                data:{organizacion: organizacion, dispositivo: dispositivo, canal: canal},
                dataType: 'text',
                success: function(response){
                    if(response == '2'){
                        img_captura.attr('src', '<?php echo base_url();?>assets/img/imagen_no_encontrada.jpg');
                    }
                    else{
                        img_captura.attr('src', '<?php echo base_url();?>assets/imagenes_capturadas/'+response);
                        nombre_imagen = response;
                    }
                    $('#btnCapturar').prop('disabled', false);
                }
            });
        }

        function actualizar(){
            location.reload();
        }

        function guardarCaptura(){
            let organizacion = $('#select-organizacion').val();
            let dispositivo = $('#select-dispositivo').val();
            let canal = $('#select-canal').val();
            let observacion = $('#area-observacion').val();
            let consolidado = ($('#input-consolidado').is(':checked') == true) ? 1 : 0;

            alert(1);

            if(canal == ''){
                alert('Debe selecciona un canal');
                return false;
            }
            
            $.ajax({
                url: '<?php echo base_url();?>index.php/CapturasController/addCaptura',
                type: 'post',
                dataType: 'text',
                data: {organizacion: organizacion, dispositivo: dispositivo, canal: canal, observacion: observacion, 
                        consolidado: consolidado},
                success: function(response){
                    if(confirm('Se ha guardado de manera correcta la captura. ¿Desea volver a realizar otra Captura?')){
                        location.reload();
                    }
                    else{
                        window.location.href = '<?php echo base_url();?>index.php/CapturasController';
                    }
                }
            });
        }

        function borrar(){
            $('#area-observacion').val('');
        }

        function abrirGrande(src){
            $('#img-expandir').attr('src', src);
            $('#modal-captura').modal('show');
        }

        function subirImagen() {
            let organizacion = $('#select-organizacion').val();
            let dispositivo = $('#select-dispositivo').val();
            let canal = $('#select-canal').val();
            if(canal == ''){
                alert('Debe selecciona un canal');
                return false;
            }

            if(document.getElementById('imagen').files.length === 0){
                alert('Debe seleccionar una imagen');
                return false;
            }

            var formData = new FormData($("#formularioImagen")[0]);

            formData.append('org', organizacion);
            formData.append('dev', dispositivo);
            formData.append('canal', canal);

            $.ajax({
                url: '<?php echo base_url();?>index.php/CapturasController/subirImagen',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if(response['codigo'] == '1'){
                        img_captura.attr('src', '<?php echo base_url();?>assets/imagenes_capturadas/'+response['imagen']);
                        nombre_imagen = response['imagen'];
                    }
                    else{
                        alert('Error: '+response['imagen']);
                    }
                },
                error: function(error) {
                    alert('Error: '+error);
                }
            });
        }
    </script>
</body>
</html>