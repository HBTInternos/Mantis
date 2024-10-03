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
 * Login credential page asks user for password then posts to login.php page.
 * If an authentication plugin is installed and has its own credential page,
 * this page will re-direct to it.
 *
 * This page also offers features like remember me, secure session, and forgot password.
 *
 * @package MantisBT
 * @copyright Copyright MantisBT Team - mantisbt-dev@lists.sourceforge.net
 * @link http://www.mantisbt.org
 *
 * @uses core.php
 * @uses authentication_api.php
 * @uses config_api.php
 * @uses constant_inc.php
 * @uses current_user_api.php
 * @uses database_api.php
 * @uses gpc_api.php
 * @uses html_api.php
 * @uses lang_api.php
 * @uses print_api.php
 * @uses string_api.php
 * @uses user_api.php
 * @uses utility_api.php
 */

require_once( 'core.php' );
require_api( 'authentication_api.php' );
require_api( 'config_api.php' );
require_api( 'constant_inc.php' );
require_api( 'current_user_api.php' );
require_api( 'database_api.php' );
require_api( 'gpc_api.php' );
require_api( 'html_api.php' );
require_api( 'lang_api.php' );
require_api( 'print_api.php' );
require_api( 'string_api.php' );
require_api( 'user_api.php' );
require_api( 'utility_api.php' );
require_css( 'login.css' );


$f_username              = trim( gpc_get_string( 'username', '' ) );
$passErr              = trim( gpc_get_string( 'passErr', '' ) );
$changePassErr              = trim( gpc_get_string( 'changePassErr', '' ) );
$noigualpass              = trim( gpc_get_string( 'noigualpass', '' ) );


# Set username to blank if invalid to prevent possible XSS exploits
$t_username = auth_prepare_username( $f_username );


# Get the user id and based on the user decide whether to continue with native password credential
# page or one provided by a plugin.
$t_user_id = auth_get_user_id_from_login_name( $t_username );

// cambios HBT

$t_acceso      = user_get_acceso_by_name($t_username);
$t_login_count = user_get_acceso_by_login_count($t_username);

// Fin cambios HBT



# Login page shouldn't be indexed by search engines
html_robots_noindex();

layout_login_page_begin();

?>



<div class="col-md-offset-3 col-md-6 col-sm-10 col-sm-offset-1">
	<div class="login-container">
		<div class="space-12 hidden-480"></div>
		<?php layout_login_page_logo() ?>
		<div class="space-24 hidden-480"></div>
<?php


// add block code HBT 
if($t_login_count==0 && $t_acceso==2){

	echo '<div class="alert alert-danger">';


		echo '<p>' . lang_get( 'change_password' ) . '</p>';
	

	

	echo '</div>';

}

// fin add block code
$t_form_title='Asignación de credenciales';
?>
<style>
	.posicion{
	left: auto;
    right: -15px;
	}
	.requerido{
	left: auto;
    padding: 0 3px;
    z-index: 2;
    position: absolute;
    top: 1px;
    bottom: 1px;   
    line-height: 30px;
    display: inline-block;
    color: red;
    font-size: 16px;
   
	}

</style>
<div class="position-relative">
	<div class="signup-box visible widget-box no-border" id="login-box">
		<div class="widget-body">
			<div class="widget-main">
				<h4 class="header lighter bigger">
					<?php print_icon( 'fa-sign-in', 'ace-icon' ); ?>
					<?php echo $t_form_title ?>
				</h4>
				<div class="space-10"></div>

	<!-- add block code HBT -->
<?php if ( $t_login_count==0 && $t_acceso==2 ) { 
	
		// define variables and set to empty values



	?>

	<form id="change-password-form" method="post" action="HBT_ValidarChangePass.php">
		<fieldset>
		<?php
		
		
		echo sprintf( lang_get( 'assignment_password' ), string_html_specialchars( $t_username ) ) ;

		# CSRF protection not required here - form does not result in modifications
		?>
		<input hidden readonly type="text" name="hidden_username" class="hidden" tabindex="-1" value="<?php echo string_html_specialchars( $t_username ) ?>" id="hidden_username" />
			
		<label for="password" class="block clearfix">
				<span class="block input-icon input-icon-right">
				
				<input id="password" name="password" type="password" placeholder="<?php echo lang_get( 'password' ) ?>"
						   size="32" maxlength="<?php echo auth_get_password_max_size(); ?>"
						   class="form-control autofocus">
					<?php print_icon( 'fa-lock', 'ace-icon' ) ?>
					<i class="posicion requerido">

						* 
					</i>
					<i style="    color: red;font-size: 10px;">
						<strong>
					<?php echo $passErr;?>
					</strong>
					</i>
				</span>
				
			</label>
			<div class="space-10"></div>
			<label for="password" class="block clearfix">
				<span class="block input-icon input-icon-right">
					<input id="confirmacionpassword" name="confirmacionpassword" type="password" placeholder="<?php echo lang_get( 'password_confirmation' ) ?>"
						   size="32" maxlength="<?php echo auth_get_password_max_size(); ?>"
						   class="form-control autofocus">
					<?php print_icon( 'fa-lock', 'ace-icon' ); ?>
					<i class="posicion requerido">

						* 
					</i>
					<i style="    color: red;font-size: 10px;">
						<strong>
					<?php echo $changePassErr;?>
					</strong>
					</i>
				</span>
			</label>
			<i style="    color: red;font-size: 10px;">
						<strong>
					<?php echo $noigualpass;?>
					</strong>
					</i>
			<div class="space-10"></div>

<input type="submit" class="width-40 pull-right btn btn-success btn-inverse bigger-110" value="<?php echo lang_get( 'login_change' ) ?>" />
<div class="clearfix"></div>	
		</fieldset>
		</form>
	
		

<?php }  ?> 
	
</div>
</div>
</div>
</div>
</div>
</div>

<?php


layout_login_page_end();
