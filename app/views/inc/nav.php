<nav class="navbar navbar-expand-md sticky-top">
	<div class="container">
		<a class="navbar-brand" href="/"><img src="/public/img/logo.png"></a>
		<button id="navbarToggler" class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navbarTogglerContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarTogglerContent">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<a class="nav-link<?= Utility::setActive('/') ?>" href="/">ABOUT US</a>
				</li>            				
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle<?= Utility::setActive('/properties') ?><?= Utility::setActive('/apply') ?>" href="#" id="navbarRentDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">RENT</a>
					<div id="navbarRentDropdownContent" class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarRentDropdown">
						<a class="dropdown-item" href="/properties">Properties</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="/apply">Apply</a>
					</div>
				</li>
				<?php if (Utility::isAdmin()): ?>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle<?= Utility::setActive('/properties/dashboard') ?><?= Utility::setActive('/applicants') ?>" href="#" id="navbarAdminDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">ADMIN</a>
					<div id="navbarAdminDropdownContent" class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarRentDropdown">
						<a class="dropdown-item" href="/properties/dashboard">Properties</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="/applicants">Applicants</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="/logout">Logout</a>
					</div>
				</li>
				<?php else: ?>
				<li class="nav-item">
					<a class="nav-link<?= Utility::setActive('/login') ?>" href="/login">LOGIN</a>
				</li>
				<?php endif; ?>
			</ul>
		</div>
	</div>
</nav>