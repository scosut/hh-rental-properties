<div class="form-group">
	<label class="col-form-label required">Occupation</label>
	<input type="text" name="occupation" class="form-control flat" />
	<div class="invalid-feedback"></div>
</div>
<div class="form-group">
	<label class="col-form-label required">Address</label>
	<input type="text" name="address" class="form-control flat" />
	<div class="invalid-feedback"></div>
</div>
<div class="form-group">
	<label class="col-form-label required">City</label>
	<input type="text" name="city" class="form-control flat" />
	<div class="invalid-feedback"></div>
</div>
<div class="form-group">
	<label class="col-form-label required">State</label>
	<select name="state" class="form-control flat">
		<option></option>
		<?php foreach($states as $state): ?>
		<option><?= $state; ?></option>
		<?php endforeach; ?>
	</select>
	<div class="invalid-feedback"></div>
</div>
<div class="form-group">
	<label class="col-form-label required">Zip</label>
	<input type="text" name="zip" class="form-control flat" data-inputmask="'mask': '99999'" />
	<div class="invalid-feedback"></div>
</div>
<div class="form-group">
	<label class="col-form-label required">Supervisor Name</label>
	<input type="text" name="supervisorName" class="form-control flat" />
	<div class="invalid-feedback"></div>
</div>
<div class="form-group">
	<label class="col-form-label required">Supervisor Phone</label>
	<input type="text" name="supervisorPhone" class="form-control flat" data-inputmask="'mask': '(999) 999-9999'" />
	<div class="invalid-feedback"></div>
</div>
<div class="form-group">
	<label class="col-form-label required">Years Employed</label>
	<input type="text" name="yearsEmployed" class="form-control flat" />
	<div class="invalid-feedback"></div>
</div>
<div class="form-group">
	<label class="col-form-label required">Monthly Income</label>
	<input type="text" name="monthlyIncome" class="form-control flat" data-inputmask="'alias': 'currency', 'rightAlign': false" />
	<div class="invalid-feedback"></div>
</div>