<?php if(!$log==true)exit; ?>
				<header>
					<div class='header'>
						<button class='root'><?php echo $language['menu']; ?></button>
						<button class='root sub'><?php echo $language['menuSide']; ?></button>
						<button class='button blue' onclick='document.forms["form1"].submit();' style='float:right;margin-right:10px;margin-top:4px;'><img src='./Sources/Admin/images/icons/accept.png'/><?php echo $language['save']; ?></button>
					</div>
				</header>
				<div id='content'>
							<div class='left'>
								<div class='box' style='width:100%;'>
									<div class='title'><?php echo $language['menuSide']; ?></div>
									<div class='pad'>
										<?php echo $language['menuSideInfo']; ?>
									</div>
								</div>
							</div>
							<div class='right'>
								<form action='./admin.php?action=menuSideSave' method='post' id='form1'><textarea id='editor1' name='editor1' style='width:100%;'><?php echo $settings['siteMenu']; ?></textarea></form>
								<script>
									function getDocHeight() {
								var doc = document;
								return Math.max(
									Math.max(doc.body.scrollHeight, doc.documentElement.scrollHeight),
									Math.max(doc.body.offsetHeight, doc.documentElement.offsetHeight),
									Math.max(doc.body.clientHeight, doc.documentElement.clientHeight)
								);
							}
							if(tinymce.init({
								height:(getDocHeight()-235),
								selector: "#editor1",
								plugins: [
									"advlist autolink lists link image charmap print preview anchor",
									"searchreplace visualblocks code fullscreen",
									"insertdatetime media table contextmenu paste"
								],
								menu: { 
											file: {title: 'File'}, 
											edit: {title: 'Edit', items: 'undo redo | cut copy paste | selectall | searchreplace'}, 
											insert: {title: 'Insert', items: 'inserttable image media link | hr charmap'}, 
											format: {title: 'Format', items: 'bold italic underline strikethrough superscript subscript | formats | removeformat'}, 
											tools: {title: 'Tools', items: 'code'} 
										},
								toolbar: "insertfile undo redo | styleselect fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
								file_browser_callback : myFileBrowser,
							}))
						    
						    function myFileBrowser (field_name, url, type, win) {
							window.fileInput = field_name;
							window.hideIt = win;

							/* If you work with sessions in PHP and your client doesn't accept cookies you might need to carry
							   the session name and session ID in the request string (can look like this: "?PHPSESSID=88p0n70s9dsknra96qhuk6etm5").
							   These lines of code extract the necessary parameters and add them back to the filebrowser URL again. */

							var cmsURL = "./admin.php?action=displayMedia&layout=false&root=./Media"
							if (cmsURL.indexOf("?") < 0) {
							    //add the type as the only query parameter
							    cmsURL = cmsURL + "?type=" + type;
							}
							else {
							    //add the type as an additional query parameter
							    // (PHP session ID is now included if there is one at all)
							    cmsURL = cmsURL + "&dialog=&type=" + type;
							}

							tinyMCE.activeEditor.windowManager.open({
							    file : cmsURL,
							    title : '<?php echo $language['mediaInsert']; ?>...',
							    width : (document.body.clientWidth / 100 ) * 80,  // Your dimensions may differ - toy around with them!
							    height : (document.body.clientHeight / 100 ) * 80,
							    resizable : "yes",
							    inline : "yes",  // This parameter only has an effect if you use the inlinepopups plugin!
							    close_previous : "no"
							}, {
							    window : win,
							    input : field_name,
							});
							return false;
						      }

						    window.fileNamespace = "";
						    window.fileInput = "Not set";
						     window.hideIt = "set";
								</script>
							</div>
				</div>