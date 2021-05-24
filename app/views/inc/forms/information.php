<div class="form-group">
	<label class="col-form-label required">First Name</label>
	<input type="text" name="firstName" class="form-control flat" />
	<div class="invalid-feedback"></div>
</div>
<div class="form-group">
	<label class="col-form-label">Middle Name</label>
	<input type="text" name="middleName" class="form-control flat" />
</div>
<div class="form-group">
	<label class="col-form-label required">Last Name</label>
	<input type="text" name="lastName" class="form-control flat" />
	<div class="invalid-feedback"></div>
</div>
<div class="inner-card">
	<div class="inner-card-title form-group">
		<label class="col-form-label required">Phone Number</label>
		<input type="hidden" name="phones" />
		<div class="invalid-feedback"></div>
	</div>      
	<div class="inner-card-body">
		<div class="form-group">
			<label class="col-form-label">Home Phone</label>
			<input type="text" name="homePhone" class="form-control flat" data-inputmask="'mask': '(999) 999-9999'" />
			<div class="invalid-feedback"></div>
		</div>
		<div class="form-group">
			<label class="col-form-label">Cell Phone</label>
			<input type="text" name="cellPhone" class="form-control flat" data-inputmask="'mask': '(999) 999-9999'" />
			<div class="invalid-feedback"></div>
		</div>
		<div class="form-group">
			<label class="col-form-label">Work Phone</label>
			<input type="text" name="workPhone" class="form-control flat" data-inputmask="'mask': '(999) 999-9999'" />
			<div class="invalid-feedback"></div>
		</div>
	</div>
</div>
<div class="form-group">
	<label class="col-form-label required">Date of Birth</label>
	<input type="text" name="dob" class="form-control flat" data-inputmask="'alias': 'datetime', 'inputFormat': 'mm/dd/yyyy', 'placeholder': '_'" />	
	<div class="invalid-feedback"></div>
</div>
<div class="form-group">
	<label class="col-form-label required">Social Security Number</label>
	<input type="text" name="ssn" class="form-control flat" data-inputmask="'mask': '999-99-9999'" />
	<div class="invalid-feedback"></div>
</div>
<div class="form-group">
	<label class="col-form-label required">Email Address</label>
	<input type="text" name="email" class="form-control flat" data-inputmask="'alias': 'email'" />
	<div class="invalid-feedback"></div>
</div>
<div class="form-group">
	<label class="col-form-label required">Driver's License Number</label>
	<input type="text" name="dln" class="form-control flat" />
	<div class="invalid-feedback"></div>
</div>
<div class="form-group">
	<label class="col-form-label required">State of Issue</label>
	<select name="dlnState" class="form-control flat">
		<option></option>
		<?php foreach($states as $state): ?>
		<option><?= $state; ?></option>
		<?php endforeach; ?>
	</select>
	<div class="invalid-feedback"></div>
</div>