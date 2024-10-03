<?php
# MantisBT - A PHP based bugtracking system HBT

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
// Codigo de HBT
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


require_api( 'file_api.php' );
require_api( 'custom_field_api.php' );
require_api( 'last_visited_api.php' );
require_api( 'projax_api.php' );
require_api( 'collapse_api.php' );






# Get the user id and based on the user decide whether to continue with native password credential
# page or one provided by a plugin.


$project_id = $_GET['project_id'];
	
	access_ensure_project_level( config_get( 'report_bug_threshold' ) );
	
	# don't index bug report page
	html_robots_noindex();

	// html_page_top( lang_get( 'report_bug_link' ) );

	layout_page_header();

layout_page_begin();

?>



<div class="col-md-offset-3 col-md-6 col-sm-10 col-sm-offset-1">
	<div class="login-container">
		<div class="space-12 hidden-480"></div>
	
		<div class="space-24 hidden-480"></div>
<?php




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
				<h4 style="    text-align: center;
    font-size: xx-large;
    color: black;
	background-color: #dbd8d8;
    padding: 10px;
    border-radius: 5px;"class="header lighter bigger">
					Reporte de Tiempos
				</h4>
				<div class="space-10"></div>

	<!-- add block code HBT -->


	<form id="informe_incidencias"name="informe_incidencias" method="post" action="HBT_informe_tiempo_incidencia_xml.php">
		<fieldset>
		
<div class="clearfix"></div>


<!-- Tabla que para mostrar las fechas para filtrar el reporte. -->
	<table class="table table-bordered">
	
		<!-- Esta fila estar� oculta para almacenar el id del proyecto -->
		<tr>
			<td colspan="2" style="text-align: center;">
				<!-- guardamos en el campo oculto el id del proyecto. -->
				<input class="hidden" type="text" id="project_id"name="project_id" tabindex="-1" value="<?php echo string_html_specialchars($project_id) ?>" />
				<strong> <?php echo lang_get( 'informe_datos' ) ?></strong>
				 
			</td>
		</tr>
		
		
		<!-- Vamos a mostrar en la primera fila la fecha de inicio del reporte. -->		
		<tr >
		
			<td class="category" >				
				<?php print_documentation_link( 'informe_fecha_inicio' ) ?>
			</td>
			
			<td width="70%">
				<!-- Dia de la fecha de inicio --> 
				<select 
					<?php echo helper_get_tab_index()?> name="dia_inicio"> <?php
					print_enum_string_option_list( 'date_day_791' );
					?>
				</select>
				<!-- Mes de la fecha de inicio -->
				<select
					<?php echo helper_get_tab_index()?> name="mes_inicio"> <?php
					print_enum_string_option_list( 'date_mounth_791' );
					?>
				</select>
				<!-- A�o de la fecha de inicio -->
				<select 
					<?php echo helper_get_tab_index()?> name="anio_inicio"> <?php
					print_enum_string_option_list( 'date_year_791' );
					?>
				</select>						
			</td>			
		</tr>		
	
		<!-- Vamos a mostrar en la segunda fila la fecha fin del reporte. -->		
		<tr >
		
			<td class="category" width="30%">				
				<?php print_documentation_link( 'informe_fecha_fin' ) ?>
			</td>
			
			<td width="70%">
				<!-- Dia de la fecha fin -->
				<select 
					<?php echo helper_get_tab_index()?> name="dia_fin"> <?php
					print_enum_string_option_list( 'date_day_791');
					?>
				</select>
				<!-- Mes de la fecha fin -->
				<select
					<?php echo helper_get_tab_index()?> name="mes_fin"> <?php
					print_enum_string_option_list( 'date_mounth_791' );
					?>
				</select>
				<!-- A�o de la fecha fin -->
				<select 
					<?php echo helper_get_tab_index()?> name="anio_fin"> <?php
					print_enum_string_option_list( 'date_year_791' );
					?>
				</select>						
			</td>			
		</tr>
		
		<!-- Bot�n para generar el reporte. -->
		<tr >		
			<td colspan="2" class="center">
				<input <?php echo helper_get_tab_index() ?>	type="submit" class="button"
				value="<?php echo lang_get( 'informe_generar_reporte' ) ?>" />
			</td>
		</tr>
		
	</table>



		</fieldset>
		</form>
	
		


	
</div>
</div>
</div>
</div>
</div>
</div>

<?php



layout_page_end();
