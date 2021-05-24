<div class="form-group">
	<label class="col-form-label required">Number of Vehicles</label>
	<select id="numVehicles" name="numVehicles" class="form-control flat">
		<option></option>
		<option>1</option>
		<option>2</option>
		<option>3</option>
		<option>4</option>
	</select>
	<div class="invalid-feedback"></div>
</div>
<?php foreach([1, 2, 3, 4] as $num): ?>
<div id="vehicles-<?= $num; ?>" class="inner-card" style="display:none;">
	<div class="inner-card-title form-group">
		<label class="col-form-label">VEHICLE <?= $num; ?></label>
	</div>
	<div class="inner-card-body">
		<div class="form-group">
			<label class="col-form-label required">Make</label>
			<input type="text" name="make<?= $num; ?>" class="form-control flat" />
			<div class="invalid-feedback"></div>
		</div>
		<div class="form-group">
			<label class="col-form-label required">Model</label>
			<input type="text" name="model<?= $num; ?>" class="form-control flat" />
			<div class="invalid-feedback"></div>
		</div>
		<div class="form-group">
			<label class="col-form-label required">Color</label>
			<input type="text" name="color<?= $num; ?>" class="form-control flat" />
			<div class="invalid-feedback"></div>
		</div>
		<div class="form-group">
			<label class="col-form-label required">Year</label>
			<input type="text" name="year<?= $num; ?>" class="form-control flat" data-inputmask="'regex': '(19|20)\\d{2}'" 
			/>
			<div class="invalid-feedback"></div>
		</div>
		<div class="form-group">
			<label class="col-form-label required">License Plate Number</label>
			<input type="text" name="licensePlateNumber<?= $num; ?>" class="form-control flat" />
			<div class="invalid-feedback"></div>
		</div>
		<div class="form-group">
			<label class="col-form-label required">License Plate State</label>
			<select name="licensePlateState<?= $num; ?>" class="form-control flat">
				<option></option>
				<?php foreach($states as $state): ?>
				<option><?= $state; ?></option>
				<?php endforeach; ?>
			</select>
			<div class="invalid-feedback"></div>
		</div>
	</div>
</div>
<?php endforeach; ?>