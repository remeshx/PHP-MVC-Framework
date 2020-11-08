<?php

namespace App\Controller;


use \App\Model\Category;
use \App\Model\Post;

class HomeController
{
	public function index()
	{
		$posts = Post::all();
		return view("web/index", compact('posts'));
	}

	public function category($id)
	{
		$category = new Category();
		$posts = $category->posts($id);
		$category = Category::find($id);
		return view("web/category", compact('posts', 'category'));
	}

	public function post($id)
	{
		$post = Post::find($id);
		return view("web/post", compact('post'));
	}

	public function api()
	{
		$posts = $this->env->all();
		$data = apiData($posts, function($data){
			return [
				'id' => $data->id,
				'title' => $data->title,
				'body' => $data->body,
				'image' => unserialize($data->image)['images']['600x400'],
				'created_at' => date( 'Y M d',strtotime($data->created_at)),
			];
		});
		return response($data, 'success', 403);
	}

}