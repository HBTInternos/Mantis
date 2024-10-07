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
 * My View Page
 *
 * @package MantisBT
 * @copyright Copyright 2000 - 2002  Kenzaburo Ito - kenito@300baud.org
 * @copyright Copyright 2002  MantisBT Team - mantisbt-dev@lists.sourceforge.net
 * @link http://www.mantisbt.org
 *
 * @uses core.php
 * @uses access_api.php
 * @uses authentication_api.php
 * @uses category_api.php
 * @uses compress_api.php
 * @uses config_api.php
 * @uses constant_inc.php
 * @uses current_user_api.php
 * @uses gpc_api.php
 * @uses helper_api.php
 * @uses html_api.php
 * @uses lang_api.php
 * @uses print_api.php
 * @uses user_api.php
 */

require_once('core.php');
require_api('access_api.php');
require_api('authentication_api.php');
require_api('category_api.php');
require_api('compress_api.php');
require_api('config_api.php');
require_api('constant_inc.php');
require_api('current_user_api.php');
require_api('gpc_api.php');
require_api('helper_api.php');
require_api('html_api.php');
require_api('lang_api.php');
require_api('print_api.php');
require_api('user_api.php');
require_api('layout_api.php');
require_css('status_config.php');

auth_ensure_user_authenticated();

$t_current_user_id = auth_get_current_user_id();
$t_current_project_id = helper_get_current_project();

# Improve performance by caching category data in one pass
category_get_all_rows($t_current_project_id);

compress_enable();

# don't index my view page
html_robots_noindex();

layout_page_header_begin(lang_get('my_view_link'));

$t_refresh_delay = current_user_get_pref('refresh_delay');
if ($t_refresh_delay > 0) {
	html_meta_redirect('my_view_page.php?refresh=true', $t_refresh_delay * 60);
}

layout_page_header_end();

layout_page_begin(__FILE__);

$f_page_number = gpc_get_int('page_number', 1);

$t_per_page = config_get('my_view_bug_count');
$t_bug_count = null;
$t_page_count = null;

# The projects that need to be evaluated are those that will be included in the filters
# used for each box. At this point, those filter are created for "current" project, and
# may include subprojects, or not, based on the default "_view_type" property
# Unless these following checks are redesigned to account for the actual filters used,
# we will assume if subprojects are included by inspecting a default filter for current project.
if ($t_current_project_id == ALL_PROJECTS) {
	$t_project_ids_to_check = null;
} else {
	# this creates a filter with the specific project informes, in the same way that
	# those that will be used later for the boxes
	$t_test_filter = filter_ensure_valid_filter(array(FILTER_PROPERTY_PROJECT_ID => [$t_current_project_id]));
	$t_project_ids_to_check = filter_get_included_projects($t_test_filter);
}

# Retrieve the boxes to display
# - exclude hidden boxes per configuration (order == 0)
# - remove boxes that do not make sense in the user's context (access level)
$t_boxes = array_filter(config_get('my_view_boxes'));
$t_anonymous_user = current_user_is_anonymous();
foreach ($t_boxes as $t_box_title => $t_box_display) {
	if ( # Remove "Assigned to Me" box for users that can't handle issues
		($t_box_title == 'assigned'
			&& ($t_anonymous_user
				|| !access_has_any_project_level('handle_bug_threshold', $t_project_ids_to_check, $t_current_user_id)
			)
		) ||
		# Remove "Monitored by Me" box for users that can't monitor issues
		($t_box_title == 'monitored'
			&& ($t_anonymous_user
				|| !access_has_any_project_level('monitor_bug_threshold', $t_project_ids_to_check, $t_current_user_id)
			)
		) ||
		# Remove display of "Reported by Me", "Awaiting Feedback" and
		# "Awating confirmation of resolution" boxes for users that can't report bugs
		(in_array($t_box_title, array('reported', 'feedback', 'verify'))
			&& ($t_anonymous_user
				|| !access_has_any_project_level('report_bug_threshold', $t_project_ids_to_check, $t_current_user_id)
			)
		)
	) {
		unset($t_boxes[$t_box_title]);
	}
}
asort($t_boxes);

$t_timeline_view_threshold_access = access_has_any_project_level(config_get('timeline_view_threshold'), $t_project_ids_to_check, $t_current_user_id);
$t_timeline_view_class = ($t_timeline_view_threshold_access) ? "col-md-7" : "col-md-6";
?>
<div class="col-xs-12 <?php echo $t_timeline_view_class ?>">

	<?php
	define('MY_VIEW_INC_ALLOW', true);

	# Determinar el número de caja donde debe comenzar la columna 2
	$t_column2_start = (count($t_boxes) + 1) >> 1;

	$t_counter = 0;
	foreach ($t_boxes as $t_box_title => $t_box_display) {
		# Si la línea de tiempo está desactivada, mostrar las cajas en 2 columnas
		if (!$t_timeline_view_threshold_access && $t_counter++ == $t_column2_start) {
			# Fin de la primera columna
			echo '</div>';
			echo '<div class="col-xs-12 col-md-6">';
		}
		include(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'my_view_inc.php');
		echo '<div class="space-10"></div>';
	}
	?>
</div>

<?php if ($t_timeline_view_threshold_access) { ?>
	<div class="col-xs-12 col-md-5">
		<?php
		# Crear un filtro sencillo que obtenga todos los bugs para el proyecto actual
		$g_timeline_filter = array();
		$g_timeline_filter[FILTER_PROPERTY_HIDE_STATUS] = array(META_FILTER_NONE);
		$g_timeline_filter = filter_ensure_valid_filter($g_timeline_filter);
		include($g_core_path . 'timeline_inc.php');
		?>
		<div class="space-10"></div>
	</div>
<?php } ?>


<div style="clear:both;"></div> <!-- Asegura que la barra no se superponga con los elementos anteriores -->
<nav id="barra-estado" style="margin-top: 20px;"> <!-- Ajusta el espacio superior -->
    <ul class="list-unstyled list-inline text-center">
        <li class="estado-items">
            <span class="color-box-alt estado-nueva"></span>Nueva
        </li>
        <li class="estado-items">
            <span class="color-box-alt estado-incompleto"></span>Se necesitan más datos
        </li>
        <li class="estado-items">
            <span class="color-box-alt estado-aceptada"></span>Aceptada
        </li>
        <li class="estado-items">
            <span class="color-box-alt estado-confirmada"></span>Confirmada
        </li>
        <li class="estado-items">
            <span class="color-box-alt estado-asignada"></span>Asignada
        </li>
        <li class="estado-items">
            <span class="color-box-alt estado-resuelta"></span>Resuelta
        </li>
        <li class="estado-items">
            <span class="color-box-alt estado-cerrada"></span>Cerrada
        </li>
    </ul>
</nav>
<link rel="stylesheet" href="css/barra-estados.css">

<?php
layout_page_end();
?>