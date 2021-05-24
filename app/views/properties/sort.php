<?php $page_name = "Sort Images"; ?>
<?php require APP_ROOT."/views/inc/header.php"; ?>

<div class="main-heading pt-0">
	<div class="container">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a class="breadcrumb-link" href="/properties/dashboard">Properties</a></li>
			<li class="breadcrumb-item active" aria-current="page">Sort</li>
		</ol>
		<h1>Manage Properties</h1>
	</div>
</div>

<div class="container">
	<div class="card card-form mb-5">
		<div class="card-body">
			<h2 class="card-title">SORT INTERIOR IMAGES</h2>
			<p class="form-legend">(<span class="text-required">*</span> indicates a required field)</p>
				<form id="property" class="form" action="/properties/sort/<?= $data["propertyId"]; ?>" autocomplete="off">
					<div class="form-group">
						<?php 
						$item = $data["images"][0]; 
						echo "{$item->address}<br>{$item->city}, {$item->state} {$item->zip}";
						?>
					</div>
					<div class="inner-card">					
						<div class="inner-card-title form-group">
							<label class="col-form-label">Interior Images</label>
						</div>
						<div class="inner-card-body">							
						<?php $count = 1; ?>
						<?php foreach ($data["images"] as $item): ?>	
							<div class="form-group">
								<label class="col-form-label">
									Image <?= $count; ?>																		
								</label>
								<div class="row row-thumb align-items-center">
									<div class="col-4 col-sm-3 col-thumb mt-2">
										<a href="<?= $item->image; ?>" data-lightbox="interior-image-<?= $count; ?>">
											<img src="<?= $item->image; ?>" class="img-fluid img-shadow" />
										</a>										
									</div>
									<div class="col-8 col-sm-9">
										<label class="col-form-label">Order</label>
										<select class="form-control form-control-sm flat w-auto" name="sortOrder<?=$count; ?>">
											<?php for($i=1; $i<=count($data["images"]); $i++): ?>											
											<option value='<?= "$item->id;;;$i"; ?>'<?= $item->sortOrder == $i ? ' selected' : ''; ?>><?= $i; ?></option>
											<?php endfor; ?>
										</select>
										<div class="invalid-feedback"></div>
									</div>
								</div>
							</div>
							<?php $count++; ?>
							<?php endforeach; ?>
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