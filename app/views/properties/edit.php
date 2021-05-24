<?php $page_name = "Edit Property"; ?>
<?php require APP_ROOT."/views/inc/header.php"; ?>

<div class="main-heading pt-0">
	<div class="container">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a class="breadcrumb-link" href="/properties/dashboard">Properties</a></li>
			<li class="breadcrumb-item active" aria-current="page">Edit</li>
		</ol>
		<h1>Manage Properties</h1>
	</div>
</div>

<div class="container">
	<div class="card card-form mb-5">
		<div class="card-body">
			<h2 class="card-title">EDIT PROPERTY</h2>
			<p class="form-legend">(<span class="text-required">*</span> indicates a required field)</p>
				<form id="property" class="form" action="/properties/complete/<?= $data->id; ?>" autocomplete="off">
					<?php require APP_ROOT."/views/inc/forms/property.php"; ?>
					
					<?php $count = 1; ?>
					<?php if(count($data->interiorimages) > 0): ?>
					<div class="inner-card">					
						<div class="inner-card-title form-group">
							<label class="col-form-label">Interior Images</label>
						</div>
						<div class="inner-card-body">
						<?php foreach ($data->interiorimages as $image): ?>
						<?php 
							$filename = explode("/", $image);
							$filename = $filename[count($filename)-1];
						?>						
							<div class="form-group">
								<label class="col-form-label">
									Image <?= $count; ?>																		
								</label>
								<div class="custom-file">
									<input type="file" id="interiorimage<?= $count; ?>" name="interiorimage<?= $count; ?>" class="custom-file-input" accept="image/jpeg" />
									<div class="invalid-feedback"></div>
									<label class="form-control flat custom-file-label">(select interior image)</label>
								</div>
								<div class="row row-thumb align-items-center">
									<div class="col-4 col-sm-3 col-thumb mt-2">
										<a href="<?= $image; ?>" data-lightbox="interior-image-<?= $count; ?>">
											<img src="<?= $image; ?>" class="img-fluid img-shadow" />
										</a>										
									</div>
									<div class="col-8 col-sm-9">
										<div class="form-check">
											<input class="form-check-input" type="checkbox" name="interiordelete[]" id="interiordelete<?= $count; ?>" value="<?= $filename; ?>">
											<label class="form-check-label" for="interiordelete<?= $count; ?>">
												Delete
											</label>
										</div>
									</div>
								</div>
							</div>
							<?php $count++; ?>
							<?php endforeach; ?>
						</div>
					</div>
					<?php endif; ?>
					
					<div class="form-group">
						<label class="col-form-label"><?= $count > 1 ? 'Additional ' : ''; ?>Interior Images</label>
						<div class="custom-file">
							<input type="file" id="additionalimage" name="additionalimage[]" class="custom-file-input" multiple accept="image/jpeg" />
							<div class="invalid-feedback"></div>
							<label class="form-control flat custom-file-label">(select interior images)</label>
						</div>
					</div>
					
					<div class="form-group mt-4">
         		<input type="hidden" name="hdnimagecount" value="<?= $count - 1; ?>" />
          	<button type="submit" class="btn btn-next">UPDATE</button>
          </div>
				</form>
		</div>
	</div>
</div>

<?php require APP_ROOT."/views/inc/footer.php"; ?>