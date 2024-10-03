<?php
# MantisBT - a php based bugtracking system

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
 * Excel (2003 SP2 and above) export page
 *
 * @package MantisBT
 * @copyright Copyright (C) 2000 - 2002  Kenzaburo Ito - kenito@300baud.org
 * @copyright Copyright (C) 2002 - 2010  MantisBT Team - mantisbt-dev@lists.sourceforge.net
 * @link http://www.mantisbt.org
 */
/**
 * MantisBT Core API's
 */
require_once( 'core.php' );

require_api( 'current_user_api.php' );
require_api( 'bug_api.php' );
require_api( 'string_api.php' );
require_api( 'columns_api.php' );
require_api( 'excel_api.php' );

require_api( 'authentication_api.php' );

// ADD HBT
require_api( 'config_api.php' );
require_api( 'file_api.php' );
require_api( 'filter_api.php' );
require_api( 'gpc_api.php' );
require_api( 'helper_api.php' );
require_api( 'print_api.php' );
require_api( 'utility_api.php' );
// FIN HBT
auth_ensure_user_authenticated();

$f_export = gpc_get_string( 'export', '' );

helper_begin_long_process();

#Obtenemos el id del proyecto, as� como las fechas de inicio y fin para el filtro
#de las incidencias que se mostrar�n en el reporte.
$project_id 	= gpc_get_string('project_id', 0);
$dia_inicio		= gpc_get_string('dia_inicio', config_get( 'date_day_791_enum_string' ));
$mes_inicio		= gpc_get_string('mes_inicio',config_get( 'date_mounth_791_enum_string' ));
$anio_inicio	= gpc_get_string('anio_inicio',config_get( 'date_year_791_enum_string' ));
$dia_fin		= gpc_get_string('dia_fin',config_get( 'date_day_791_enum_string' ));
$mes_fin		= gpc_get_string('mes_fin',config_get( 'date_mounth_791_enum_string' ));
$anio_fin		= gpc_get_string('anio_fin',config_get( 'date_year_791_enum_string' ));

	#Averiguamos si la fecha ingresada  de inicio es un d�a laborable
	$inicio_laborable = dia_laborable(get_enum_element('date_year_791',$anio_inicio ), 
		get_enum_element('date_mounth_791',$mes_inicio ), 
		get_enum_element('date_day_791',$dia_inicio ), 0);
		
	#Si el d�a es no laborable, mostraremos un error.
	if ($inicio_laborable == false) {
		error_parameters( lang_get( 'informe_fecha_inicio' ) );
		trigger_error( FECHA_NO_LABORABLE, ERROR );
	}

	#Averiguamos si la fecha ingresada fin es un d�a laborable
	$fin_laborable = dia_laborable(get_enum_element('date_year_791',$anio_fin ), 
	get_enum_element('date_mounth_791',$mes_fin ), get_enum_element('date_day_791',$dia_fin) , 0);
	
	#Si el d�a es no laborable, mostraremos un error.
	if ($fin_laborable == false) {
		error_parameters( lang_get( 'informe_fecha_fin' ) );
		trigger_error( FECHA_NO_LABORABLE, ERROR );
	}
	
	# obtenemos la fecha de incio en formato unix
	$fecha_inicio =  mktime(0,0,0,get_enum_element('date_mounth_791',$mes_inicio ), 
		get_enum_element('date_day_791',$dia_inicio),
		get_enum_element('date_year_791',$anio_inicio ));
	
	# obtenemos la fecha fin en formato unix
	$fecha_fin = mktime(0,0,0,get_enum_element('date_mounth_791',$mes_fin ), 
		get_enum_element('date_day_791',$dia_fin),
		get_enum_element('date_year_791',$anio_fin ));
	
	#Comparamos ambas fechas, y si la fecha inicio es mayor a la fecha fin
	#mostraremos un error en pantalla.
	if($fecha_inicio > $fecha_fin){
		trigger_error(FECHA_INICIO_MAYOR_FECHA_FIN, ERROR );
	}
	
