<!-- ================================================== VIEW ================================================== -->
<?php if ($action == 'view' || empty($action)){ ?>
	<div class="page">
		<div class="page-title blue">
			<h3>
				<?php echo $breadcrumb; ?>
			</h3>
			<p>Information About
				<?php echo $breadcrumb; ?>
			</p>
		</div>
		<div class="page-content container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="panel rounded-0">
						<div class="panel-heading">
							<h5 class="panel-title">View Data
								<?php echo $breadcrumb; ?>
							</h5>
						</div>
						<!-- ========== Flashdata ========== -->
						<?php if ($this->session->flashdata('success') || $this->session->flashdata('warning') || $this->session->flashdata('error')) { ?>
						<?php if ($this->session->flashdata('success')) { ?>
						<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<i class="fa fa-check sign"></i>
							<?php echo $this->session->flashdata('success'); ?>
						</div>
						<?php } else if ($this->session->flashdata('warning')) { ?>
						<div class="alert alert-warning">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<i class="fa fa-check sign"></i>
							<?php echo $this->session->flashdata('warning'); ?>
						</div>
						<?php } else { ?>
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<i class="fa fa-warning sign"></i>
							<?php echo $this->session->flashdata('error'); ?>
						</div>
						<?php } ?>
						<?php } ?>
						<!-- ========== End Flashdata ========== -->
						<div class="panel-body container-fluid table-detail">
							<div class="table-full table-view">
								<div class="navigation-btn">
									<form action="" method="post" id="form">
										<div class='row margin-bottom'>
											<div class='btn-search'>Search By :</div>
											<div class='col-md-3 col-sm-12'>
												<div class='button-search'>
													<?php array_pilihan('cari', $berdasarkan, $cari);?>
												</div>
											</div>
											<div class='col-md-3 col-sm-12 select-search'>
                                            <div class="input-group">
                                                <input type="text" name="q" class="form-control" value="<?php echo $q;?>" />
                                                <span class="input-group-btn">
							                        <button type="submit" name="kirim" class="btn btn-success" type="button">
							                            <i class="fa fa-search"></i>
							                        </button>
							                    </span>
                                            </div>
                                        </div>
										</div>
										<div class='btn-navigation'>
											<div class='pull-right'>
												<a class="btn btn-success" href="<?php echo site_url();?>website/feeding"><i class="fa fa-refresh"></i></a>
											</div>
										</div>
									</form>
								</div>
								<div class="table-responsive">
									<table class="table table-hover table-striped table-bordered">
										<thead>
											<th width=80>#</th>
											<th width=120>Goods</th>
											<th width=160>Distributors</th>
											<th width=80 class="text-center">Total</th>
											<th width=270>Date</th>
                            <?php if ($admin->admin_level_kode == 1) { ?>
											<th class="text-center">Action</th>
							<?php } ?>
										</thead>
										<tbody>
											<?php 
									$i	= $page+1;
									$like_feeding[$cari]			= $q;
								if ($jml_data > 0){
									foreach ($this->ADM->grid_all_feeding('', 'feeding_created', 'DESC', $batas, $page, '', $like_feeding) as $row){
									?>
											<tr>
												<td>
													<?php echo $i; ?>
												</td>
												<td>
												<?php 
									$where_barang['id_barang'] 	= $row->id_barang;
									foreach ($this->ADM->grid_all_barang('', 'id_barang', 'DESC', 100, '', $where_barang, '') as $row2){ ?>
									<b>Name: <?php echo $row2->nama_barang;?></b> <br>
									Brand: <?php echo $row2->merek;?>
									<?php } ?>
												</td>
												<td>
									<?php 
									$where_feeds['id_feeds'] 	= $row->id_feeds;
									foreach ($this->ADM->grid_all_feeds('', 'id_feeds', 'DESC', 100, '', $where_feeds, '') as $row3){ ?>
									 <?php echo $row3->nama_feeds;?>
									
									<?php } ?>
												</td>
												<td class="text-center" style="color: red !important">
													<?php echo $row->jumlah;?>
												</td>
												<td>
													<b>Created:</b> <?php echo dateIndo($row->feeding_created);?><br>
													<b>Last Updated:</b> <?php echo dateIndo($row->feeding_updated);?>
									</td>
                            <?php if ($admin->admin_level_kode == 1) { ?>
												<td class="text-center action">
											
													<a class="text-danger" href="javascript:;" data-id="<?php echo $row->id_feeding;?>" data-toggle="modal" data-target="#modal-konfirmasi"
														title="<?php echo $row->id_feeding;?>">
														<i class="icon wb-trash"></i>
													</a>
												</td>
							<?php } ?>
											</tr>
											<?php
										$i++;
									} 
								} else {
									?>
												<tr>
													<td colspan="7">No data yet!</td>
												</tr>
												<?php } ?>
										</tbody>
									</table>
								</div>
								<div class="wrapper">
									<div class="paging">
										<div id='pagination'>
											<div class='pagination-right'>
												<ul class="pagination">
													<?php if ($jml_halaman > 1) { echo pages($halaman, $jml_halaman, 'website/feeding/view', $id=""); }?>
												</ul>
											</div>
										</div>
									</div>
									<div class="total">Total :
										<?php echo $jml_data;?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
                            <?php if ($admin->admin_level_kode == 1) { ?>
		<a href="<?php echo site_url();?>website/feeding/tambah">
			<button class="site-action btn-raised btn btn-sm btn-floating blue" type="button">
				<i class="icon wb-plus" aria-hidden="true"></i>
			</button>
		</a>
							<?php } ?>
	</div>
	<!-- ========== Modal Konfirmasi ========== -->
	<div id="modal-konfirmasi" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Confirmation</h4>
				</div>
	
				<div class="modal-body" style="background:#d9534f;color:#fff">
				Are you sure you want to delete this data?
				</div>
				<div class="modal-footer">
					<a href="javascript:;" class="btn btn-danger" id="hapus-feeding">Yes</a>
					<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
				</div>
			</div>
		</div>
	</div>
	<!-- ========== End Modal Konfirmasi ========== -->
	<!-- ================================================== END VIEW ================================================== -->
	
	<!-- ================================================== TAMBAH ================================================== -->
	<?php } elseif ($action == 'tambah') { ?>
	<div class="page">
		<div class="page-title blue">
			<h3>
				<?php echo $breadcrumb; ?>
			</h3>
			<p>Information About
				<?php echo $breadcrumb; ?>
			</p>
		</div>
		<div class="page-content container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="panel rounded-0">
						<div class="panel-heading">
							<h5 class="panel-title">Add <?php echo $breadcrumb; ?></h5>
						</div>
						<div class="panel-body container-fluid">
							<form action="<?php echo site_url();?>website/feeding/tambah" method="post" id="exampleStandardForm" autocomplete="off">
								<div class="form-group form-material">
								<label class="control-label" for="inputText">Goods</label>
									<select name="id_barang" class="form-control input-sm">
												<?php foreach ($this->ADM->grid_all_barang('', 'id_barang', 'DESC', 100, '', '' , '') as $barang){ ?>
													<option value="<?php echo $barang->id_barang ?>"><?php echo $barang->nama_barang ?></option>
												<?php } ?>
												</select>
								</div>
								<div class="form-group form-material">
									<label class="control-label" for="inputText">Distributor</label>
									<select name="id_feeds" class="form-control input-sm">
									<?php foreach ($this->ADM->grid_all_feeds('', 'id_feeds', 'DESC', 100, '', '' , '') as $feeds){ ?>
										<option value="<?php echo $feeds->id_feeds ?>"><?php echo $feeds->nama_feeds ?></option>
									<?php } ?>
									</select>
								</div>
								<div class="form-group form-material">
									<label class="control-label" for="inputText">Total</label>
									<input type="number" class="form-control input-sm" id="jumlah" name="jumlah" placeholder="Total" required/>
								</div>
								<div class='button center'>
									<input class="btn btn-success btn-sm" type="submit" name="simpan" value="Add Data" id="validateButton2">
									<input class="btn btn-danger btn-sm" type="reset" name="batal" value="Cancel" onclick="location.href='<?php echo site_url(); ?>website/feeding'"
									/>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<a href="<?php echo site_url();?>website/feeding">
			<button class="site-action btn-raised btn btn-sm btn-floating blue" type="button">
				<i class="icon wb-eye" aria-hidden="true"></i>
			</button>
		</a>
	</div>
	<!-- ================================================== END TAMBAH ================================================== -->
	<?php } ?>