<?php
	if(!$log)exit;
	
	if(!isset($_GET['file'])||!isset($_GET['root'])){
		die("Hacking attempt");
	}
?>
	<header>
		<div class='header'>
			<span class='root'><?php echo $language['editor']; ?></span>
			<span class='root sub' title='<?php echo $_GET['root']; ?>'><?php echo $_GET['file']; ?></span>
			<button onclick='document.getElementById("content").value = editor.getValue();$("#theForm").submit()' class='button' style='float:right;margin-right:10px;margin-top:4px;'><?php echo "<img src='".$connect['url']."/Sources/Admin/images/icons/accept.png'>".$language['save']; ?></button>
		</div>
	</header>
<form id='theForm' action='admin.php?action=savePage&root=<?php echo $_GET['root']; ?>&edit=true&return=coding&file=<?php echo $_GET['file']; ?>' method='post'>
	<textarea id='content' name='content'><?php echo file_get_contents($_GET['root']."/".$_GET['file']); ?></textarea>
	<link rel=stylesheet href="./Sources/Codemirror/lib/codemirror.css">
	<script src="./Sources/Codemirror/lib/codemirror.js"></script>
	<script src="./Sources/Codemirror/mode/xml/xml.js"></script>
	<script src="./Sources/Codemirror/mode/javascript/javascript.js"></script>
	<script src="./Sources/Codemirror/mode/css/css.js"></script>
	<script src="./Sources/Codemirror/mode/htmlmixed/htmlmixed.js"></script>
	<script src="./Sources/Codemirror/addon/edit/matchbrackets.js"></script>
	<script>
	var editor = CodeMirror.fromTextArea(document.getElementById("content"), {
		  lineNumbers: true,
		  mode: "text/html",
		  matchBrackets: true,
		});
		
		function resolutionChange()
		{
		editor.setSize((document.getElementById("content").style.width), (document.body.clientHeight-92));
		t=setTimeout(function(){resolutionChange()},500);
		}
		
		resolutionChange();
	</script>
	<style>
	#coding {
	height:1200px;
	}
	.content-header ul {margin:0;}
	</style>
</form>