<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Asociación </h2>
        <ol class="breadcrumb">
            <li>
                <a href="index.html">Inicio</a>
            </li>
            
            <li>
                <a href="<?php echo base_url() ?>coins">Asociación</a>
            </li>
           
            <li class="active">
                <strong>Editar Asociación</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
        <div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Editar Asociación <small></small></h5>
				</div>
				<div class="ibox-content">
					<form id="form_relate_users" method="post" accept-charset="utf-8" class="form-horizontal">
						<!-- Si el usuario es administrador, entonces puede elegir el usuario -->
						<?php if($this->session->userdata('logged_in')['id'] == 1){ ?>
						<div class="form-group">
							<label class="col-sm-2 control-label" >Asesor *</label>
							<div class="col-sm-10">
								<select class="form-control m-b" name="adviser_id" id="adviser_id">
									<option value="<?php echo $asesor[0]->id; ?>" selected="selected"><?php echo $asesor[0]->username; ?></option>
								</select>
							</div>
						</div>
						<?php } ?>
						<!-- Fin validación -->
						<div class="form-group">
							<label class="col-sm-2 control-label" >Inversor(es) *</label>
							<div class="col-sm-10">
								<select class="form-control m-b" name="investor_id" id="investor_id" multiple="multiple">
									<!-- Filtramos que se muestre una lista sólo con los inversores que no estén asociados a ningún otro asesor
									o que en su defecto estén asociados al asesor actual, en cuyo caso éstos deben ser marcados como seleccionados -->
									<?php foreach($inversores as $inversor){?>
										<?php if(!in_array($inversor->id, $asociaciones_generales)){?>
											<?php if(in_array($inversor->id, $inversores_asociados)){?>
											<option value="<?php echo $inversor->id; ?>" selected="selected"><?php echo $inversor->username; ?></option>
											<?php }else{ ?>
											<option value="<?php echo $inversor->id; ?>"><?php echo $inversor->username; ?></option>
											<?php } ?>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-4 col-sm-offset-2">
								 <input class="form-control"  type='hidden' id="id" name="id" value="<?php echo $id ?>"/>
								<button class="btn btn-white" id="volver" type="button">Volver</button>
								<button class="btn btn-primary" id="edit" type="submit">Guardar</button>
							</div>
						</div>
					</form>
				</div>
			</div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){

    $('input').on({
        keypress: function () {
            $(this).parent('div').removeClass('has-error');
        }
    });

    $('#volver').click(function () {
        url = '<?php echo base_url() ?>relate_users/';
        window.location = url;
    });

    $("#edit").click(function (e) {

        e.preventDefault();  // Para evitar que se envíe por defecto

        if ($('#adviser_id').val() == "0") {
			swal("Disculpe,", "para continuar debe seleccionar el asesor");
			$('#adviser_id').parent('div').addClass('has-error');
			
        } else if ($('#investor_id').val() == "") {
			swal("Disculpe,", "para continuar debe seleccionar el(los) inversor(es)");
			$('#investor_id').parent('div').addClass('has-error');
			
        } else {

            $.post('<?php echo base_url(); ?>CRelateUsers/update', $('#form_relate_users').serialize()+'&'+$.param({'inversores':$('#investor_id').val()}), function (response) {
				if (response['response'] == 'error') {
                    swal("Disculpe,", "Los datos no pudieron ser actualizados, por favor consulte a su administrador...");
                }else{
					swal({ 
						title: "Registro",
						 text: "Guardado con exito",
						  type: "success" 
						},
					function(){
					  window.location.href = '<?php echo base_url(); ?>relate_users';
					});
				}
            }, 'json');
            
        }
        
    });
    
});

</script>
