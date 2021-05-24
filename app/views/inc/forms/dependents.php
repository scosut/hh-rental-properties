<div class="form-group">
	<label class="col-form-label required">Number of Dependents</label>
	<select id="numDependents" name="numDependents" class="form-control flat">
		<option></option>
		<option>0</option>
		<option>1</option>
		<option>2</option>
		<option>3</option>
		<option>4</option>
		<option>5</option>
	</select>
	<div class="invalid-feedback"></div>
</div>
<?php foreach([1, 2, 3, 4, 5] as $num): ?>
<div id="dependents-<?= $num; ?>" class="inner-card" style="display:none;">
	<div class="inner-card-title form-group">
		<label class="col-form-label">DEPENDENT <?= $num; ?></label>
	</div>
	<div class="inner-card-body">
		<div class="form-group">
			<label class="col-form-label required">Name</label>
			<input type="text" name="name<?= $num; ?>" class="form-control flat" />
			<div class="invalid-feedback"></div>
		</div>
		<div class="form-group">
			<label class="col-form-label required">Date of Birth</label>
			<input type="text" name="dob<?= $num; ?>" class="form-control flat" data-inputmask="'alias': 'datetime', 'inputFormat': 'mm/dd/yyyy', 'placeholder': '_'" />
			<div class="invalid-feedback"></div>
		</div>
	</div>
</div>
<?php endforeach; ?>