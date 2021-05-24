<?php $page_name = "Administrator Dashboard"; ?>
<?php require APP_ROOT."/views/inc/header.php"; ?>

<div class="main-heading">
	<div class="container">
		<h1>Administrator Dashboard</h1>
	</div>
</div>

<div class="container">
	<div class="d-flex align-items-center justify-content-between mb-3">
		<h2 class="dashboard-title">Properties</h2>
		<a href="/properties/new" class="dashboard-link" data-toggle="tooltip" data-placement="bottom" title="add property">
			<i class="fa fa-plus-square"></i>
		</a>
	</div>
	<div class="table-responsive mb-5">
		<table class="dashboard-table table table-bordered table-striped">
			<thead>
				<tr>
					<th>ADDRESS</th>
					<th>STATUS</th>
					<th>MONTHLY RENT</th>
					<th>ACTION</th>
				</tr>
			</thead>
			<tbody>
				<?php $pageNum=1; ?>
				<?php foreach($data["properties"] as $page): ?>
				<?php foreach($page as $p): ?>
				<tr class="pagenum-<?= $pageNum; ?>">
					<td>
						<?= $p->address; ?><br>
						<?= "$p->city, $p->state $p->zip"; ?>
					</td>
					<td><?= $p->status; ?></td>
					<td><?= $p->formattedRent; ?></td>
					<td>
						<a href="/properties/edit/<?= $p->id; ?>" class="dashboard-link edit" data-toggle="tooltip" data-placement="bottom" title="edit property">
							<i class="fa fa-pencil mr-2"></i>
						</a>
						<?php if ($p->imageCount > 0): ?>
						<a href="/properties/sort/<?= $p->id; ?>" class="dashboard-link edit" data-toggle="tooltip" data-placement="bottom" title="sort images">
							<i class="fa fa-sort-numeric-asc mr-2"></i>
						</a>
						<?php endif; ?>
						<a href="#" class="dashboard-link delete" data-toggle="tooltip" data-placement="bottom" title="delete property" data-property="<?= $p->id; ?>" data-address="<?= $p->address; ?>">
							<i class="fa fa-trash"></i>
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
						<?php if(count($data["properties"]) > 1): ?>
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
</div>

<div class="modal fade" id="deletePropertyModal" tabindex="-1" role="dialog" aria-labelledby="deletePropertyModal" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h2>Delete Property</h2>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">                
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body"></div>
			<div class="modal-footer">
				<form method="post">
					<button type="button" class="btn btn-back" data-dismiss="modal">CANCEL</button>
					<button type="submit" class="btn btn-next">CONFIRM</button>
				</form>
			</div>
		</div>
	</div>
</div>

<?php require APP_ROOT."/views/inc/footer.php"; ?>