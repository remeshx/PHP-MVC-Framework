@extends('web/layouts/app')

@section('content')

	<h1>HOME</h1>
	<section>
		<?php foreach ($posts as $post) { ?>
			<section style="display: inline-block; width: 20%;">
				<section>
					<img src="<?= unserialize($post->image)['images']['600x400'] ?>" style="width: 100%;">
				</section>
				<p><a href="<?= route("home.post", [ 'id' => $post->id ]) ?>"><?= $post->title ?></a></p>
				<p><a href="<?= route("home.category", [ 'id' => $post->cat_id ]) ?>"><?= $post->body ?></a></p>
			</section>
		<?php } ?>
	</section>
		
@endsection