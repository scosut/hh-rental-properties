<div class="form-group">
	<Label class="col-form-label">Anything to help the owner evaluate this application</Label>
	<textarea name="additionalInfo" class="form-control flat"></textarea>
</div>
<div class="form-group">
	<label class="col-form-label required">Terms</label>
		<input type="hidden" name="terms" />
		<div class="invalid-feedback"></div>
	<div class="form-check">
		<input class="form-check-input" type="checkbox" id="additional-terms" name="terms[]" value="yes" />
		<label class="form-check-label" for="additional-terms">I certify that I have read and understand the <a href="#" class="form-link form-link-decorated" data-toggle="modal" data-target="#termsModal">terms</a> of this rental application.</label>
	</div>
</div>
<div class="form-group">
	<label class="col-form-label required">Applicant Signature</label>
	<input type="text" name="signatureApp" class="form-control flat" />
</div>
<div id="additional-signatureCoapp" class="form-group" style="display:none;">
	<label class="col-form-label required">Co-Applicant Signature</label>
	<input type="text" name="signatureCoapp" class="form-control flat" />
</div>