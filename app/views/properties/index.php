<?php $page_name = "Our Properties"; ?>

<?php require APP_ROOT."/views/inc/header.php"; ?>

<div class="main-heading">
	<div class="container">
		<h1>Our Properties</h1>
	</div>
</div>

<div class="container">
	<div class="row mt-5">
		<?php $pageNum=1; ?>
		<?php foreach($data["properties"] as $page): ?>
		<?php foreach($page as $p): ?>
		<div class="col-sm-6 col-md-4 mb-5 pagenum-<?= $pageNum; ?>">
			<div class="card card-property">
				<div class="card-img-wrapper <?= $p->formattedStatus; ?>">
					<span class="card-price"><?= $p->formattedRent ?></span>
					<img class="card-img-top" src="<?= $p->exteriorimage ?>" alt="exterior image" />
				</div>
				<div class="card-body">
					<h5 class="card-title">
						<?= $p->address ?>
						<span><?= "$p->city, $p->state $p->zip" ?></span>
					</h5>
					<div class="card-details">
						<div class="card-details-item">
							<div><i class="fa fa-th-large"></i> Sqft: <?= $p->sqft ?></div>
							<div><i class="fa fa-bed"></i> Bdrm: <?= $p->bedrooms ?></div>
						</div>
						<div class="card-details-item">
							<div><i class="fa fa-car"></i> Garage: <?= $p->garage ?></div>
							<div><i class="fa fa-shower"></i> Bath: <?= $p->formattedBathrooms ?></div>
						</div>
						<div class="card-details-item w-100"></div>
							<div class="card-details-item w-100">
							<a href="/properties/<?= $p->id; ?>" class="btn btn-more">MORE INFO</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php endforeach; ?>
		<?php $pageNum++; ?>
		<?php endforeach; ?>
	</div>
	
	<?php if(count($data["properties"]) > 1): ?>
	<?php $pageNum=1; ?>
	<nav class="d-flex d-sm-block justify-content-center mb-5" aria-label="Page navigation example">
		<ul class="pagination pagination-sm">
			<li class="page-item">
				<a class="page-link" href="#" data-page="back"><i class="fa fa-chevron-left"></i></a>
			</li>
			<?php foreach($data["properties"] as $page): ?>
			<li class="page-item"><a href="#" class="page-link" data-page="<?= $pageNum; ?>"><?= $pageNum; ?></a></li>
			<?php $pageNum++; ?>
			<?php endforeach; ?>
			<li class="page-item">
				<a class="page-link" href="#" data-page="next"><i class="fa fa-chevron-right"></i></a>
			</li>
		</ul>
	</nav>	
	<?php endif; ?>
</div>

<?php require APP_ROOT."/views/inc/footer.php"; ?>