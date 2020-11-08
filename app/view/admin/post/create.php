@extends('admin/layouts/app')

@section('content')

	<h1>Create Post</h1>
	<section><a href="<?= route("admin.post.index") ?>">back</a></section>
	<section>
		<form action="<?= route("admin.post.store") ?>" method="post" enctype="multipart/form-data">
			<?= csrf() ?>
			<section>
				<label for="title">Title</label>
				<input type="text" id="title" name="title">
			</section>
			<section>
				<label for="body">Body</label>
				<input type="text" id="body" name="body">
			</section>
			<section>
				<label for="image">Image</label>
				<input type="file" id="image" name="image">
			</section>
			<section>
				<label for="cat_id">Category ID</label>
				<select id="cat_id" name="cat_id" required>
					<?php foreach ($categories as $category) { ?>
						<option value="<?= $category->id ?>"><?= $category->name ?></option>
					<?php } ?>
				</select>
			</section>
			<section>
				<input type="submit" value="save">
			</section>
		</form>
	</section>
		
@endsection

