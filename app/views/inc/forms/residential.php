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
	<label class="col-form-label required">Monthly Payment</label>
	<input type="text" name="payment" class="form-control flat" data-inputmask="'alias': 'currency', 'rightAlign': false" />
	<div class="invalid-feedback"></div>
</div>
<div class="form-group">
	<label class="d-block col-form-label required">Are you renting this property?</label>
	<input type="hidden" name="rentOwn" />
	<div class="invalid-feedback"></div>
	<div class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="rentOwn[]" id="<?= $formId; ?>-rentOwn-rent" value="rent">
		<label class="form-check-label" for="<?= $formId; ?>-rentOwn-rent">Rent</label>
	</div>
	<div class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="rentOwn[]" id="<?= $formId; ?>-rentOwn-own" value="own">
		<label class="form-check-label" for="<?= $formId; ?>-rentOwn-own">Own</label>
	</div>
</div>
<div class="form-group">
		<label class="col-form-label required">Landlord/Mortgagee Name</label>
		<input type="text" name="landlordName" class="form-control flat" />
		<div class="invalid-feedback"></div>
</div>
<div class="form-group">
		<label class="col-form-label required">Landlord/Mortgagee Phone</label>
		<input type="text" name="landlordPhone" class="form-control flat" data-inputmask="'mask': '(999) 999-9999'" />
		<div class="invalid-feedback"></div>
</div>
<div class="form-group">
	<label for="leavingReason" class="col-form-label required">Reason for Leaving</label>
	<textarea name="leavingReason" class="form-control flat"></textarea>
	<div class="invalid-feedback"></div>
</div>