<div class="wrapper-sidebar">
	<div class="sidebar">
		<div class="sidebar-header">
			<h2>Kатегорії товарів</h2>
		</div>
		<ul>
			<li>
				<a href="/">
					Усі товари
				</a>
			</li>
			<?php foreach ($categories as $categoryItem):?>
				<li>
					<a href="/category/<?php echo $categoryItem['id']; ?>">
						<?php echo $categoryItem['name']; ?>
					</a>
				</li>
			<?php endforeach ?>
		</ul>
	</div>
</div>