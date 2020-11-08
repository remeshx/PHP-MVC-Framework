<?php

namespace App\Controller\Admin;


use \App\Model\Category;
use \Core\Debug\Debug;
use \Core\BaseControllers\AdminController;

class CategoryController extends AdminController
{

	public function index()
	{
		$categories = Category::all();
		return view("admin/category/index", compact("categories"));
	}

	public function create()
	{
		return view("admin/category/create");
	}

	public function store()
	{
		$category = Category::create($this->env->all());
		return isset($category) ? redirect(route("admin.category.index")) : back() ;
	}

	public function edit($id)
	{
		$category = Category::find($id);
		return view("admin/category/edit", compact("category"));
	}

	public function update($id)
	{
		$category = Category::update(array_merge($this->env->all(), ["id" => $id]));
		return isset($category) ? redirect(route("admin.category.index")) : back() ;
	}

	public function delete($id)
	{
		Category::delete($id);
		return back();
	}

	protected function input_rules()
	{
		return [
			"name" => "required|min:6|max:12"
		];
	}

	protected function input_unfilterPostInputs()
	{
		return [
			"name"
		];
	}

	

}