<?php 
	$page_name  = "Rental Application";
	$properties = $data["properties"];
	$states     = $data["states"];
?>
<?php require APP_ROOT."/views/inc/header.php"; ?>

<div class="main-heading">
	<div class="container">
		<h1><?= $page_name; ?></h1>
	</div>
</div>

<div class="container">
	<div class="card card-form mb-5">
		<div id="rentalApp" class="card-body">
			<form class="form" id="infoApp" name="infoApp" action="/applicants/create" autocomplete="off">
				<h2 class="card-title">APPLICANT INFORMATION</h2>
				<p class="form-legend">(<span class="text-required">*</span> indicates a required field)</p>
				
				<div class="form-group">
					<label class="col-form-label required">Property</label>
					<select name="propertyId" class="form-control flat">
						<option></option>
						<?php foreach($properties as $property): ?>
						<option value="<?= $property->id; ?>"><?= $property->address; ?></option>
						<?php endforeach; ?>
					</select>
					<div class="invalid-feedback"></div>
				</div>						

				<?php require APP_ROOT."/views/inc/forms/information.php"; ?>

				<div class="form-group mt-4">
					<input type="hidden" name="hdnFormId" value="infoApp" />
					<input type="hidden" name="hdnCoapp" />
					<button type="submit" class="btn btn-next">NEXT</button>
				</div>
			</form>
			
			<form class="form" id="empCurrApp" name="empCurrApp" action="/applicants/create" autocomplete="off">
				<h2 class="card-title">APPLICANT EMPLOYMENT INFORMATION</h2>
				<p class="form-legend">(<span class="text-required">*</span> indicates a required field)</p>
				
				<div class="form-group">
					<label class="col-form-label required">Current Employment Status</label>
					<input type="hidden" name="status" />
					<div class="invalid-feedback"></div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" id="empCurrApp-fullTime" name="status[]" value="full time" />
						<label class="form-check-label" for="empCurrApp-fullTime">Full time</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" id="empCurrApp-partTime" name="status[]" value="part time" />
						<label class="form-check-label" for="empCurrApp-partTime">Part time</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" id="empCurrApp-student" name="status[]" value="student" />
						<label class="form-check-label" for="empCurrApp-student">Student</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" id="empCurrApp-unemployed" name="status[]" value="unemployed" />
						<label class="form-check-label" for="empCurrApp-unemployed">Unemployed</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" id="empCurrApp-retired" name="status[]" value="retired" />
						<label class="form-check-label" for="empCurrApp-retired">Retired</label>
					</div>
				</div>
				
				<div id="empCurrApp-expanded-content" style="display:none;">
					<div class="form-group">
						<label class="col-form-label required">Current Employer</label>
						<input type="text" name="employer" class="form-control flat" />
						<div class="invalid-feedback"></div>
					</div>
					<?php require APP_ROOT."/views/inc/forms/employment.php"; ?>
				</div>
				
				<div class="form-group mt-4">
					<input type="hidden" name="hdnFormId" value="empCurrApp" />
					<input type="hidden" name="hdnCoapp"  />				
					<button type="button" class="btn btn-back">BACK</button>
					<button type="submit" class="btn btn-next">NEXT</button>
				</div>
			</form>
			
			<form class="form" id="empPrevApp" name="empPrevApp" action="/applicants/create" autocomplete="off">
				<h2 class="card-title">APPLICANT EMPLOYMENT INFORMATION</h2>
				<p class="form-legend">(<span class="text-required">*</span> indicates a required field)</p>
				
				<div class="form-group">
					<label class="d-block col-form-label required">Do you have a previous employer?</label>
					<input type="hidden" name="employment" />
					<div class="invalid-feedback"></div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="employment[]" id="empPrevApp-employment-yes" value="yes">
						<label class="form-check-label" for="empPrevApp-employment-yes">Yes</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="employment[]" id="empPrevApp-employment-no" value="no">
						<label class="form-check-label" for="empPrevApp-employment-no">No</label>
					</div>
				</div>
				
				<div id="empPrevApp-employment-expanded-content" style="display:none;">
					<div class="form-group">
						<label class="d-block col-form-label required">Previous Employment Status</label>
						<input type="hidden" name="status" />
						<div class="invalid-feedback"></div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="status[]" id="empPrevApp-fullTime" value="full time">
							<label class="form-check-label" for="empPrevApp-fullTime">Full Time</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="status[]" id="empPrevApp-partTime" value="part time">
							<label class="form-check-label" for="empPrevApp-partTime">Part Time</label>
						</div>
					</div>				
				
					<div class="form-group">
						<label class="col-form-label required">Previous Employer</label>
						<input type="text" name="employer" class="form-control flat" />
					</div>
					<?php require APP_ROOT."/views/inc/forms/employment.php"; ?>
				</div>
				
				<div class="form-group mt-4">
					<input type="hidden" name="hdnFormId" value="empPrevApp" />
					<input type="hidden" name="hdnCoapp"  />
					<button type="button" class="btn btn-back">BACK</button>
					<button type="submit" class="btn btn-next">NEXT</button>
				</div>
			</form>
			
			<form class="form" id="creditApp" name="creditApp" action="/applicants/create" autocomplete="off">
				<h2 class="card-title">APPLICANT CREDIT HISTORY</h2>
				<p class="form-legend">(<span class="text-required">*</span> indicates a required field)</p>
				
				<?php $formId="creditApp"; ?>
				<?php require APP_ROOT."/views/inc/forms/credit.php"; ?>
				
				<div class="form-group mt-4">
					<input type="hidden" name="hdnFormId" value="creditApp" />
					<input type="hidden" name="hdnCoapp"  />
					<button type="button" class="btn btn-back">BACK</button>
					<button type="submit" class="btn btn-next">NEXT</button>
				</div>
			</form>
			
			<form class="form" id="infoCoapp" name="infoCoapp" action="/applicants/create" autocomplete="off">
				<h2 class="card-title">CO-APPLICANT INFORMATION</h2>
				<p class="form-legend">(<span class="text-required">*</span> indicates a required field)</p>
				
				<div class="form-group">
					<label class="d-block col-form-label required">Is there a co-applicant?</label>
					<input type="hidden" name="coapp" />
					<div class="invalid-feedback"></div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="coapp[]" id="infoCoapp-coapp-yes" value="yes">
						<label class="form-check-label" for="infoCoapp-coapp-yes">Yes</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="coapp[]" id="infoCoapp-coapp-no" value="no">
						<label class="form-check-label" for="infoCoapp-coapp-no">No</label>
					</div>
				</div>

				<div id="infoCoapp-expanded-content" style="display:none;">
				<?php require APP_ROOT."/views/inc/forms/information.php"; ?>
				</div>

				<div class="form-group mt-4">
					<input type="hidden" name="hdnFormId" value="infoCoapp" />
					<input type="hidden" name="hdnCoapp"  />
					<button type="button" class="btn btn-back">BACK</button>
					<button type="submit" class="btn btn-next">NEXT</button>
				</div>
			</form>
			
			<form class="form" id="empCurrCoapp" name="empCurrCoapp" action="/applicants/create" autocomplete="off">
				<h2 class="card-title">CO-APPLICANT EMPLOYMENT INFORMATION</h2>
				<p class="form-legend">(<span class="text-required">*</span> indicates a required field)</p>
				
				<div class="form-group">
					<label class="col-form-label required">Current Employment Status</label>
					<input type="hidden" name="status" />
					<div class="invalid-feedback"></div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" id="empCurrCoapp-fullTime" name="status[]" value="full time" />
						<label class="form-check-label" for="empCurrCoapp-fullTime">Full time</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" id="empCurrCoapp-partTime" name="status[]" value="part time" />
						<label class="form-check-label" for="empCurrCoapp-partTime">Part time</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" id="empCurrCoapp-student" name="status[]" value="student" />
						<label class="form-check-label" for="empCurrCoapp-student">Student</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" id="empCurrCoapp-unemployed" name="status[]" value="unemployed" />
						<label class="form-check-label" for="empCurrCoapp-unemployed">Unemployed</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" id="empCurrCoapp-retired" name="status[]" value="retired" />
						<label class="form-check-label" for="empCurrCoapp-retired">Retired</label>
					</div>
				</div>				
				
				<div id="empCurrCoapp-expanded-content" style="display:none;">
					<div class="form-group">
						<label class="col-form-label required">Current Employer</label>
						<input type="text" name="employer" class="form-control flat" />
					</div>
					<?php require APP_ROOT."/views/inc/forms/employment.php"; ?>
				</div>
				
				<div class="form-group mt-4">
					<input type="hidden" name="hdnFormId" value="empCurrCoapp" />
					<input type="hidden" name="hdnCoapp"  />
					<button type="button" class="btn btn-back">BACK</button>
					<button type="submit" class="btn btn-next">NEXT</button>
				</div>
			</form>	
			
			<form class="form" id="empPrevCoapp" name="empPrevCoapp" action="/applicants/create" autocomplete="off">
				<h2 class="card-title">CO-APPLICANT EMPLOYMENT INFORMATION</h2>
				<p class="form-legend">(<span class="text-required">*</span> indicates a required field)</p>
				
				<div class="form-group">
					<label class="d-block col-form-label required">Does co-applicant have a previous employer?</label>
					<input type="hidden" name="employment" />
					<div class="invalid-feedback"></div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="employment[]" id="empPrevCoapp-employment-yes" value="yes">
						<label class="form-check-label" for="empPrevCoapp-employment-yes">Yes</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="employment[]" id="empPrevCoapp-employment-no" value="no">
						<label class="form-check-label" for="empPrevCoapp-employment-no">No</label>
					</div>
				</div>
				
				<div id="empPrevCoapp-employment-expanded-content" style="display:none;">
					<div class="form-group">
						<label class="d-block col-form-label required">Previous Employment Status</label>
						<input type="hidden" name="status" />
						<div class="invalid-feedback"></div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="status[]" id="empPrevCoapp-fullTime" value="full time">
							<label class="form-check-label" for="empPrevCoapp-fullTime">Full Time</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="status[]" id="empPrevCoapp-partTime" value="part time">
							<label class="form-check-label" for="empPrevCoapp-partTime">Part Time</label>
						</div>
					</div>				
				
					<div class="form-group">
						<label class="col-form-label required">Previous Employer</label>
						<input type="text" name="employer" class="form-control flat" />
					</div>
					<?php require APP_ROOT."/views/inc/forms/employment.php"; ?>
				</div>
				
				<div class="form-group mt-4">
					<input type="hidden" name="hdnFormId" value="empPrevCoapp" />
					<input type="hidden" name="hdnCoapp"  />
					<button type="button" class="btn btn-back">BACK</button>
					<button type="submit" class="btn btn-next">NEXT</button>
				</div>
			</form>
			
			<form class="form" id="creditCoapp" name="creditCoapp" action="/applicants/create" autocomplete="off">
				<h2 class="card-title">CO-APPLICANT CREDIT HISTORY</h2>
				<p class="form-legend">(<span class="text-required">*</span> indicates a required field)</p>
				
				<?php $formId="creditCoapp"; ?>
				<?php require APP_ROOT."/views/inc/forms/credit.php"; ?>
				
				<div class="form-group mt-4">
					<input type="hidden" name="hdnFormId" value="creditCoapp" />
					<input type="hidden" name="hdnCoapp"  />
					<button type="button" class="btn btn-back">BACK</button>
					<button type="submit" class="btn btn-next">NEXT</button>
				</div>
			</form>
			
			<form class="form" id="dependents" name="dependents" action="/applicants/create" autocomplete="off">
				<h2 class="card-title">DEPENDENTS</h2>
				<p class="form-legend">(<span class="text-required">*</span> indicates a required field)</p>
				
				<?php require APP_ROOT."/views/inc/forms/dependents.php"; ?>
				
				<div class="form-group mt-4">
					<input type="hidden" name="hdnFormId" value="dependents" />
					<input type="hidden" name="hdnCoapp"  />
					<button type="button" class="btn btn-back">BACK</button>
					<button type="submit" class="btn btn-next">NEXT</button>
				</div>
			</form>
			
			<form class="form" id="currRes" name="currRes" action="/applicants/create" autocomplete="off">
				<h2 class="card-title">RESIDENTIAL HISTORY</h2>
				<p class="form-legend">(<span class="text-required">*</span> indicates a required field)</p>
			
				<div class="form-group">
					<label class="col-form-label required">Current Residence Street Address</label>
					<input type="text" name="address" class="form-control flat" />
				</div>
				
				<?php $formId="currRes"; ?>
				<?php require APP_ROOT."/views/inc/forms/residential.php"; ?>

				<div class="form-group mt-4">
					<input type="hidden" name="hdnFormId" value="currRes" />
					<input type="hidden" name="hdnCoapp"  />
					<button type="button" class="btn btn-back">BACK</button>
					<button type="submit" class="btn btn-next">NEXT</button>
				</div>
			</form>
			
			<form class="form" id="prevRes" name="prevRes" action="/applicants/create" autocomplete="off">
				<h2 class="card-title">RESIDENTIAL HISTORY</h2>
				<p class="form-legend">(<span class="text-required">*</span> indicates a required field)</p>
				
				<div class="form-group">
					<label class="d-block col-form-label required">Do you have a previous residence?</label>
					<input type="hidden" name="residence" />
					<div class="invalid-feedback"></div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="residence[]" id="prevRes-residence-yes" value="yes">
						<label class="form-check-label" for="prevRes-residence-yes">Yes</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="residence[]" id="prevRes-residence-no" value="no">
						<label class="form-check-label" for="prevRes-residence-no">No</label>
					</div>
				</div>
				
				<div id="prevRes-residence-expanded-content" style="display:none;">
					<div class="form-group">
						<label class="col-form-label required">Previous Residence Street Address</label>
						<input type="text" name="address" class="form-control flat" />
					</div>

					<?php $formId="prevRes"; ?>
					<?php require APP_ROOT."/views/inc/forms/residential.php"; ?>
				</div>

				<div class="form-group mt-4">
					<input type="hidden" name="hdnFormId" value="prevRes" />
					<input type="hidden" name="hdnCoapp"  />
					<button type="button" class="btn btn-back">BACK</button>
					<button type="submit" class="btn btn-next">NEXT</button>
				</div>
			</form>

			<form class="form" id="references" name="references" action="/applicants/create" autocomplete="off">
				<h2 class="card-title">PROFESSIONAL REFERENCES</h2>
				<p class="form-legend">(<span class="text-required">*</span> indicates a required field)</p>
				
				<?php require APP_ROOT."/views/inc/forms/references.php"; ?>
				
				<div class="form-group mt-4">
					<input type="hidden" name="hdnFormId" value="references" />
					<input type="hidden" name="hdnCoapp"  />
					<button type="button" class="btn btn-back">BACK</button>
					<button type="submit" class="btn btn-next">NEXT</button>
				</div>
			</form>			
			
			<form class="form" id="emergency" name="emergency" action="/applicants/create" autocomplete="off">
				<h2 class="card-title">EMERGENCY CONTACT</h2>
				<p class="form-legend">(<span class="text-required">*</span> indicates a required field)</p>
				
				<?php require APP_ROOT."/views/inc/forms/emergency.php"; ?>
				
				<div class="form-group mt-4">
					<input type="hidden" name="hdnFormId" value="emergency" />
					<input type="hidden" name="hdnCoapp"  />
					<button type="button" class="btn btn-back">BACK</button>
					<button type="submit" class="btn btn-next">NEXT</button>
				</div>
			</form>
			
			<form class="form" id="vehicles" name="vehicles" action="/applicants/create" autocomplete="off">
				<h2 class="card-title">VEHICLES</h2>
				<p class="form-legend">(<span class="text-required">*</span> indicates a required field)</p>
				
				<?php require APP_ROOT."/views/inc/forms/vehicles.php"; ?>
				
				<div class="form-group mt-4">
					<input type="hidden" name="hdnFormId" value="vehicles" />
					<input type="hidden" name="hdnCoapp"  />
					<button type="button" class="btn btn-back">BACK</button>
					<button type="submit" class="btn btn-next">NEXT</button>
				</div>
			</form>
			
			<form class="form" id="additional" name="additional" action="/applicants/create" autocomplete="off">
				<h2 class="card-title">ADDITIONAL INFORMATION</h2>
				<p class="form-legend">(<span class="text-required">*</span> indicates a required field)</p>
				
				<?php require APP_ROOT."/views/inc/forms/additional.php"; ?>
				
				<div class="form-group mt-4">
					<input type="hidden" name="hdnFormId" value="additional" />
					<input type="hidden" name="hdnCoapp"  />
					<input type="hidden" name="dateSubmitted" />
					<button type="button" class="btn btn-back">BACK</button>
					<button type="submit" class="btn btn-next">SUBMIT</button>
				</div>
			</form>
			
			<?php require APP_ROOT."/views/inc/forms/terms.php"; ?>
		</div>
	</div>
</div>

<?php require APP_ROOT."/views/inc/footer.php"; ?>