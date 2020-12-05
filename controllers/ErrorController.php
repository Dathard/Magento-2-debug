<?php 

class ErrorController
{
	public static function actionNotFound()
	{
		$categories = array();
		$categories = Category::getCategoriesList();
		
		require_once(ROOT.'/views/errors/not-found.php');
	}
}