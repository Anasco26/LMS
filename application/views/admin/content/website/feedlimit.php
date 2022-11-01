<!-- ================================================== VIEW ================================================== -->
<?php if ($action == 'view' || empty($action)){ ?>
<!-- ================================================== END VIEW ================================================== -->

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
						<h5 class="panel-title">Minimal Edit Limit Feeds Notifications</h5>
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
					<div class="panel-body container-fluid">
						<form action="<?php echo site_url();?>website/feedlimit/edit/<?php echo $limitfeed_id;?>" method="post" enctype="multipart/form-data"
						id="exampleStandardForm" autocomplete="off">
							<input type="hidden" name="limitfeed_id" value="<?php echo $limitfeed_id;?>" />
							<div class="form-group form-material">
								<label class="control-label" for="inputText">Feeds</label>
								<input type="text" class="form-control input-sm" id="feeds" name="feeds" placeholder="Enter Feeds"
								value="<?php echo $feeds;?>" required />
							</div>
							<div class="form-group form-material">
								<label class="control-label" for="inputText">Created</label>
								<input type="text" disabled class="form-control input-sm" id="limitfeed_created" name="limitfeed_created" value="<?php echo $limitfeed_created;?>"
								/>
							</div>
							<div class="form-group form-material">
								<label class="control-label" for="inputText">Last Changed</label>
								<input type="text" disabled class="form-control input-sm" id="limitfeed_updated" name="limitfeed_updated" value="<?php echo $limitfeed_updated;?>"
								/>
							</div>
							<div class='button center'>
								<input class="btn btn-success btn-sm" type="submit" name="simpan" value="Update Data" id="validateButton2">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<!-- ================================================== END EDIT ================================================== -->
