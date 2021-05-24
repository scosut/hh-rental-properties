<?php $page_name = "Administrator Login"; ?>
<?php require APP_ROOT."/views/inc/header.php"; ?>

<div class="main-heading">
	<div class="container">
		<h1>Administrator Login</h1>
	</div>
</div>

<div class="container">
	<div class="card card-form mb-5">
		<div class="card-body">
			<h2 class="card-title">LOGIN INFORMATION</h2>
			<p class="form-legend">(<span class="text-required">*</span> indicates a required field)</p>
			<form id="login" class="form" action="/pages/login" autocomplete="off">
				<div class="form-group">
					<label for="email" class="col-form-label required">Username</label>
					<input type="text" name="username" class="form-control flat">
					<div class="invalid-feedback"></div>
				</div>
				<div class="form-group">
					<label for="password" class="col-form-label required">Password</label>
					<input type="password" name="password" class="form-control flat">
					<div class="invalid-feedback"></div>
				</div>                     
				<div class="form-group">
					<button type="submit" class="btn btn-next">LOGIN</a>
				</div>
			</form>
		</div>
	</div>
</div>

<?php require APP_ROOT."/views/inc/footer.php"; ?>