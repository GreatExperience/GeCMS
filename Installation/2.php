<?php 
    
    if(isset($_GET['msg'])){
	
	echo '<div class="alert">'.$_GET['msg'].'</div>';
	
	if(isset($_GET['database'])){$_POST['database'] = $_GET['database'];}
    }
    
        if(!isset($_POST['database']))die('We are missing some data! Please restart the installation!');
?>
<form action='./install.php?step=3' method='post' onsubmit='$("#dis").removeAttr( "disabled" );'>
    <h1>Connection to the database</h1>
    <p>Please make sure all data is correct in order to continue the installation</p>

    <table style='width:100%;max-width:1000px;text-align:right;font-weight:bold;'>
	<tr>
	    <td style='width:175px;'>Database</td>
	    <td style='text-align:left;font-weight:normal;'><input id='dis' type='text' name='database' placeholder='Where can we find the database?' value='<?php echo $_POST['database']; ?>' DISABLED /></td>
	</tr>
	<tr>
	    <td>Database server</td>
	    <td><input type='text' name='server' placeholder='Where can we find the database?' REQUIRED /></td>
	</tr>
	<tr>
	    <td>Database name</td>
	    <td><input type='text' name='serverName' placeholder='Wisch name has your database?' REQUIRED /></td>
	</tr>

	<tr>
	    <td>Database Username</td>
	    <td><input type='text' name='dbUsername' placeholder='What is your username to the database?' REQUIRED /></td>
	</tr>
	<tr>
	    <td>Database Password</td>
	    <td><input type='password' name='dbPassword' placeholder='What is your password to the database?' /></td>
	</tr>
	<tr>
	    <td>Database Prefix</td>
	    <td><input type='text' name='dbPrefix' placeholder='to be unique choose a database prefix!' REQUIRED /></td>
	</tr>
    </table>
    <h1>File system</h1>
    <p style='max-width:1000px;'>Where can we find our own system? URL is required for file includes and ROOT is required for server side includes. Default they are filled correct below, but it might be different for a selection of users.</p>
    <table style='width:100%;max-width:1000px;text-align:right;font-weight:bold;'>
	<tr>
	    <td style='width:175px;'>Website base URL</td>
	    <td><input type='text' name='webRoot' placeholder='htttp://example.com' value='<?php
	    $url = str_replace('install.php?step=2', '', $_SERVER['REQUEST_URI']);
	    $url = str_replace('/', '', $url);
	    $url = str_replace('&msg=' . (isset($_GET['msg']) ? $_GET['msg'] : ''), '', $url);
	    
	    echo $_SERVER['DOCUMENT_ROOT'] . $url . "/"; ?>' REQUIRED /></td>
	</tr>
	<tr>
	    <td>Website base ROOT</td>
	    <td><input type='text' name='webUrl' placeholder='var/www/public_html/ (example)' value='<?php
		if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']){
		    echo 'https://' . $_SERVER['HTTP_HOST'] . $url . "/";
		}else{
		    echo 'http://' . $_SERVER['HTTP_HOST'] . "/" . $url . "/";
		}
	    ?>' REQUIRED /></td>
	</tr>
    </table>
    
    <h1>Admin account</h1>
    <p>Please create a admin account. With a admin account you can login to edit the website.</p>
    <table style='width:100%;max-width:1000px;text-align:right;font-weight:bold;'>
	<tr>
	    <td style='width:175px;'>Username</td>
	    <td><input type='text' name='username' placeholder='Please enter a Username! (5-30)' pattern=".{5,30}" REQUIRED /></td>
	</tr>
	<tr>
	    <td>Password</td>
	    <td><input type='password' name='password' placeholder='Please enter a save password! (5-30)' pattern=".{5,30}" REQUIRED /></td>
	</tr>
	<tr>
	    <td>Re: Password</td>
	    <td><input type='password' name='passwordRE' placeholder='Re-enter the password!' REQUIRED /></td>
	</tr>

	<tr>
	    <td>mail</td>
	    <td><input type="email" name='mail' placeholder='What is your mail adress?' REQUIRED /></td>
	</tr>
    </table>
    <h1>That was it!</h1>
    <input type='submit' value='Confirm' class='submit' style='width:100px !important;' />
</form>
<?php
    if(!isset($_POST['database'])){
	echo 'Where is your data?';
    }
?>

<script>
    $('.step').css({'width': '25%'});
    $('.step').animate({'width': '50%'});
</script>
<style>
    input {margin:5px !important;width:100% !important;}
</style>