<?php $page_name = "Application Criteria"; ?>
<?php require APP_ROOT."/views/inc/header.php"; ?>

<div class="main-heading">
	<div class="container">
		<h1>Application Criteria</h1>
	</div>
</div>

<div class="property mb-5">
	<div class="container">
		<div class="row">
			<div class="col-md-8 mb-2 mb-md-0 pr-md-0">
				<img src="/public/img/for_rent.jpg" alt="house for rent" class="img-fluid img-shadow" />
			</div>
			<div class="col-md-4 mt-3 mt-md-0 pr-md-0">
				<div class="message-box">
					<?php if($data["count"] > 0): ?>
					<p>Click the button to complete our online form. Applications will be processed in 2&#8209;3 business days. Make sure you meet all requirements listed below before applying.</p>
					<a href="/application" class="btn btn-schedule mt-1">APPLY NOW</a>
					<?php else: ?>
					<p>Thank you for your interest in one of our properties. Currently, all properties are rented. Please check back at a later time to see what is available.</p>
					<img src="/public/img/none_available.png" class="mx-auto d-block" alt="no houses available" />
					<?php endif; ?>
				</div>            
			</div>
		</div>
		<div class="row mt-5">
			<div class="col">
				<p>All applicants are required to submit a rental application and authorize a credit &amp; background check. After submitting an application, Tenants will receive an email with a link to Rent Prep for their credit and background check. Tenant will supply their information and pay the fee directly to Rent Prep. Successful applicants will be reimbursed for this fee.</p>
			</div>
		</div>
		<div class="row mt-4">
			<div class="col">
				<h2 class="mb-4">Eligibility Requirements</h2>            

				<div class="details">
					<div class="details-row">
						<div class="details-col">Credit score of 600 or higher</div>
					</div>
					<div class="details-row">
						<div class="details-col">Positive credit references</div>
					</div>
					<div class="details-row">
						<div class="details-col">Verifiable employment &mdash; must provide last 3 months paystubs</div>
					</div>
					<div class="details-row">
						<div class="details-col">Income &mdash; rent must be no more than <sup>1</sup>/<sub>3</sub>&nbsp;&nbsp;of income</div>
					</div>
					<div class="details-row">
						<div class="details-col">Favorable landlord references</div>
					</div>
					<div class="details-row">
						<div class="details-col">Able to pass a background check</div>
					</div>
					<div class="details-row">
						<div class="details-col">Have first month's rent and deposit available</div>
					</div>
					<div class="details-row">
						<div class="details-col">No roommate situations</div>
					</div>
					<div class="details-row">
						<div class="details-col">No smoking</div>
					</div>
					<div class="details-row">
						<div class="details-col">No pets</div>
					</div>
				</div>            
			</div>
		</div>
	</div>      
</div>

<?php require APP_ROOT."/views/inc/footer.php"; ?>