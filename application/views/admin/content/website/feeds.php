<!-- ================================================== VIEW ================================================== -->
<?php if ($action == 'view' || empty($action)) { ?>
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
                            <h5 class="panel-title">View
                                <?php echo $breadcrumb; ?> Data
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
                                                    <?php array_pilihan('cari', $berdasarkan, $cari); ?>
                                                </div>
                                            </div>
                                            <div class='col-md-3 col-sm-12 select-search'>
												<div class="input-group">
													<select name="q" class="form-control">
														<?php foreach ($this->ADM->grid_all_feeds('', 'id_feeds', 'DESC', $batas, $page, '', '') as $feeds) { ?>
															<option value="<?php echo $feeds->id_feeds ?>"><?php echo $feeds->nama_feeds ?></option>
														<?php } ?>
													</select>
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
                                                <a class="btn btn-success" href="<?php echo site_url(); ?>website/feeds"><i class="fa fa-refresh"></i></a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped table-bordered">
                                        <thead>
                                            <th width=80>#</th>
                                            <th width=140>Feeds Name</th>
                                            <th width=80 class="text-center">Quantity</th>
                                            <th width=120>Livestock</th>
                                            <th width=270>Date</th>
                                            <?php if ($admin->admin_level_kode == 1) { ?>
                                                <th class="text-center">Action</th>
                                            <?php } ?>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i    = $page + 1;
                                            $like_feeds[$cari]            = $q;
                                            if ($jml_data > 0) {
                                                foreach ($this->ADM->grid_all_feeds('*', 'nama_feeds', 'ASC', $batas, $page, '', $like_feeds) as $row) {
                                            ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $i; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row->nama_feeds; ?>
                                                        </td>

                                                        <td class="text-center" style="color: red !important">
                                                            <?php echo $row->jumlah; ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $where_barang['id_barang']     = $row->id_barang;
                                                            foreach ($this->ADM->grid_all_barang('*', 'id_barang', 'DESC', 100, '', $where_barang, '') as $row2) { ?>
                                                                <b>Name: <?php echo $row2->nama_barang; ?></b> <br>
                                                                Category: <?php echo $row2->merek; ?>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <b>Created:</b> <?php echo dateIndo($row->feeds_created); ?><br>
                                                            <b>Last modified:</b> <?php echo dateIndo($row->feeds_updated); ?>
                                                        </td>
                                                        <?php if ($admin->admin_level_kode == 1) { ?>
                                                            <td class="text-center action">
                                                                <a class="btn-update" href="<?php echo site_url(); ?>website/feeds/edit/<?php echo $row->id_feeds; ?>">
                                                                    <i class="icon wb-pencil"></i>
                                                                </a>
                                                                <a class="text-danger" href="javascript:;" data-id="<?php echo $row->id_feeds; ?>" data-toggle="modal" data-target="#modal-konfirmasi" title="<?php echo $row->nama_feeds; ?>">
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
                                                    <td colspan="6">No data yet!</td>
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
                                                    <?php if ($jml_halaman > 1) {
                                                        echo pages($halaman, $jml_halaman, 'website/feeds/view', $id = "");
                                                    } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="total">Total :
                                        <?php echo $jml_data; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($admin->admin_level_kode == 1) { ?>
            <a href="<?php echo site_url(); ?>website/feeds/tambah">
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
                    <a href="javascript:;" class="btn btn-danger" id="hapus-feeds">Yes</a>
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
                            <form action="<?php echo site_url(); ?>website/feeds/tambah" method="post" id="exampleStandardForm" autocomplete="off">
                                <div class="form-group form-material">
                                    <label class="control-label" for="inputText">Feeds name</label>
                                    <input type="text" value="<?php echo $nama_feeds; ?>" class="form-control input-sm" id="nama_feeds" name="nama_feeds" placeholder="Fedds name" required />
                                </div>
                                <div class="form-group form-material">
                                    <label class="control-label" for="inputText">Quantity</label>
                                    <input type="number" value="<?php echo $jumlah; ?>" class="form-control input-sm" id="jumlah" name="jumlah" placeholder="Quantity in Kg" required />
                                </div>
                                <div class="form-group form-material">
                                    <label class="control-label" for="inputText">Goods</label>
                                    <select name="id_barang" class="form-control input-sm">
                                        <?php foreach ($this->ADM->grid_all_barang('', 'id_barang', 'DESC', 100, '', '', '') as $barang) { ?>
                                            <option value="<?php echo $barang->id_barang ?>"><?php echo $barang->nama_barang ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class='button center'>
                                    <input class="btn btn-success btn-sm" type="submit" name="simpan" value="Add Data" id="validateButton2">
                                    <input class="btn btn-danger btn-sm" type="reset" name="batal" value="Cancel" onclick="location.href='<?php echo site_url(); ?>website/feeds'" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a href="<?php echo site_url(); ?>website/feeds">
            <button class="site-action btn-raised btn btn-sm btn-floating blue" type="button">
                <i class="icon wb-eye" aria-hidden="true"></i>
            </button>
        </a>
    </div>
    <!-- ================================================== END TAMBAH ================================================== -->

    <!-- ================================================== EDIT ================================================== -->
<?php } elseif ($action == 'edit') { ?>
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
                            <h5 class="panel-title">Edit <?php echo $breadcrumb; ?></h5>
                        </div>
                        <div class="panel-body container-fluid">
                            <form action="<?php echo site_url(); ?>website/feeds/edit/<?php echo $id_feeds; ?>" method="post" id="exampleStandardForm" autocomplete="off">
                                <input type="hidden" name="id_feeds" value="<?php echo $id_feeds; ?>" />
                                <div class="form-group form-material">
                                    <label class="control-label" for="inputText">Feeds name</label>
                                    <input type="text" value="<?php echo $nama_feeds; ?>" class="form-control input-sm" id="nama_feeds" name="nama_feeds" placeholder="Fedds name" required />
                                </div>
                                <div class="form-group form-material">
                                    <label class="control-label" for="inputText">Quantity</label>
                                    <input type="number" value="<?php echo $jumlah; ?>" class="form-control input-sm" id="jumlah" name="jumlah" placeholder="Quantity in Kg" required />
                                </div>
                                <div class="form-group form-material">
                                    <label class="control-label" for="inputText">Goods</label>
                                    <select name="id_barang" class="form-control input-sm">
                                        <?php foreach ($this->ADM->grid_all_barang('', 'id_barang', 'DESC', 100, '', '', '') as $barang) { ?>
                                            <option value="<?php echo $barang->id_barang ?>"><?php echo $barang->nama_barang ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class='button center'>
                                    <input class="btn btn-success btn-sm" type="submit" name="simpan" value="Update Data" id="validateButton2">
                                    <input class="btn btn-danger btn-sm" type="reset" name="batal" value="Cancel" onclick="location.href='<?php echo site_url(); ?>website/feeds'" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a href="<?php echo site_url(); ?>website/feeds">
            <button class="site-action btn-raised btn btn-sm btn-floating blue" type="button">
                <i class="icon wb-eye" aria-hidden="true"></i>
            </button>
        </a>
    </div>
    <!-- ================================================== END EDIT ================================================== -->
<?php } ?>