<!-- FooTable -->
<link href="<?php echo assets_url('css/plugins/footable/footable.bootstrap.css');?>" rel="stylesheet">

<style>
.views-number {
    font-size: 22px !important;
}
</style>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Resumen financiero</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url() ?>home">Inicio</a>
            </li>
            <li class="active">
                <strong>Resumen financiero</strong>
            </li>
        </ol>
    </div>
</div>

<!-- Campo oculto que almacena el url base del proyecto -->
<input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
<!-- Campos ocultos que almacenan el tipo de moneda de la cuenta del usuario logueado -->
<input type="hidden" id="iso_currency_user" value="<?php echo $this->session->userdata('logged_in')['coin_iso']; ?>">
<input type="hidden" id="symbol_currency_user" value="<?php echo $this->session->userdata('logged_in')['coin_symbol']; ?>">
<input type="hidden" id="decimals_currency_user" value="<?php echo $this->session->userdata('logged_in')['coin_decimals']; ?>">

<div class="wrapper wrapper-content animated fadeInUp">
	
	<!-- Cuerpo de la sección de cintillo de montos -->
	<div class="row">
		<div class="col-lg-12">
			<div class="contact-box">
				
				<div class="contact-box-footer" style="border-top:0px;">
					<div>
						<div class="col-md-2 forum-info">
							<span class="views-number">
								<?php echo $fondo_proyectos->capital_invested; ?>
							</span>
							<div>
								<small>Capital invertido</small>
							</div>
						</div>
						<div class="col-md-2 forum-info">
							<span class="views-number" id="span_invertido">
								<?php echo $fondo_proyectos->returned_capital; ?>
							</span>
							<div>
								<small>Capital de retorno</small>
							</div>
						</div>
						<div class="col-md-2 forum-info">
							<span class="views-number" id="span_retornado">
								<?php echo $fondo_proyectos->retirement_capital_available; ?>
							</span>
							<div>
								<small>Capital de retiro disponible</small>
							</div>
						</div>
						<div class="col-md-2 forum-info">
							<span class="views-number" id="span_aprobado">
								<?php echo $fondo_resumen->approved_capital; ?>
							</span>
							<div>
								<small>Capital aprobado</small>
							</div>
						</div>
						<div class="col-md-2 forum-info">
							<span class="views-number" id="span_ingreso_pendiente">
								<?php echo $fondo_resumen->pending_entry; ?>
							</span>
							<div>
								<small>Depósito Pendiente</small>
							</div>
						</div>
						<div class="col-md-2 forum-info">
							<span class="views-number" id="span_egreso_pendiente">
								<?php echo $fondo_resumen->pending_exit; ?>
							</span>
							<div>
								<small>Capital Diferido</small>
							</div>
						</div>
					</div>
					<br>
					<br>
				</div>
			</div>
		</div>
	</div>
	<!-- Cierre del cuerpo de la sección de cintillo de montos -->
	
	<?php 
	// Ids de los perfiles que tendrań permisos de visualización
	$global_profiles = array(1, 2);
	?>
	
	<?php if(in_array($this->session->userdata('logged_in')['profile_id'], $global_profiles)){?>
	<!-- Cuerpo de la sección de cuentas -->
	<div class="ibox">
		<div class="ibox-title">
			<h5>Cuentas</h5>
		</div>
		<div class="ibox-content">

			<div class="project-list">
				
				<div class="table-responsive">
					<table id="tab_transactions" data-paging="true" class="table table-striped table-bordered dt-responsive table-hover footable toggle-arrow-tiny">
						<thead>
							<tr>
								<th>#</th>
								<th data-breakpoints="xs sm" >Cuenta</th>
								<th >Número</th>
								<th data-breakpoints="xs sm" >Tipo</th>
								<th data-breakpoints="xs sm" >Monto</th>
								<th data-breakpoints="xs sm" >Estatus</th>
								<th data-breakpoints="all">Descripción</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1; ?>
							<?php foreach ($cuentas as $cuenta) { ?>
								<tr style="text-align: center">
									<td>
										<?php echo $i; ?>
									</td>
									<td>
										<?php echo $cuenta->alias; ?>
									</td>
									<td>
										<?php echo $cuenta->number; ?>
									</td>
									<td>
										<?php echo $cuenta->tipo_cuenta; ?>
									</td>
									<td>
										<?php echo $cuenta->amount."  ".$cuenta->coin_symbol."  (".$cuenta->coin_avr.")"; ?>
									</td>
									<td>
										<?php
										if($cuenta->status == 1){
											echo "<span style='color:#337AB7;'>Activa</span>";
										}else if($cuenta->status == 0){
											echo "<span style='color:#D33333;'>Inactiva</span>";
										}else{
											echo "";
										}
										?>
									</td>
									<td>
										<?php echo $cuenta->description; ?>
									</td>
								</tr>
								<?php $i++ ?>
							<?php } ?>
						</tbody>
					</table>					
				</div>
				
			</div>
		</div>
	</div>
	<!-- Cierre del cuerpo de la sección de cuentas -->
	<?php } ?>
	
	<?php 
	// Ids de los perfiles que tendrań permisos de visualización
	$global_profiles = array(1, 2, 4);
	?>
	
	<?php if(in_array($this->session->userdata('logged_in')['profile_id'], $global_profiles)){?>
	<!-- Cuerpo de la sección de resumen por usuario -->
	<div class="ibox">
		<div class="ibox-title">
			<h5>Resumen por usuario</h5>
		</div>
		<div class="ibox-content">

			<div class="project-list">
				
				<div class="table-responsive">
					<?php //~ print_r($fondo_usuarios);	?>
					<table id="tab_transactions" data-paging="true" class="table table-striped table-bordered dt-responsive table-hover footable toggle-arrow-tiny">
						<thead>
							<tr>
								<th>#</th>
								<th data-breakpoints="xs sm" >Nombre</th>
								<th data-breakpoints="xs sm" >Alias</th>
								<th >Usuario</th>
								<!--<th data-breakpoints="xs sm" >Capital Pendiente</th>-->
								<th data-breakpoints="xs sm" >Capital Invertido</th>
								<th data-breakpoints="xs sm" >Capital Retornado</th>
								<th data-breakpoints="xs sm" >Capital Aprobado</th>
								<th data-breakpoints="xs sm" >Depósito Pendiente</th>
								<th data-breakpoints="xs sm" >Capital Diferido</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1; ?>
							<?php foreach ($fondo_usuarios as $fondo) { ?>
								<tr style="text-align: center">
									<td>
										<?php echo $i; ?>
									</td>
									<td>
										<?php echo $fondo->name; ?>
									</td>
									<td>
										<?php echo $fondo->alias; ?>
									</td>
									<td>
										<?php echo $fondo->username; ?>
									</td>
									<!--<td>
										<?php //echo $fondo->pending_capital; ?>
									</td>-->
									<td>
										<?php echo $fondo->capital_invested; ?>
									</td>
									<td>
										<?php echo $fondo->returned_capital; ?>
									</td>
									<td>
										<?php echo $fondo->approved_capital; ?>
									</td>
									<td>
										<?php echo $fondo->pending_entry; ?>
									</td>
									<td>
										<?php echo $fondo->pending_exit; ?>
									</td>
								</tr>
								<?php $i++ ?>
							<?php } ?>
						</tbody>
					</table>					
				</div>
				
			</div>
		</div>
	</div>
	<!-- Cierre del cuerpo de la sección de resume por usuario -->
	<?php } ?>
	
	<!-- Cuerpo de la sección de transacciones asociadas -->
	<div class="ibox">
		<div class="ibox-title">
			<h5>Transacciones</h5>
			<!--<div class="ibox-tools">
				<a class="btn btn-primary btn-xs" id="boton_vincular">
				Crear nuevo perfil social
				</a>
			</div>-->
		</div>
		<div class="ibox-content">

			<div class="project-list">
				
				<div class="table-responsive">
					<?php $filter_profile = array(1, 2, 4); ?>
					<table id="tab_transactions" <?php if(in_array($this->session->userdata('logged_in')['profile_id'], $filter_profile)){ echo "data-filtering='true'"; } ?> data-paging="true" class="table table-striped table-bordered dt-responsive table-hover footable toggle-arrow-tiny">
						<thead>
							<tr>
								<th>#</th>
								<th >Usuario</th>
								<th data-breakpoints="xs sm" >Tipo</th>
								<th data-breakpoints="xs sm" >Monto</th>
								<th data-breakpoints="xs sm" >Estatus</th>
								<th data-breakpoints="all" >Cuenta</th>
								<th data-breakpoints="all" >Descripción</th>
								<th data-breakpoints="all" >Referencia</th>
								<th data-breakpoints="all" >Observaciones</th>
								<!--<th>Validar</th>-->
							</tr>
						</thead>
						<tbody>
							<?php $i = 1; ?>
							<?php foreach ($listar as $fondo) { ?>
								<tr style="text-align: center">
									<td>
										<?php echo $i; ?>
									</td>
									<td>
										<?php echo $fondo->usuario; ?>
									</td>
									<td>
										<?php
										if($fondo->type == 'deposit'){
											echo "<span style='color:#337AB7;'>Ingreso</span>";
										}else if($fondo->type == 'withdraw'){
											echo "<span style='color:#D33333;'>Egreso</span>";
										}else{
											echo "";
										}
										?>
									</td>
									<td>
										<?php echo $fondo->monto."  ".$fondo->coin_symbol."  (".$fondo->coin_avr.")"; ?>
									</td>
									<td>
										<?php
										if($fondo->status == 'approved'){
											echo "<span style='color:#337AB7;'>Validado</span>";
										}else if($fondo->status == 'waiting'){
											echo "<span style='color:#A5D353;'>En espera</span>";
										}else{
											echo "<span style='color:#D33333;'>Denegado</span>";
										}
										?>
									</td>
									<td>
										<?php echo $fondo->alias." - ".$fondo->number; ?>
									</td>
									<td>
										<?php echo $fondo->description; ?>
									</td>
									<td>
										<?php echo $fondo->reference; ?>
									</td>
									<td>
										<?php echo $fondo->observation; ?>
									</td>
									<!--<td style='text-align: center'>
										<?php
										$class = "";
										$class_icon_validar = "";
										$disabled = "";
										$cursor_style = "";
										$color_style = "";
										$title = "";
										if($fondo->status == 'approved'){
											$class_icon_validar = "fa-check-circle";
											$disabled = "disabled='true'";
											$cursor_style = "cursor:default";
											$color_style = "";
											$title = "";
										}else if($fondo->status == 'waiting'){
											$class = "validar";
											$class_icon_validar = "fa-check-circle-o";
											$cursor_style = "cursor:pointer";
											$color_style = "";
											$title = "title='Validar'";
										}else{
											$class_icon_validar = "fa-check-circle";
											$disabled = "disabled='true'";
											$cursor_style = "cursor:default";
											$color_style = "color:grey";
											$title = "";
										}
										?>
										<a class='<?php echo $class; ?>' id='<?php echo $fondo->id.';'.$fondo->cuenta_id.';'.$fondo->monto.';'.$fondo->tipo; ?>' <?php echo $disabled; ?> style='<?php echo $cursor_style; ?>;<?php echo $color_style; ?>' <?php echo $title; ?>>
											<i class="fa <?php echo $class_icon_validar; ?> fa-2x"></i>
										</a>
									</td>-->
								</tr>
								<?php $i++ ?>
							<?php } ?>
						</tbody>
					</table>					
				</div>
				
			</div>
		</div>
	</div>
	<!-- Cierre del cuerpo de la sección de transacciones asociadas -->
	
</div>

<!-- FooTable -->
<script src="<?php echo assets_url('js/plugins/footable/footable.js');?>"></script>

<!-- Page-Level Scripts -->
<script src="<?php echo assets_url(); ?>script/resumen.js"></script>
