<?php 
							if($filetype=="PHP file"){
								$icon = "<img src='".$connect['url']."/Sources/Admin/images/icons/page_white_php.png'>";
								$editor = 1;
							}elseif($filetype=="Stylesheet file"){
								$icon = "<img src='".$connect['url']."/Sources/Admin/images/icons/css.png'>";
								$editor = 1;
							}elseif($filetype=="HTML file"){
								$icon = "<img src='".$connect['url']."/Sources/Admin/images/icons/html.png'>";
								$editor = 1;
							}elseif($filetype=="Stylesheet file"){
								$icon = "<img src='".$connect['url']."/Sources/Admin/images/icons/page_white.png'>";
								$editor = 0;
							}elseif($filetype=="Javascript file"){
								$icon = "<img src='./sources/admin/images/icons/fileselector/js.png'>";
								$editor = 0;
							}elseif($filetype=="Icon"){
								$icon = "<img src='".$connect['url']."/Sources/Admin/images/icons/image.png'>";
								$editor = 0;
							}elseif($filetype=="PNG image"){
								$icon = "<img src='".$connect['url']."/Sources/Admin/images/icons/image.png'>";
								$editor = 0;
							}elseif($filetype=="GIF image"){
								$icon = "<img src='".$connect['url']."/Sources/Admin/images/icons/image.png'>";
								$editor = 0;
							}elseif($filetype=="JPEG image"){
								$icon = "<img src='".$connect['url']."/Sources/Admin/images/icons/image.png'>";
								$editor = 0;
							}elseif($filetype=="MSPAINT image"){
								$icon = "<img src='".$connect['url']."/Sources/Admin/images/icons/image.png'>";
								$editor = 0;
							}elseif($filetype=="TRUEVISION image"){
								$icon = "<img src='".$connect['url']."/Sources/Admin/images/icons/image.png'>";
								$editor = 0;
							}elseif($filetype=="PDF file"){
								$icon = "<img src='./Sources/Admin/images/icons/page_white_acrobat.png'>";
								$editor = 0;
							}elseif($filetype=="ZIP file"){
								$icon = "<img src='./Sources/Admin/images/icons/box.png'>";
								$editor = 0;
							}elseif($filetype=="RAR file"){
								$icon = "<img src='./Sources/Admin/images/icons/box.png'>";
								$editor = 0;
							}elseif($filetype=="WORD document"){
								$icon = "<img src='./Sources/Admin/images/icons/page_word.png'>";
								$editor = 0;
							}elseif($filetype=="EXCEL document"){
								$icon = "<img src='./Sources/Admin/images/icons/page_excel.png'>";
								$editor = 0;
							}elseif($filetype=="POWERPOINT"){
								$icon = "<img src='./Sources/Admin/images/icons/page_white_powerpoint.png'>";
								$editor = 0;
							}elseif($filetype=="Execution file"){
								$icon = "<img src='./Sources/Admin/images/icons/application.png'>";
								$editor = 0;
							}else{
								$icon = "<img src='".$connect['url']."/Sources/Admin/images/icons/page_white.png'>";
								$editor = 0;
							}
?>