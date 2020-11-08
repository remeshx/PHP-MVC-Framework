@extends('admin/layouts/app')

@section('content')

	<h1>Create Category</h1>
	<section><a href="<?= route("admin.category.index") ?>">back</a></section>
	<section>
		<form action="<?= route("admin.category.store") ?>" method="post">
			<?= csrf() ?>
			<section>
				<label for="name">Name</label>
				<input type="text" id="name" name="name">
			</section>
			<section>
				<input type="submit" value="save">
			</section>
		</form>
	</section>
		
@endsection

