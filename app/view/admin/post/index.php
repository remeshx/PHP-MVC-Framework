@extends('admin/layouts/app')

@section('content')
	<h1>Post</h1>
	<section><a href="<?= route("admin.post.create") ?>">create</a></section>
	<table>
		<tr>
			<td>id</td>
			<td>title</td>
			<td>body</td>
			<td>image</td>
			<td>cat_id</td>
			<td>created at</td>
			<td>setting</td>
		</tr>
		<?php foreach ($posts as $post) { ?>
			<tr>
				<td><?= $post->id ?></td>
				<td><?= $post->title ?></td>
				<td><?= $post->body ?></td>
				<td><img src="<?= isset(unserialize($post->image)['images']['90x60']) ? unserialize($post->image)['images']['90x60'] : null ?>"></td>
				<td><?= $post->cat_id ?></td>
				<td><?= $post->created_at ?></td>
				<td>
					<a href="<?= route("admin.post.edit", [ 'id' => $post->id ]) ?>">edit</a>
					<a href="<?= route("admin.post.delete", [ 'id' => $post->id ]) ?>">delete</a>
				</td>
			</tr>
		<?php } ?>
	</table>
		
@endsection

