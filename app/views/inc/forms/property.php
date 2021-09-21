<div class="form-group">
	<label class="col-form-label required">Address</label>
	<input type="text" name="address" class="form-control flat" value="<?= $data->address; ?>" />
	<div class="invalid-feedback"></div>
</div>
<div class="form-group">
	<label class="col-form-label required">City</label>
	<input type="text" name="city" class="form-control flat" value="<?= $data->city; ?>" />
	<div class="invalid-feedback"></div>
</div>
<div class="form-group">
	<label class="col-form-label required">State</label>
	<select name="state" class="form-control flat">
		<option></option>
		<?php foreach($data->states as $state): ?>
		<option<?= $state == $data->state ? ' selected' : ''; ?>><?= $state; ?></option>
		<?php endforeach; ?>
	</select>
	<div class="invalid-feedback"></div>
</div>
<div class="form-group">
	<label class="col-form-label required">Zip Code</label>
	<input type="text" name="zip" class="form-control flat" value="<?= $data->zip; ?>" data-inputmask="'mask': '99999'" />
	<div class="invalid-feedback"></div>
</div>
<div class="form-group">
		<label class="col-form-label required">Monthly Rent</label>
		<input type="text" name="rent" class="form-control flat" value="<?= $data->formattedRent; ?>" data-inputmask="'alias': 'currency', 'rightAlign': false" />
		<div class="invalid-feedback"></div>
</div>
<div class="form-group">
		<label class="col-form-label required">Deposit</label>
		<input type="text" name="deposit" class="form-control flat" value="<?= $data->formattedDeposit; ?>" data-inputmask="'alias': 'currency', 'rightAlign': false" />
		<div class="invalid-feedback"></div>
</div>
<div class="form-group">
		<label class="col-form-label required">Status</label>
		<select name="status" class="form-control flat">
			<option></option>
			<?php foreach(['available', 'coming soon', 'unavailable'] as $status): ?>
				<option<?= $status == $data->status ? ' selected' : ''; ?>><?= $status; ?></option>
			<?php endforeach; ?>
		</select>
		<div class="invalid-feedback"></div>
</div>
<div class="form-group">
		<label class="col-form-label required">Map URL</label>
		<input type="text" name="map" class="form-control flat" value="<?= $data->map; ?>" />
		<div class="invalid-feedback"></div>
</div>
<div class="form-group">
	<Label for="description" class="col-form-label required">Description</Label>
	<textarea name="description" class="form-control flat"><?= $data->description; ?></textarea>
	<div class="invalid-feedback"></div>
</div>
<div class="form-group">
	<label class="col-form-label required">Square Feet</label>
	<input type="text" name="sqft" class="form-control flat" value="<?= $data->sqft; ?>" data-inputmask="'mask': '999[99]', 'greedy' : true, 'autoUnmask': true" />
	<div class="invalid-feedback"></div>
</div>
<div class="form-group">
	<label class="col-form-label required">Garage</label>
	<select name="garage" class="form-control flat">
		<option></option>
		<?php for($i=1; $i<=9; $i++): ?>
		<option<?= $i == $data->garage ? ' selected' : ''; ?>><?= $i; ?></option>
		<?php endfor; ?>		
	</select>
	<div class="invalid-feedback"></div>
</div>
<div class="form-group">
	<label class="col-form-label required">Bedrooms</label>
	<select name="bedrooms" class="form-control flat">
		<option></option>
		<?php for($i=1; $i<=9; $i++): ?>
		<option<?= $i == $data->bedrooms ? ' selected' : ''; ?>><?= $i; ?></option>
		<?php endfor; ?>
	</select>
	<div class="invalid-feedback"></div>
</div>
<div class="form-group">
	<label class="col-form-label required">Bathrooms</label>
	<select name="bathrooms" class="form-control flat">
		<option></option>
		<?php foreach([0.5, 0.75, 1, 1.5, 1.75, 2, 2.5, 2.75, 3, 3.5, 3.75, 4, 4.5, 4.75, 5, 5.5, 5.75, 6, 6.5, 6.75, 7, 7.5, 7.75, 8, 8.5, 8.75, 9] as $bathroom): ?>
		<option<?= $bathroom == $data->formattedBathrooms ? ' selected' : ''; ?>><?= $bathroom; ?></option>
		<?php endforeach; ?>
	</select>
	<div class="invalid-feedback"></div>
</div>
<div class="form-group">
	<label class="col-form-label required">Lease</label>
	<select name="lease" class="form-control flat">
		<option></option>                    
		<?php foreach(['3 months', '6 months', '9 months', '1 year', '2 years', 'month to month'] as $lease): ?>
			<option<?= $lease == $data->lease ? ' selected' : ''; ?>><?= $lease; ?></option>
		<?php endforeach; ?>		
	</select>
	<div class="invalid-feedback"></div>
</div>
<div class="form-group">
	<label class="col-form-label required">Elementary School</label>
	<input type="text" name="elementaryschool" class="form-control flat" value="<?= $data->elementaryschool; ?>" />
	<div class="invalid-feedback"></div>
</div>
<div class="form-group">
	<label class="col-form-label required">Middle School</label>
	<input type="text" name="middleschool" class="form-control flat" value="<?= $data->middleschool; ?>" />
	<div class="invalid-feedback"></div>
</div>
<div class="form-group">
	<label class="col-form-label required">High School</label>
	<input type="text" name="highschool" class="form-control flat" value="<?= $data->highschool; ?>" />
	<div class="invalid-feedback"></div>
</div>
<div class="form-group">
	<label class="col-form-label required">Exterior Image</label>
	<div class="custom-file">
		<input type="file" id="exteriorimage" name="exteriorimage" class="custom-file-input" accept="image/jpeg" />
		<div class="invalid-feedback"></div>
		<label class="form-control flat custom-file-label">(select exterior image)</label>		
	</div>	
	<?php if (!empty($data->exteriorimage)): ?>
	<div class="row row-thumb mt-2">
		<div class="col-4 col-sm-3 col-thumb">
			<a href="<?= $data->exteriorimage; ?>" data-lightbox="exterior-images">
				<img src="<?= $data->exteriorimage; ?>" class="img-fluid img-shadow" alt="exterior image" />
			</a>
		</div>
	</div>
	<?php endif; ?>
</div>