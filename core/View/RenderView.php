<?php

namespace Core\View;


class RenderView
{
	private $currentFileContent;
	private $extendFileContent;
	private $outputContent;
	private $sectionsContentArray = [];
	private $sectionsNameArray = [];
	private $viewProviderObject;

	private $providerValues = [];
	
	public function __construct()
	{
		$this->viewProviderObject = new \App\ViewProvider();
	}

	public function run($dir, $vars = [])
	{
		$this->getCurrentFileContent($dir);
		$this->sectionsInjection();
		$this->outputContent = !empty($this->extendFileContent) ? $this->extendFileContent : $this->currentFileContent;
		$this->includesInjection();
		return [ 'providerValues' => $this->providerValues, 'content' => $this->outputContent ];
	}

	private function readFileContent($dir)
	{
		$this->viewProviderObject->setCurrentViewName($dir);
		$this->viewProviderObject->boot();
		$this->providerValues = array_merge($this->providerValues, $this->viewProviderObject->getProviderValues());
		return htmlentities(file_get_contents("../app/view/$dir.php"));
	}

	private function getCurrentFileContent($dir)
	{
		$this->currentFileContent = $this->readFileContent($dir);
	}

	private function sectionsInjection()
	{
		if($this->checkExtendsInContent()){
			$this->fillSectionsContentArray();
			$this->replaceYields();
			$this->removeUnfulfilled();
		}
	}

	private function checkExtendsInContent()
	{
		$matches = [];
		preg_match("/s*@extends+\('([^)]+)'\)/", $this->currentFileContent, $matches, PREG_UNMATCHED_AS_NULL);
		if(!empty($matches)){
			$extendPath = $matches[1];
			$this->extendFileContent = $this->readFileContent($extendPath);
			return true;
		}
		return false;
	}

	private function findSectionsNamesInContent()
	{
		$sectionsNameArray = [];
		preg_match_all("/@section+\('([^)]+)'\)/", $this->currentFileContent, $sectionsNameArray, PREG_UNMATCHED_AS_NULL);
		$this->sectionsNameArray =  empty($sectionsNameArray) ? [] : $sectionsNameArray[1];
	}

	private function fillSectionsContentArray()
	{
		$this->findSectionsNamesInContent();
		foreach ($this->sectionsNameArray as $sectionName) {
			$array = [];
			$pattern = "/(?<=@section\('".$sectionName."'\))(.|[^.])*?(?=@endsection)/";
			preg_match($pattern, $this->currentFileContent, $array, PREG_UNMATCHED_AS_NULL);
			$this->sectionsContentArray[$sectionName] = $array[0];
		}
	}

	private function replaceYields()
	{
		foreach ($this->sectionsNameArray as $sectionName) {
			$this->extendFileContent = str_replace(htmlentities("@yield('$sectionName')"), $this->sectionsContentArray[$sectionName], $this->extendFileContent);
		}
	}	

	private function removeUnfulfilled()
	{
		$matches = [];
		preg_match_all("/@yield+\('([^)]+)'\)/", $this->extendFileContent, $matches, PREG_UNMATCHED_AS_NULL);
		$unFulFilledYield = $matches[0];
		foreach ($unFulFilledYield as $yield) {
			$this->extendFileContent = str_replace($yield, "", $this->extendFileContent);
		}
	}

	private function includesInjection()
	{ 
		while(true){
			$includesPathArray = [];
			preg_match_all("/@include+\('([^)]+)'\)/", $this->outputContent, $includesPathArray, PREG_UNMATCHED_AS_NULL);
			// replace include by contents
			if(empty($includesPathArray[1])) break;
			foreach ($includesPathArray[1] as $includesPath) {
				$includeContent = $this->readFileContent($includesPath);
				$this->outputContent = str_replace(htmlentities("@include('$includesPath')"), $includeContent, $this->outputContent);
			}
		}
	}
}