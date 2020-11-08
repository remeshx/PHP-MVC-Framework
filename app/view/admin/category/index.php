@extends('admin/layouts/app')

@section('content')
	<h1>Category</h1>
	<section><a href="<?= route("admin.category.create") ?>">create</a></section>
	<table>
		<tr>
			<td>id</td>
			<td>name</td>
			<td>created at</td>
			<td>setting</td>
		</tr>
		<?php foreach ($categories as $category) { ?>
			<tr>
				<td><?= $category->id ?></td>
				<td><?= $category->name ?></td>
				<td><?= $category->created_at ?></td>
				<td>
					<a href="<?= route("admin.category.edit", [ 'id' => $category->id ]) ?>">edit</a>
					<a href="<?= route("admin.category.delete", [ 'id' => $category->id ]) ?>">delete</a>
				</td>
			</tr>
		<?php } ?>
	</table>
		
@endsection

