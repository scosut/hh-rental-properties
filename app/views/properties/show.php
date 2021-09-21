<?php $page_name = "Property Details"; ?>
<?php require APP_ROOT."/views/inc/header.php"; ?>

<div class="main-heading pt-0">
	<div class="container">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a class="breadcrumb-link" href="/properties">Properties</a></li>
			<li class="breadcrumb-item active" aria-current="page">Property Details</li>
		</ol>
		<h1><?= $data->address; ?></h1>
		<p><?= "$data->city, $data->state $data->zip"; ?></p>
	</div>
</div>

<div class="property mb-5">
	<div class="container">
		<div class="row">
			<div class="col-md-8 mb-2 mb-md-0">
				<div class="row">
					<div class="col">
						<img id="property-main-image" src="<?= $data->exteriorimage; ?>" class="img-fluid img-shadow" alt="exterior image" />
					</div>
				</div>
				<div class="row row-thumb">
				<?php foreach($data->interiorimages as $image): ?>				
					<div class="col-2 col-lg-1 col-thumb mt-2">
						<a href="<?= $image; ?>" data-lightbox="interior-images">
							<img src="<?= $image; ?>" class="img-fluid img-shadow" alt="interior image" />
						</a>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="col-md-4 mt-3 mt-md-0 pr-md-0">
				<iframe src="<?= $data->map; ?>" style="border:0; width:100%;" allowfullscreen loading="lazy"></iframe>
				<?php if($data->status == "available"): ?>
				<button class="btn btn-schedule mt-1" data-toggle="modal" data-target="#scheduleModal">SCHEDULE SHOWING</button>
				<?php endif; ?>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<h2 class="mt-5 mb-4">Property Description</h2>

				<p><?= $data->description; ?></p>

				<h3 class="mb-2">Details</h3>

				<div class="details">
					<div class="details-row">
						<div class="details-col">Square Feet:</div>
						<div class="details-col"><?= $data->sqft; ?></div>
					</div>
					<div class="details-row">
						<div class="details-col">Garage:</div>
						<div id="details-garage" class="details-col"><?= $data->garage; ?></div>
					</div>
					<div class="details-row">
						<div class="details-col">Bedrooms:</div>
						<div id="details-bdrm" class="details-col"><?= $data->bedrooms; ?></div>
					</div>
					<div class="details-row">
						<div class="details-col">Bathrooms:</div>
						<div id="details-bath" class="details-col"><?= $data->formattedBathrooms; ?></div>
					</div>
					<?php if($data->status != "unavailable"): ?>
					<div class="details-row">
						<div class="details-col">Lease:</div>
						<div class="details-col">1 year</div>
					</div>
					<div class="details-row">
						<div class="details-col">Rent:</div>
						<div id="details-price" class="details-col"><?= $data->formattedRent; ?></div>
					</div>
					<div class="details-row">
						<div class="details-col">Deposit:</div>
						<div id="details-deposit" class="details-col"><?= $data->formattedDeposit; ?></div>
					</div>
					<?php endif; ?>
					<div class="details-row">
						<div class="details-col">Schools:</div>
						<div class="details-col">
							<p><?= $data->elementaryschool; ?> Elementary School</p>
							<p><?= $data->middleschool; ?> Middle School</p>
							<p><?= $data->highschool; ?> High School</p>
						</div>
					</div>
					<div class="details-row">
						<div class="details-col">Pets:</div>
						<div class="details-col">Not permitted</div>
					</div>
				</div>               
			</div>
		</div>
	</div>      
</div>

<div class="modal fade" id="scheduleModal" tabindex="-1" role="dialog" aria-labelledby="scheduleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">						
			<div class="modal-header borderless">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">                
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">            
				<div class="card card-form mb-5">
					<div class="card-body">
						<h2 class="card-title">SCHEDULE SHOWING</h2>
						
						<p class="form-legend">(<span class="text-required">*</span> indicates a required field)</p>
						
						<form id="schedule" class="form" action="/properties/schedule/<?= $data->id; ?>">
							<div class="form-group">
								<label for="name" class="col-form-label required">Name</label>
								<input type="text" id="name" name="name" class="form-control flat" />
								<div class="invalid-feedback"></div>
							</div>
							<div class="form-group">
								<label for="email" class="col-form-label required">Email Address</label>
								<input type="text" id="email" name="email" class="form-control flat" data-inputmask="'alias': 'email'" />
								<div class="invalid-feedback"></div>
							</div>
							<div class="form-group">
								<label for="phone" class="col-form-label required">Phone</label>
								<input type="text" id="phone" name="phone" class="form-control flat" data-inputmask="'mask': '(999) 999-9999'" />
								<div class="invalid-feedback"></div>
							</div> 
							<div class="form-group">
								<label for="date" class="col-form-label required">Date</label>
								<input type="text" id="date" name="date" class="form-control flat" />
								<div class="invalid-feedback"></div>
							</div> 
							<div class="form-group">
								<label for="appt" class="col-form-label required">Time</label>
								<select id="time" name="time" class="form-control flat timepicker">
									<option></option>
								</select>
								<div class="invalid-feedback"></div>
							</div>                  
							<div class="form-group mt-4">
								<input type="hidden" name="hdnProperty" value='<?= "$data->address, $data->city, $data->state $data->zip"; ?>' />
								<button type="button" class="btn btn-modal-back" data-dismiss="modal">CANCEL</button>
								<button type="submit" class="btn btn-modal-next">SUBMIT</button>
							</div>
						</form>
					</div>
				</div>
			</div>          
		</div>
	</div>
</div>

<?php require APP_ROOT."/views/inc/footer.php"; ?>