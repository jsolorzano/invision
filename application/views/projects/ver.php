<style>
.ibox-content {
    background-color: #ffffff;
    color: inherit;
    padding: 15px 20px 20px 20px;
    border-color: #e7eaec;
    border-image: none;
    border-style: solid solid solid;
    border-width: 1px 1px 1px 1px;
}
</style>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Project detail </h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url() ?>home">Home</a>
            </li>
            
            <li>
                <a href="<?php echo base_url() ?>projects">Projects</a>
            </li>
           
            <li class="active">
                <strong>Project detail</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInUp">
	
	<div class="row">
		
		<div class="col-lg-9">
			<div class="wrapper wrapper-content animated fadeInUp">
				<div class="ibox">
					<div class="ibox-content">
						
						<div class="row">
							<div class="col-lg-12">
								<div class="m-b-md">
									<a href="<?php echo base_url() ?>projects/edit/<?= $ver[0]->id; ?>" class="btn btn-white btn-xs pull-right">Edit project</a>
									<h2><?php echo $ver[0]->name; ?></h2>
								</div>
								<dl class="dl-horizontal">
									<dt>Status:</dt> 
									<dd>
									<?php if($ver[0]->status == 1) { ?>
									<span class="label label-primary">Active</span>
									<?php }else{ ?>
									<span class="label label-default">Inactive</span>
									<?php } ?>
									</dd>
								</dl>
							</div>
						</div>
						
						<div class="row">
							<div class="col-lg-5">
								<dl class="dl-horizontal">
									<dt>Created by:</dt> <dd><?php echo $ver[0]->username; ?></dd>
									<dt>Invest:</dt> <dd>  <?php echo count($investors); ?></dd>
								</dl>
							</div>
							<div class="col-lg-7" id="cluster_info">
								<dl class="dl-horizontal" >
									<dt>Last Updated:</dt> <dd><?php echo $ver[0]->d_update; ?></dd>
									<dt>Created:</dt> <dd> 	<?php echo $ver[0]->d_create; ?> </dd>
								</dl>
							</div>
						</div>
						
						<div class="row">
							<div class="col-lg-12">
								<dl class="dl-horizontal" >
									<dt></dt>
									<dd class="project-people">
									<a href=""><img class="img-circle" src="img/a3.jpg"></a>
									<a href=""><img class="img-circle" src="img/a1.jpg"></a>
									<a href=""><img class="img-circle" src="img/a2.jpg"></a>
									<a href=""><img class="img-circle" src="img/a4.jpg"></a>
									<a href=""><img class="img-circle" src="img/a5.jpg"></a>
									</dd>
								</dl>
							</div>
						</div>
						
						<div class="row">
							<div class="col-lg-12">
								<dl class="dl-horizontal">
									<dt>Completed:</dt>
									<dd>
										<?php 
										if($ver[0]->amount_r == null){
											echo "&infin;";
											$percentage = 0;
										}else{
											if($porcentaje_r > 0){
												echo round($porcentaje_r, 2)."%";
												$percentage = round($porcentaje_r, 2);
											}else{
												echo "0%";
												$percentage = 0;
											}
										}
										?>
										<div class="progress progress-striped active m-b-sm">
											<div style="width: <?php echo $percentage; ?>%;" class="progress-bar"></div>
										</div>
										
										<small>Project completed in <strong><?php echo $percentage; ?>%</strong>. Remaining close the project, sign a contract and invoice.</small>
									</dd>
								</dl>
							</div>
						</div>
						
						<div class="row m-t-sm">
							
							<div class="col-lg-12">
								
								<div class="col-lg-4">
									<div class="ibox">
										<div class="ibox-content">
											<h5>Capital Invertido</h5>
											<h1 class="no-margins">1 738,200</h1>
											<div class="stat-percent font-bold text-navy">98% <i class="fa fa-bolt"></i></div>
											<small>Total income</small>
										</div>
									</div>
								</div>
								<div class="col-lg-4">
									<div class="ibox">
										<div class="ibox-content">
											<h5>Dividendo</h5>
											<h1 class="no-margins">-200,100</h1>
											<div class="stat-percent font-bold text-danger">12% <i class="fa fa-level-down"></i></div>
											<small>Total income</small>
										</div>
									</div>
								</div>
								<div class="col-lg-4">
									<div class="ibox">
										<div class="ibox-content">
											<h5>Capital de retiro disponible</h5>
											<h1 class="no-margins">54,200</h1>
											<div class="stat-percent font-bold text-danger">24% <i class="fa fa-level-down"></i></div>
											<small>Total income</small>
										</div>
									</div>
								</div>
								
							</div>
							
						</div>
						
					</div>
					
				</div>
				
			</div>
			
		</div>
		
		<div class="col-lg-3">
			<div class="wrapper wrapper-content project-manager">
				<h4>Project description</h4>
				<!--<img src="img/zender_logo.png" class="img-responsive">-->
				<p class="small">
					<?php echo $ver[0]->description; ?>
				</p>
				<!--<p class="small font-bold">
					<span><i class="fa fa-circle text-warning"></i> High priority</span>
				</p>
				<h5>Project tag</h5>
				<ul class="tag-list" style="padding: 0">
					<li><a href=""><i class="fa fa-tag"></i> Zender</a></li>
					<li><a href=""><i class="fa fa-tag"></i> Lorem ipsum</a></li>
					<li><a href=""><i class="fa fa-tag"></i> Passages</a></li>
					<li><a href=""><i class="fa fa-tag"></i> Variations</a></li>
				</ul>-->
				<h5>Project documents</h5>
				<ul class="list-unstyled project-files">
					<?php foreach($documentos_asociados as $doc){ ?>
					<li>
						<a target="_blank" href="<?php echo base_url(); ?>assets/documents/<?php echo $doc->description; ?>">
							<i class="fa fa-file"></i> <?php echo $doc->description; ?>
						</a>
					</li>
					<?php } ?>
				</ul>
				<h5>Project readings</h5>
				<ul class="list-unstyled project-files">
					<?php foreach($lecturas_asociadas as $reading){ ?>
					<li>
						<a target="_blank" href="<?php echo base_url(); ?>assets/readings/<?php echo $reading->description; ?>">
							<i class="fa fa-file"></i> <?php echo $reading->description; ?>
						</a>
					</li>
					<?php } ?>
				</ul>
				<!--<div class="text-center m-t-md">
					<a href="#" class="btn btn-xs btn-primary">Add files</a>
					<a href="#" class="btn btn-xs btn-primary">Report contact</a>

				</div>-->
			</div>
		</div>	
		
	</div>

	<!-- Cuerpo de la sección de transacciones -->
	<div class="ibox">
		<div class="ibox-title">
			<h5>Transactions</h5>
		</div>
		<div class="ibox-content">

			<div class="project-list">
				
				<div class="table-responsive">
					<table id="tab_transactions" data-paging="true" class="table table-striped table-bordered dt-responsive table-hover footable toggle-arrow-tiny">
						<thead>
							<tr>
								<th data-breakpoints="xs sm" >Fecha</th>
								<th>Usuario(nombre)</th>
								<th data-breakpoints="xs sm" >Tipo</th>
								<th data-breakpoints="all" >Descripción</th>
								<th>Monto</th>
								<th data-breakpoints="xs sm">Estatus</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1; ?>
							<?php foreach ($project_transactions as $transact) { ?>
								<tr style="text-align: center">
									<td>
										<?php echo $transact->fecha; ?>
									</td>
									<td>
										<?php echo $transact->username; ?>
									</td>
									<td>
										<?php echo $transact->tipo; ?>
									</td>
									<td>
										<?php echo $transact->descripcion; ?>
									</td>
									<td>
										<?php echo $transact->monto; ?>
									</td>
									<td>
										<?php
										if($transact->status == "approved"){
											echo "<span style='color:#337AB7;'>Activa</span>";
										}else if($transact->status == "waiting"){
											echo "<span style='color:#D33333;'>Inactiva</span>";
										}else{
											echo "";
										}
										?>
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
	<!-- Cierre del cuerpo de la sección de transacciones -->

	<!-- Cuerpo de la sección de transacciones -->
	<div class="ibox">
		<div class="ibox-title">
			<h5>Transactions</h5>
		</div>
		<div class="ibox-content">

			<div class="project-list">
				
				<div class="table-responsive">
					<table id="tab_transactions" data-paging="true" class="table table-striped table-bordered dt-responsive table-hover footable toggle-arrow-tiny">
						<thead>
							<tr>
								<th data-breakpoints="xs sm" >Fecha</th>
								<th>Usuario(nombre)</th>
								<th data-breakpoints="xs sm" >Tipo</th>
								<th data-breakpoints="all" >Descripción</th>
								<th>Monto</th>
								<th data-breakpoints="xs sm">Estatus</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1; ?>
							<?php foreach ($project_transactions as $transact) { ?>
								<tr style="text-align: center">
									<td>
										<?php echo $transact->fecha; ?>
									</td>
									<td>
										<?php echo $transact->username; ?>
									</td>
									<td>
										<?php echo $transact->tipo; ?>
									</td>
									<td>
										<?php echo $transact->descripcion; ?>
									</td>
									<td>
										<?php echo $transact->monto; ?>
									</td>
									<td>
										<?php
										if($transact->status == 1){
											echo "<span style='color:#337AB7;'>Activa</span>";
										}else if($transact->status == 0){
											echo "<span style='color:#D33333;'>Inactiva</span>";
										}else{
											echo "";
										}
										?>
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

</div>
<!-- Cierre del cuerpo de la sección de transacciones -->

<script>
$(document).ready(function(){

    
	
});

</script>