$t_export_title = lang_get('informe_nombre') . get_enum_element( 'date_day_791', $dia_inicio ) . '/' . get_enum_element( 'date_mounth_791', $mes_inicio ) . 
	'/' .get_enum_element( 'date_year_791', $anio_inicio ) . '/' . lang_get('informe_nombre_hasta') . get_enum_element( 'date_day_791', $dia_fin ) . '/' . get_enum_element( 'date_mounth_791', $mes_fin ) . 
	'/' .get_enum_element( 'date_year_791', $anio_fin ) ;

$t_short_date_format = config_get( 'vernue_date_format' );

# This is where we used to do the entire actual filter ourselves
$t_page_number = gpc_get_int( 'page_number', 1 );
$t_per_page = 100;
$t_bug_count = null;
$t_page_count = null;

#Llamamos el m�todo que nos permite obtener las incidencias que se van a 
#mostrar en el informe con sus respectivos datos. Para lo cual le enviamos el 
#id del proyecto, la fecha de inicio y la fecha fin en la cual se quiere mostar
#el informe.
$result = get_incidencias_informe_proteccion($project_id, $dia_inicio, 
	$mes_inicio, $anio_inicio, $dia_fin, $mes_fin, $anio_fin);
//print_r($result);
if ( $result === false ) {
	print_header_redirect( 'view_all_set.php?type=0&print=1' );
}

header( 'Content-Type: application/vnd.ms-excel; charset=UTF-8' );
header( 'Pragma: public' );
header( 'Content-Disposition: attachment; filename="' . urlencode( file_clean_name( $t_export_title ) ) . '.xml"' ) ;

#Damos el nombre a nuestro informe.
echo excel_get_header( $t_export_title );
#Mostramos en el reporte las columnas que vamos a mostrar.
echo columnas_informe();

$f_bug_arr = explode( ',', $f_export );

$t_columns = config_get('columnas_informe');
print_r($t_columns);
if ( $result){

	do{
		# Variable bandera para determinar si hay m�s incidencias para mostrar.
		$t_more = true;
		# Contamos la cantidad de incidencias que vamos a mostrar en el reporte.
		$t_row_count = count( $result );
		# Ahora vamos a recorrer cada una de las incidencias que ya buscamos.
		for( $i = 0; $i < $t_row_count; $i++ ) {
			# Obtenemos la incidencia en la posici�n i.
			$t_row = $result[$i];
			$t_bug = null;
			#
			if ( is_blank( $f_export ) || in_array( $t_row->id, $f_bug_arr ) ) {
				# Iniciamos una nueva fila.
				echo excel_get_start_row();
				# Recorremos las columnas que se van a mostrar el reporte.
				foreach ( $t_columns as $t_column ) {
					if ( column_is_extended( $t_column ) ) {
						if ( $t_bug === null ) {
							$t_bug = bug_get( $t_row->id,  true );
						}
						$t_function = 'excel_format_' . $t_column;
						echo $t_function( $t_bug->$t_column );
					} else {				
						$t_function = 'excel_format_' . $t_column;
						echo $t_function($t_row['' . $t_column . '']);
					}
				}
	
				echo excel_get_end_row();
			} #in_array
			} #for loop
	
			// If got a full page, then attempt for the next one.
			// @@@ Note that since we are not using a transaction, there is a risk that we get a duplicate record or we miss
			// one due to a submit or update that happens in parallel.
			if ( $t_row_count == $t_per_page ) {
				$t_page_number++;
				$t_bug_count = null;
				$t_page_count = null;
	
				$result = filter_get_bug_rows( $t_page_number, $t_per_page, $t_page_count, $t_bug_count );
				if ( $result === false ) {
					$t_more = false;
				}
			} else {
				$t_more = false;
			}
		} while ( $t_more );
}

echo excel_get_footer();

