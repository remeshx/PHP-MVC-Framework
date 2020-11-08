@extends('web/layouts/app')

@section('content')

	<h1>Post : <?= $post->title ?></h1>
	<section>
		<section style="rgba(0,0,0,.1);">
			<p>title : <?= $post->title ?></p>
			<p>body : <?= $post->body ?></p>
			<p>category ID : <?= $post->cat_id ?></p>
			<section>
				<img src="<?= unserialize($post->image)['images']['600x400'] ?>" >
			</section>
		</section>
	</section>
		
@endsection