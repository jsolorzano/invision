<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Transacción </h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url() ?>home">Inicio</a>
            </li>
            
            <li>
                <a href="<?php echo base_url() ?>transactions">Transacciones</a>
            </li>
            
            <li class="active">
                <strong>
				<?php
				if($this->uri->segment(3) == 1){
					echo "Agregar Fondo Personal";
				}else if($this->uri->segment(3) == 2){
					echo "Retirar Fondo Personal";
				}else{
					echo "Sólo puede agregar o retirar fondos";
				}	
				?>
				</strong>
            </li>
        </ol>
    </div>
</div>

<!-- Campos ocultos que almacenan el tipo de moneda de la cuenta del usuario logueado -->
<input type="hidden" id="iso_currency_user" value="<?php echo $this->session->userdata('logged_in')['coin_iso']; ?>">
<input type="hidden" id="symbol_currency_user" value="<?php echo $this->session->userdata('logged_in')['coin_symbol']; ?>">

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
        <div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>
					<?php
					if($this->uri->segment(3) == 1){
						echo "Agregar Fondo Personal";
					}else if($this->uri->segment(3) == 2){
						echo "Retirar Fondo Personal";
					}else{
						echo "Sólo puede agregar o retirar fondos";
					}	
					?>
					</h5>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<label style="color:red;">
						(Capital aprobado: <span id="span_capital_aprobado"></span>
						<?php echo $this->session->userdata('logged_in')['coin_symbol']; ?>)
						
					</label>
					
				</div>
				<div class="ibox-content">
					<form id="form_transactions" method="post" accept-charset="utf-8" class="form-horizontal">
						<div class="form-group">
							<input type="hidden" class="form-control" name="type" id="type" value="<?php echo $this->uri->segment(3); ?>"/>
						</div>
						<!-- Si el usuario es administrador, entonces puede elegir el usuario -->
						<?php if($this->session->userdata('logged_in')['id'] == 1){ ?>
						<div class="form-group">
							<label class="col-sm-2 control-label" >Usuario *</label>
							<div class="col-sm-10">
								<select class="form-control m-b" name="user_id" id="user_id">
									<option value="0">Seleccione</option>
									<?php foreach($usuarios as $usuario){?>
									<option value="<?php echo $usuario->id; ?>"><?php echo $usuario->username; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<?php } ?>
						<!-- Fin validación -->
						<div class="form-group">
							<label class="col-sm-2 control-label" >Cuenta *</label>
							<div class="col-sm-10">
								<select class="form-control m-b" name="cuenta_id" id="cuenta_id">
									<option value="0">Seleccione</option>
									<?php foreach($cuentas as $cuenta){?>
									<option value="<?php echo $cuenta->id; ?>"><?php echo $cuenta->alias." - ".$cuenta->number." - ".$cuenta->coin_avr; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group"><label class="col-sm-2 control-label" >Fecha</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="date" maxlength="19" id="date" style="width:30%"/>
							</div>
						</div>
						<div class="form-group"><label class="col-sm-2 control-label" >Descripción</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="description" maxlength="250" id="description"/>
							</div>
						</div>
						<div class="form-group"><label class="col-sm-2 control-label" >Referencia</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="reference" maxlength="100" id="reference"/>
							</div>
						</div>
						<div class="form-group"><label class="col-sm-2 control-label" >Observaciones</label>
							<div class="col-sm-10">
								<textarea class="form-control" name="observation" maxlength="250" id="observation"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Monto *</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" maxlength="11" name="monto" id="monto">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Documento</label>
							<div class="col-sm-4">
								<input type="file" class="form-control" name="document[]" id="document" onChange="valida_tipo($(this))">
							</div>
							<div class="col-sm-6">
								<img id="imgSalida" style="height:150px;width:150px;" class="img-circle" src="<?php echo base_url(); ?>assets/img/users/usuario.jpg">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-4 col-sm-offset-2">
								<input id="usuario" type="hidden" value="<?php echo $this->session->userdata('logged_in')['id']; ?>"/>
								<button class="btn btn-white" id="volver" type="button">Volver</button>
								<button class="btn btn-primary" id="registrar" type="submit">Guardar</button>
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
        url = '<?php echo base_url() ?>transactions/';
        window.location = url;
    });
	
	//~ $('#date').datepicker({
        //~ format: "dd/mm/yyyy",
        //~ language: "es",
        //~ autoclose: true,
        //~ endDate: 'today'
    //~ });
    
	$.datetimepicker.setLocale('es');
	$('#date').datetimepicker({
	  format:'d/m/Y H:i:s'
	});
    
    // Función para la pre-visualización de la imagen a cargar
	$(function() {
		$('#document').change(function(e) {
			addImage(e); 
		});

		function addImage(e){
			var file = e.target.files[0],
			imageType = /image.*/;

			if (!file.type.match(imageType))
			return;

			var reader = new FileReader();
			reader.onload = fileOnload;
			reader.readAsDataURL(file);
		}
	  
		function fileOnload(e) {
			var result=e.target.result;
			$('#imgSalida').attr("src",result);
		}
	});
    
    $("#monto").numeric(); // Sólo permite valores numéricos
    
    var capital_pendiente = 0;
	var capital_aprobado = 0;
    // Proceso de conversión de monedas de los distintos montos a la moneda del usuario logueado (captura del equivalente a 1 dólar en las distintas monedas)
    $.post('https://openexchangerates.org/api/latest.json?app_id=65148900f9c2443ab8918accd8c51664', function (coins) {
		
		var currency_user = coins['rates'][$("#iso_currency_user").val()];  // Tipo de moneda del usuario logueado
		
		// Proceso de cálculo de capital aprobado y pendiente
		$.post('<?php echo base_url(); ?>dashboard/fondos_json', function (fondos) {
			
			$.each(fondos, function (i) {
				
				// Conversión de cada monto a dólares
				var currency = fondos[i]['coin_avr'];  // Tipo de moneda de la transacción
				var trans_usd = parseFloat(fondos[i]['monto'])/coins['rates'][currency];
				
				// Sumamos o restamos dependiendo del tipo de transacción (ingreso/egreso)
				if(fondos[i]['status'] == 'waiting'){
					if(fondos[i]['tipo'] == 'deposit'){
						capital_pendiente += trans_usd;
					}else{
						capital_pendiente -= trans_usd;
					}
				}
				if(fondos[i]['status'] == 'approved'){
					if(fondos[i]['tipo'] == 'deposit'){
						capital_aprobado += trans_usd;
					}else{
						capital_aprobado -= trans_usd;
					}
				}
			});
			
			capital_aprobado = (capital_aprobado*currency_user).toFixed(2);
			
			capital_pendiente = (capital_pendiente*currency_user).toFixed(2);
			
			$("#span_capital_aprobado").text(capital_aprobado);
			
		}, 'json');
		
	}, 'json');
	
	
	// Proceso de validación del registro
    $("#registrar").click(function (e) {

        e.preventDefault();  // Para evitar que se envíe por defecto

        if ($('#user_id').val() == "0") {
			
			swal("Disculpe,", "para continuar debe seleccionar el usuario");
			$('#user_id').focus();
			$('#user_id').parent('div').addClass('has-error');
			
        } else if ($('#cuenta_id').val() == "0") {
			
			swal("Disculpe,", "para continuar debe seleccionar la cuenta");
			$('#cuenta_id').focus();
			$('#cuenta_id').parent('div').addClass('has-error');
			
        } else if ($('#date').val().trim() === ""){
			
			swal("Disculpe,", "para continuar debe ingresar la fecha");
			$('#date').focus();
			$('#date').parent('div').addClass('has-error');
			
		} else if ($('#monto').val().trim() === ""){
			
			swal("Disculpe,", "para continuar debe ingresar el monto");
			$('#monto').focus();
			$('#monto').parent('div').addClass('has-error');
			
		} else {
			
			var monto_convertido;
	
			$.post('https://openexchangerates.org/api/latest.json?app_id=65148900f9c2443ab8918accd8c51664', function (coins) {
		
				var currency_user = coins['rates'][$("#iso_currency_user").val()];  // Tipo de moneda del usuario logueado
				
				// Conversión de cada monto a dólares
				var currency = $("#cuenta_id").find('option').filter(':selected').text();  // Tipo de moneda de la cuenta
				currency = currency.split(' - ');
				currency = currency[2];
				//~ alert(currency);
				var trans_usd = parseFloat($('#monto').val().trim())/coins['rates'][currency];
				//~ alert(trans_usd);
				
				monto_convertido = trans_usd;
					
				monto_convertido = (monto_convertido*currency_user).toFixed(2);
				
			}, 'json').done(function() {
				
				//~ alert("Monto convertido: " + monto_convertido);
				//~ alert("Capital aprobado: " + capital_aprobado);
				
				if(monto_convertido > capital_aprobado && $('#tipo').val().trim() == 'withdraw' && $("#usuario").val().trim() != 1){
					
					alert("El monto a retirar no puede ser superior al capital aprobado");
					
				}else{
					
					//~ $.post('<?php echo base_url(); ?>CFondoPersonal/add', $('#form_transactions').serialize(), function (response) {
						//~ if (response['response'] == 'error') {
							//~ swal("Disculpe,", "El registro no pudo ser guardado, por favor consulte a su administrador...");
						//~ }else{
							//~ swal({ 
								//~ title: "Registro",
								 //~ text: "Guardado con exito",
								  //~ type: "success" 
								//~ },
							//~ function(){
							  //~ window.location.href = '<?php echo base_url(); ?>transactions';
							//~ });
						//~ }
					//~ }, 'json');
					
					var formData = new FormData(document.getElementById("form_transactions"));  // Forma de capturar todos los datos del formulario
			
					$.ajax({
						//~ method: "POST",
						type: "post",
						dataType: "json",
						url: '<?php echo base_url(); ?>CFondoPersonal/add',
						data: formData,
						cache: false,
						contentType: false,
						processData: false
					})
					.done(function(response) {
						if(response.error){
							console.log(response.error);
						} else {
							if (response['response'] == 'error') {
							
								swal("Disculpe,", "El registro no pudo ser guardado, por favor consulte a su administrador...");
								
							}else if (response['response'] == 'error2') {
								
								swal("Disculpe,", "ha ocurrido un error al guardar el documento");
								
							}else{
								
								swal({ 
									title: "Registro",
									 text: "Guardado con exito",
									  type: "success" 
									},
								function(){
								  window.location.href = '<?php echo base_url(); ?>transactions';
								});
								
							}
							
						}				
					}).fail(function() {
						console.log("error ajax");
					});
					
				}
				
			});            
            
        }
    });
});


// Validamos que los archivos sean de tipo .jpg, jpeg, png o pdf
function valida_tipo(input) {
	
	var max_size = '';
	var archivo = input.val();
	
	var ext = archivo.split(".");
	ext = ext[1];
	
	if (ext != 'jpg' && ext != 'jpeg' && ext != 'png' && ext != 'pdf'){
		swal("Disculpe,", "sólo se admiten archivos .jpg, .jpeg, .png y .pdf");
		input.val('');
		input.parent('div').addClass('has-error');
	}else{
		input.parent('div').removeClass('has-error');
	}
}

</script>
