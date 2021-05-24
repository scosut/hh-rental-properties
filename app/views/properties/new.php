<?php $page_name = "Add Property"; ?>
<?php require APP_ROOT."/views/inc/header.php"; ?>

<div class="main-heading pt-0">
	<div class="container">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a class="breadcrumb-link" href="/properties/dashboard">Properties</a></li>
			<li class="breadcrumb-item active" aria-current="page">Add</li>
		</ol>
		<h1>Manage Properties</h1>
	</div>
</div>

<div class="container">
	<div class="card card-form mb-5">
		<div class="card-body">
			<h2 class="card-title">ADD PROPERTY</h2>
			<p class="form-legend">(<span class="text-required">*</span> indicates a required field)</p>
				<form id="property" class="form" action="/properties/create" autocomplete="off">
					<?php require APP_ROOT."/views/inc/forms/property.php"; ?>
					
					<div class="form-group">
						<label class="col-form-label">Interior Images</label>
						<div class="custom-file">
							<input type="file" id="interiorimage" name="interiorimage[]" class="custom-file-input" multiple accept="image/jpeg" />
							<div class="invalid-feedback"></div>
							<label class="form-control flat custom-file-label">(select interior images)</label>
						</div>
					</div>
					
					<div class="form-group mt-4">
          	<button type="submit" class="btn btn-next">ADD</button>
          </div>
				</form>
		</div>
	</div>
</div>

<?php require APP_ROOT."/views/inc/footer.php"; ?>