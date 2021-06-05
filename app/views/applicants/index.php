<?php $page_name = "Administrator Dashboard"; ?>
<?php require APP_ROOT."/views/inc/header.php"; ?>

<div class="main-heading">
	<div class="container">
		<h1>Administrator Dashboard</h1>
	</div>
</div>

<div class="container">
	<div class="d-flex align-items-center justify-content-between mb-3">
		<h2 class="dashboard-title">Applicants</h2>
		<?php if(count($data["applicants"]) > 0): ?>
		<a href="/applicants/export" class="dashboard-link" data-toggle="tooltip" data-placement="bottom" title="export Excel">
			<i class="fa fa-table"></i>
		</a>
		<?php endif; ?>
	</div>
	<?php if(count($data["applicants"]) > 0): ?>
	<div class="table-responsive mb-5">
		<table class="dashboard-table table table-bordered table-striped">
			<thead>
				<tr>
					<th>APPLICANT</th>
					<th>PROPERTY</th>
					<th>EMAIL SENT</th>
					<th>ACTION</th>
				</tr>
			</thead>
			<tbody>
				<?php $pageNum=1; ?>
				<?php foreach($data["applicants"] as $page): ?>
				<?php foreach($page as $p): ?>
				<tr class="pagenum-<?= $pageNum; ?>">
					<td><?= "$p->firstName $p->lastName"; ?></td>
					<td>
						<?= $p->address; ?><br>
						<?= "$p->city, $p->state $p->zip"; ?>
					</td>
					<td><?= $p->formattedDateEmailed; ?></td>
					<td>
						<a href='<?= "/applicants/print/{$p->propId},{$p->appId},{$p->coappId}"; ?>' class="dashboard-link edit" data-toggle="tooltip" data-placement="bottom" title="view application">
							<i class="fa fa-eye mr-2"></i>
						</a>
						<a href='<?= "/applicants/email/{$p->propId},{$p->appId},{$p->coappId}"; ?>' class="dashboard-link dashboard-link-email edit" data-toggle="tooltip" data-placement="bottom" title="send email">
							<i class="fa fa-envelope-o"></i>
						</a>						
					</td>
				</tr>				
				<?php endforeach; ?>
				<?php $pageNum++; ?>
				<?php endforeach; ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="4" class="p-0 pt-5">
						<?php if(count($data["applicants"]) > 1): ?>
						<?php $pageNum=1; ?>
						<nav class="mb-5" aria-label="Page navigation example">
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
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
	<?php else: ?>
	<p>No applicants available.</p>
	<?php endif; ?>
</div>

<?php require APP_ROOT."/views/inc/footer.php"; ?>