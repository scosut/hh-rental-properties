<?php foreach([1, 2, 3] as $num): ?>
<div class="inner-card">
	<div class="inner-card-title form-group">
		<label class="col-form-label">REFERENCE <?= $num; ?> <span class="sidenote">(non-relative)</span></label>
	</div>
	<div class="inner-card-body">
		<div class="form-group">
			<label class="col-form-label required">Name</label>
			<input type="text" name="name<?= $num; ?>" class="form-control flat" />
			<div class="invalid-feedback"></div>
		</div>
		<div class="form-group">
			<label class="col-form-label required">Phone</label>
			<input type="text" name="phone<?= $num; ?>" class="form-control flat" data-inputmask="'mask': '(999) 999-9999'" 
			/>
			<div class="invalid-feedback"></div>
		</div>
		<div class="form-group">
			<label class="col-form-label required">Relationship</label>
			<input type="text" name="relationship<?= $num; ?>" class="form-control flat" />
			<div class="invalid-feedback"></div>
		</div>
		<div class="form-group">
			<label class="col-form-label required">Years Known</label>
			<input type="text" name="yearsKnown<?= $num; ?>" class="form-control flat" />
			<div class="invalid-feedback"></div>
		</div>
		<div class="form-group">
			<label class="col-form-label required">Address</label>
			<input type="text" name="address<?= $num; ?>" class="form-control flat" />
			<div class="invalid-feedback"></div>
		</div>
	</div>
</div>
<?php endforeach; ?>