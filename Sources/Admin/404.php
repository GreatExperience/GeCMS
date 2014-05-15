<?php
    /*
     *  404 ERROR SYSTEM
     * 
     *  Required existing variable : $cmsError;
     * 
     */

     if(isset($cmsError))
	 echo "
		<div style='text-align:center;'><img src='./sources/admin/images/gelogo.png' style='width:15%;margin:0 auto;margin-top:10%;' /></div>
		<h1 style='font-size:80px;color:#555;text-align:center;'>404 ERROR</h1>
		<p style='text-align:center;font-size:24px;'>".$cmsError."</p>";
?>