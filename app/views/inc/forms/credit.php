<div class="form-group">
	<label class="d-block col-form-label required">Declared bankruptcy in past 7 years?</label>
	<input type="hidden" name="bankrupt" />
	<div class="invalid-feedback"></div>
	<div class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="bankrupt[]" id="<?= $formId; ?>-bankrupt-yes" value="yes">
		<label class="form-check-label" for="<?= $formId; ?>-bankrupt-yes">Yes</label>
	</div>
	<div class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="bankrupt[]" id="<?= $formId; ?>-bankrupt-no" value="no">
		<label class="form-check-label" for="<?= $formId; ?>-bankrupt-no">No</label>
	</div>
</div>
<div class="form-group">
	<label class="d-block col-form-label required">Evicted from a rental residence?</label>
	<input type="hidden" name="evicted" />
	<div class="invalid-feedback"></div>
	<div class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="evicted[]" id="<?= $formId; ?>-evicted-yes" value="yes">
		<label class="form-check-label" for="<?= $formId; ?>-evicted-yes">Yes</label>
	</div>
	<div class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="evicted[]" id="<?= $formId; ?>-evicted-no" value="no">
		<label class="form-check-label" for="<?= $formId; ?>-evicted-no">No</label>
	</div>
</div>
<div class="form-group">
	<label class="d-block col-form-label required">Two or more late rental payments in last year?</label>
	<input type="hidden" name="latePayments" />
	<div class="invalid-feedback"></div>
	<div class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="latePayments[]" id="<?= $formId; ?>-latePayments-yes" value="yes">
		<label class="form-check-label" for="<?= $formId; ?>-latePayments-yes">Yes</label>
	</div>
	<div class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="latePayments[]" id="<?= $formId; ?>-latePayments-no" value="no">
		<label class="form-check-label" for="<?= $formId; ?>-latePayments-no">No</label>
	</div>
</div>
<div class="form-group">
	<label class="d-block col-form-label required">Convicted of a crime?</label>
	<input type="hidden" name="convicted" />
	<div class="invalid-feedback"></div>
	<div class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="convicted[]" id="<?= $formId; ?>-convicted-yes" value="yes">
		<label class="form-check-label" for="<?= $formId; ?>-convicted-yes">Yes</label>
	</div>
	<div class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="convicted[]" id="<?= $formId; ?>-convicted-no" value="no">
		<label class="form-check-label" for="<?= $formId; ?>-convicted-no">No</label>
	</div>
</div>
<div id="<?= $formId; ?>-expanded-content" style="display:none;">
	<div class="form-group">
		<label class="col-form-label required">Explain any &quot;yes&quot; listed above</label>
		<textarea name="explanation" class="form-control flat"></textarea>
		<div class="invalid-feedback"></div>
	</div>
</div>