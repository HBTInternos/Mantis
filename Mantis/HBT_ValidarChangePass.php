<?php
# MantisBT - A PHP based bugtracking system

# MantisBT is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 2 of the License, or
# (at your option) any later version.
#
# MantisBT is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with MantisBT.  If not, see <http://www.gnu.org/licenses/>.

/**
 * User API
 *
 * @package CoreAPI
 * @subpackage UserAPI
 * @copyright Copyright 2000 - 2002  Kenzaburo Ito - kenito@300baud.org
 * @copyright Copyright 2002  MantisBT Team - mantisbt-dev@lists.sourceforge.net
 * @link http://www.mantisbt.org
 *
 * @uses access_api.php
 * @uses authentication_api.php
 * @uses config_api.php
 * @uses constant_inc.php
 * @uses database_api.php
 * @uses email_api.php
 * @uses error_api.php
 * @uses filter_api.php
 * @uses helper_api.php
 * @uses lang_api.php
 * @uses ldap_api.php
 * @uses project_api.php
 * @uses project_hierarchy_api.php
 * @uses string_api.php
 * @uses user_pref_api.php
 * @uses utility_api.php
 */
require_once( 'core.php' ); 
require_api( 'access_api.php' );
require_api( 'authentication_api.php' );
require_api( 'config_api.php' );
require_api( 'constant_inc.php' );
require_api( 'database_api.php' );
require_api( 'email_api.php' );
require_api( 'error_api.php' );
require_api( 'filter_api.php' );
require_api( 'helper_api.php' );
require_api( 'lang_api.php' );
require_api( 'ldap_api.php' );
require_api( 'project_api.php' );
require_api( 'project_hierarchy_api.php' );
require_api( 'string_api.php' );
require_api( 'user_pref_api.php' );
require_api( 'utility_api.php' );

use Mantis\Exceptions\ClientException;

$passErr = $changePassErr = $noigualpass = $websiteErr = $username="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$username=$_POST["hidden_username"];
	if (empty($_POST["password"])) {
	  $passErr = "La contraseña es requerida";
	  
	} else {
	  $pass = test_input($_POST["password"]);
	  
	}

	if (empty($_POST["confirmacionpassword"])) {
		$changePassErr = "La contraseña es requerida";
	  } else {
		$passconfir = test_input($_POST["confirmacionpassword"]);
	  }

	if( !empty($_POST["password"]) && !empty($_POST["confirmacionpassword"]) && $_POST["password"]!=$_POST["confirmacionpassword"]){
		
			$noigualpass='Las contraseñas no coinciden';
			
	}
	
	if(empty($pass) || empty($passconfir) || $noigualpass=='Las contraseñas no coinciden'){

		$url ='HBT_password_change.php?username='.$username.'&passErr='.$passErr.'&changePassErr='.$changePassErr.'&noigualpass='.$noigualpass;
		header("Location: ".$url);
		exit();
	}else{
		if(actualizarPassword($username,$pass)){
			$url ='login_page.php';
		header("Location: ".$url);
		exit();
		}else{
			echo 'ocurrido un error al momento de guardar la información en la base de datos';
		}
	}

  }

  function actualizarPassword($usuario, $password){
	$pass = md5($password);
	db_param_push1();
	$t_query = 'UPDATE mantis_user_table  SET password=' . db_param().',login_count=1  WHERE username=' . db_param();
	db_query( $t_query, array( $pass,$usuario  ));
	return TRUE;
	}

	function db_param_push1() {
		global $g_db_param;
		$g_db_param->push();
	}
  


  function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
  }

	?>