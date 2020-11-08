<?php

namespace App\Controller\Admin;


use \App\Model\Category;
use \App\Model\Post;
use \Core\BaseControllers\AdminController;

class PostController extends AdminController
{

	public function index()
	{
		$posts = Post::all();
		return view("admin/post/index", compact("posts"));
	}

	public function create()
	{
		// if(errorExist())
		// {
		// 	dd(allErrors());
		// }
		$categories = Category::all();
		return view("admin/post/create", compact("categories"));
	}

	public function store()
	{
		//dd(uploadFileStorage(env()->file("image"), "images/posts/".date('Y_m_d_H_i_s'), date('Y_m_d_H_i_s')));
		$image = fitArrayUploadedImage($this->env->file("image"), [[400,300],[600,400],[90,60]], "images/posts/".date("Y_m_d_H_i_s"), date("Y_m_d_H_i_s"));
		$post = Post::create(array_merge($this->env->all() , ["image" => serialize($image)]));
		return isset($post) ? redirect(route("admin.post.index")) : back() ;
	}

	public function edit($id)
	{
		$post = Post::find($id);
		$categories = Category::all();
		return view("admin/post/edit", compact("post", "categories"));
	}

	public function update($id)
	{
		if($this->env->file("image")){
			delete_directory(unserialize(Post::find($id)->image)['directory']);
			$image = fitArrayUploadedImage($this->env->file("image"), [[400,300],[600,400],[90,60]], "images/posts/".date("Y_m_d_H_i_s"), date("Y_m_d_H_i_s"));
			$allEnv = array_merge($this->env->all(), [ "image" => serialize($image) ]);
			$post = Post::update(array_merge($this->env->all(), [ "image" => serialize($image), "id" => $id]));
		}else{
			$post = Post::update(array_merge($this->env->all(), ["id" => $id]));
		}
		return isset($post) ? redirect(route("admin.post.index")) : back() ;
	}

	public function delete($id)
	{
		$post = Post::find($id);
		if(!empty($post))
			delete_directory(unserialize($post->image)['directory']);
		Post::delete($id);
		return back();
	}

}