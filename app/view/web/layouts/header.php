<section style="background-color: rgba(191,255,0,.7); padding: .6rem;">
	<a style="padding: .6rem .8rem;" href="<?= route("home.index") ?>">Home</a>
	<a style="padding: .6rem .8rem;" href="<?= route("admin.index") ?>">Admin</a>
	<hr/>
	<?php foreach ($categories as $headerCategory) { ?>
		<a style="padding: .6rem .8rem;" href="<?= route("home.category", ['id' => $headerCategory->id]) ?>"><?= $headerCategory->name ?></a>
	<?php } ?>
</section>