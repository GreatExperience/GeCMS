<?php
	/* This variable will be used as result */
	$newsOutput = "";
	
	/* check if article is selected */
	if(isset($_GET['article'])){
	
		/* Article selected */
		require_once($connect['root'] . "Sources/News/article.news.php");
		
	}else{
	
		/* Article selected */
		require_once($connect['root'] . "Sources/News/overview.news.php");
	}
	
?>