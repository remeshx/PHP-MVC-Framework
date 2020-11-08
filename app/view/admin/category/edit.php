@extends('admin/layouts/app')

@section('content')

	<h1>Update Category</h1>
	<section><a href="<?= route("admin.category.index") ?>">back</a></section>
	<section>
		<form action="<?= route("admin.category.update", ['id' => $category->id]) ?>" method="post">
			<?= csrf() ?>
			<section>
				<label for="name">Name</label>
				<input type="text" id="name" name="name" value="<?= $category->name ?>">
			</section>
			<section>
				<input type="submit" value="save">
			</section>
		</form>
	</section>
		
@endsection

