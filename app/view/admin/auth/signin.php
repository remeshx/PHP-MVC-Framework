@extends('admin/layouts/app')

@section('content')
	<h1>Please Sign in :</h1>
	<?PHP echo flash('LOGIN-ERROR'); ?>
	<section>
		<form action="<?= route("admin.auth.signin") ?>" method="post" enctype="multipart/form-data">
			<?= csrf() ?>
			<section>
				<label for="title">user</label>
				<input type="text" id="title" name="username">
			</section>
			<section>
				<label for="body">Password</label>
				<input type="text" id="body" name="password">
			</section>
			<section>
				<input type="submit" value="sign in">
			</section>
		</form>
	</section>
		
@endsection

