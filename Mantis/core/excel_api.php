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
 * Excel API
 *
 * @package CoreAPI
 * @subpackage ExcelAPI
 * @copyright Copyright 2000 - 2002  Kenzaburo Ito - kenito@300baud.org
 * @copyright Copyright 2002  MantisBT Team - mantisbt-dev@lists.sourceforge.net
 * @link http://www.mantisbt.org
 *
 * @uses authentication_api.php
 * @uses bug_api.php
 * @uses category_api.php
 * @uses columns_api.php
 * @uses config_api.php
 * @uses constant_inc.php
 * @uses custom_field_api.php
 * @uses helper_api.php
 * @uses lang_api.php
 * @uses project_api.php
 * @uses user_api.php
 */

require_api( 'authentication_api.php' );
require_api( 'bug_api.php' );
require_api( 'category_api.php' );
require_api( 'columns_api.php' );
require_api( 'config_api.php' );
require_api( 'constant_inc.php' );
require_api( 'custom_field_api.php' );
require_api( 'helper_api.php' );
require_api( 'lang_api.php' );
require_api( 'project_api.php' );
require_api( 'user_api.php' );

/**
 * A method that returns the header for an Excel Xml file.
 *
 * @param string $p_worksheet_title The worksheet title.
 * @param array  $p_styles          An optional array of ExcelStyle entries . Parent entries must be placed before child entries.
 * @return string the header Xml.
 */
function excel_get_header( $p_worksheet_title, array $p_styles = array() ) {
	$p_worksheet_title = preg_replace( '/[\/:*?"<>|]/', '', $p_worksheet_title );
	return "<?xml version=\"1.0\" encoding=\"UTF-8\"?><?mso-application progid=\"Excel.Sheet\"?>
 <Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\"
 xmlns:x=\"urn:schemas-microsoft-com:office:excel\"
 xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\"
 xmlns:html=\"http://www.w3.org/TR/REC-html40\">\n ". excel_get_styles( $p_styles ). '<Worksheet ss:Name="' . urlencode( $p_worksheet_title ) . "\">\n<Table>\n<Column ss:Index=\"1\" ss:AutoFitWidth=\"0\" ss:Width=\"110\"/>\n";
}

/**
 * Returns an XML string containing the <tt>ss:Styles</tt> entry, possibly empty
 *
 * @param array $p_styles An array of ExcelStyle entries.
 * @return null|string
 */
function excel_get_styles( array $p_styles ) {
	if( count( $p_styles ) == 0 ) {
		return null;
	}

	$t_styles_string = '<ss:Styles>';

	foreach ( $p_styles as $t_style ) {
		$t_styles_string .= $t_style->asXml();
	}
	$t_styles_string .= '</ss:Styles>';

	return $t_styles_string;
}

/**
 * A method that returns the footer for an Excel Xml file.
 * @return string the footer xml.
 */
function excel_get_footer() {
	return "</Table>\n</Worksheet></Workbook>\n";
}

/**
 * Generates a cell XML for a column title.
 * @param string $p_column_title Column title.
 * @return string The cell xml.
 */
function excel_format_column_title( $p_column_title ) {
	return '<Cell><Data ss:Type="String">' . $p_column_title . '</Data></Cell>';
}

/**
 * Generates the xml for the start of an Excel row.
 *
 * @param string $p_style_id The optional style id.
 * @return string The Row tag.
 */
function excel_get_start_row( ) {
	// if( $p_style_id != '' ) {
	// 	return '<Row ss:StyleID="' . $p_style_id . '">';
	// } else {
		return '<Row>';
	// }
}

/**
 * Generates the xml for the end of an Excel row.
 * @return string The Row end tag.
 */
function excel_get_end_row() {
	return '</Row>';
}



/**
 * Gets an Xml Row that contains all column titles
 * @param string $p_style_id The optional style id.
 * @return string The xml row.
 */
function excel_get_titles_row( $p_style_id = '' ) {
	$t_columns = excel_get_columns();
	$t_ret = excel_get_start_row( $p_style_id );

	foreach( $t_columns as $t_column ) {
		$t_ret .= excel_format_column_title( column_get_title( $t_column ) );
	}

	$t_ret .= '</Row>';

	return $t_ret;
}

/**
 * Gets the download file name for the Excel export.  If 'All Projects' selected, default to <username>,
 * otherwise default to <projectname>.
 * @return string file name without extension
 */
function excel_get_default_filename() {
	$t_current_project_id = helper_get_current_project();

	if( ALL_PROJECTS == $t_current_project_id ) {
		$t_filename = user_get_name( auth_get_current_user_id() );
	} else {
		$t_filename = project_get_field( $t_current_project_id, 'name' );
	}

	return $t_filename;
}

/**
 * Escapes the specified column value and includes it in a Cell Xml as a string.
 * @param string $p_value The value.
 * @return string The Cell Xml.
 */
function excel_prepare_string( $p_value ) {
	return excel_get_cell( $p_value, 'String' );
}

/**
 * Escapes the specified column value and includes it in a Cell Xml as a number.
 * @param integer $p_value The value.
 * @return string The Cell Xml.
 */
function excel_prepare_number( $p_value ) {
	return excel_get_cell( $p_value, 'Number' );
}

/**
 * Returns an <tt>Cell</tt> as an XML string
 *
 * <p>All the parameters are assumed to be valid and escaped, as this function performs no
 * escaping of its own.</p>
 *
 * @param string $p_value      Cell Value.
 * @param string $p_type       Cell Type.
 * @param array  $p_attributes An array where the keys are attribute names and values attribute
 *                             values for the <tt>Cell</tt> object.
 * @return string
 */
function excel_get_cell( $p_value, $p_type, array $p_attributes = array() ) {
	if ( !is_int( $p_value ) ) {
		$t_value = str_replace( array( '&', "\n", '<', '>' ), array( '&amp;', '&#10;', '&lt;', '&gt;' ), $p_value );
	} else {
		$t_value = $p_value;
	}

	$t_ret = '<Cell ';

	foreach ( $p_attributes as $t_attribute_name => $t_attribute_value ) {
		$t_ret .= $t_attribute_name. '="' . $t_attribute_value . '" ';
	}

	$t_ret .= '>';

	$t_ret .= '<Data ss:Type="' . $p_type . '">' . $t_value . "</Data></Cell>\n";

	return $t_ret;
}

/**
 * Gets the columns to be included in the Excel Xml export.
 * @return array column names.
 */
function excel_get_columns() {
	$t_columns = helper_get_columns_to_view( COLUMNS_TARGET_EXCEL_PAGE );
	return $t_columns;
}

#
# Formatting Functions
#
# Names for formatting functions are excel_format_*, where * corresponds to the
# field name as return get excel_get_columns() and by the filter api.
#
/**
 * Gets the formatted bug id value.
 * @param BugData $p_bug The bug object.
 * @return string The bug id prefixed with 0s.
 */
// HBT funcion original
// function excel_format_id( BugData $p_bug ) {
// 	return excel_prepare_number( bug_format_id( $p_bug->id ) );
// }

// HBT modificacion HBT 
function excel_format_id( $p_bug ) { 
	return excel_prepare_number( bug_format_id( $p_bug ) );
}
// FIN HBT

/**
 * Gets the formatted project id value.
 * @param BugData $p_bug The bug object.
 * @return string The project name.
 */
function excel_format_project_id( BugData $p_bug ) {
	return excel_prepare_string( project_get_name( $p_bug->project_id ) );
}

/**
 * Gets the formatted reporter id value.
 * @param BugData $p_bug A bug object.
 * @return string The reporter user name.
 */
//HBT funcion original
// function excel_format_reporter_id( BugData $p_bug ) {
// 	return excel_prepare_string( user_get_name( $p_bug->reporter_id ) );
// }
// HBT modificacion HBT 
function excel_format_reporter_id(  $p_bug ) {
	return excel_prepare_string( user_get_name( $p_bug ) );
}
// FIN HBT
/**
 * Gets the formatted handler id.
 * @param BugData $p_bug A bug object.
 * @return string The handler user name or empty string.
 */
// HBT modificacion HBT 
function excel_format_handler_id(  $p_bug ) {
	if( $p_bug > 0 ) {
		return excel_prepare_string( user_get_name( $p_bug) );
	} else {
		return excel_prepare_string( '' );
	}
}
// FIN HBT
/**
 * Gets the formatted priority.
 * @param BugData $p_bug A bug object.
 * @return string the priority text.
 */
function excel_format_priority( BugData $p_bug ) {
	return excel_prepare_string( get_enum_element( 'priority', $p_bug->priority, auth_get_current_user_id(), $p_bug->project_id ) );
}

/**
 * Gets the formatted severity.
 * @param BugData $p_bug A bug object.
 * @return string the severity text.
 */

 // HBT modificacion HBT 
function excel_format_severity(  $p_bug ) {
	return excel_prepare_string( get_enum_element( 'severity', $p_bug ) );
}
// FIN HBT

/**
 * Gets the formatted reproducibility.
 * @param BugData $p_bug A bug object.
 * @return string the reproducibility text.
 */
function excel_format_reproducibility( BugData $p_bug ) {
	return excel_prepare_string( get_enum_element( 'reproducibility', $p_bug->reproducibility, auth_get_current_user_id(), $p_bug->project_id ) );
}

/**
 * Gets the formatted view state,
 * @param BugData $p_bug A bug object.
 * @return string The view state
 */
function excel_format_view_state( BugData $p_bug ) {
	return excel_prepare_string( get_enum_element( 'view_state', $p_bug->view_state, auth_get_current_user_id(), $p_bug->project_id ) );
}

/**
 * Gets the formatted projection.
 * @param BugData $p_bug A bug object.
 * @return string the projection text.
 */
function excel_format_projection( BugData $p_bug ) {
	return excel_prepare_string( get_enum_element( 'projection', $p_bug->projection, auth_get_current_user_id(), $p_bug->project_id ) );
}

/**
 * Gets the formatted eta.
 * @param BugData $p_bug A bug object.
 * @return string the eta text.
 */
function excel_format_eta( BugData $p_bug ) {
	return excel_prepare_string( get_enum_element( 'eta', $p_bug->eta, auth_get_current_user_id(), $p_bug->project_id ) );
}

/**
 * Gets the status field.
 * @param BugData $p_bug A bug object.
 * @return string the formatted status.
 */
// HBT modificacion HBT 
function excel_format_status( $p_bug ) {
	return excel_prepare_string( get_enum_element( 'status', $p_bug ) );
}
// FIN HBT

/**
 * Gets the resolution field.
 * @param BugData $p_bug A bug object.
 * @return string the formatted resolution.
 */
// HBT modificacion HBT 
function excel_format_resolution( $p_bug ) {
	return excel_prepare_string( get_enum_element( 'resolution', $p_bug) );
}
// FIN HBT

/**
 * Gets the formatted version.
 * @param BugData $p_bug A bug object.
 * @return string the product version.
 */
function excel_format_version( BugData $p_bug ) {
	return excel_prepare_string( $p_bug->version );
}

/**
 * Gets the formatted fixed in version.
 * @param BugData $p_bug A bug object.
 * @return string the fixed in version.
 */
function excel_format_fixed_in_version( BugData $p_bug ) {
	return excel_prepare_string( $p_bug->fixed_in_version );
}

/**
 * Gets the formatted tags.
 * @param BugData $p_bug A bug object.
 * @return string the tags.
 */
function excel_format_tags( BugData $p_bug ) {
	$t_value = '';

	if( access_has_bug_level( config_get( 'tag_view_threshold' ), $p_bug->id ) ) {
		$t_value = tag_bug_get_all( $p_bug->id );
	}

	return excel_prepare_string( $t_value );
}

/**
 * Gets the formatted target version.
 * @param BugData $p_bug A bug object.
 * @return string the target version.
 */
function excel_format_target_version( BugData $p_bug ) {
	return excel_prepare_string( $p_bug->target_version );
}

/**
 * Gets the formatted category.
 * @param BugData $p_bug A bug object.
 * @return string the category.
 */
// HBT modificacion HBT 
function excel_format_category_id( $p_bug ) {
	return excel_prepare_string( category_full_name( $p_bug, false ) );
}
// FIN HBT

/**
 * Gets the formatted operating system.
 * @param BugData $p_bug A bug object.
 * @return string the operating system.
 */
function excel_format_os( BugData $p_bug ) {
	return excel_prepare_string( $p_bug->os );
}

/**
 * Gets the formatted operating system build (version).
 * @param BugData $p_bug A bug object.
 * @return string the operating system build (version)
 */
function excel_format_os_build( BugData $p_bug ) {
	return excel_prepare_string( $p_bug->os_build );
}

/**
 * Gets the formatted product build,
 * @param BugData $p_bug A bug object.
 * @return string the product build.
 */
function excel_format_build( BugData $p_bug ) {
	return excel_prepare_string( $p_bug->build );
}

/**
 * Gets the formatted platform,
 * @param BugData $p_bug A bug object.
 * @return string the platform.
 */
function excel_format_platform( BugData $p_bug ) {
	return excel_prepare_string( $p_bug->platform );
}

/**
 * Gets the formatted date submitted.
 * @param BugData $p_bug A bug object.
 * @return string the date submitted in short date format.
 */
function excel_format_date_submitted( BugData $p_bug ) {
	return excel_prepare_string( date( config_get( 'short_date_format' ), $p_bug->date_submitted ) );
}

/**
 * Gets the formatted date last updated.
 * @param BugData $p_bug A bug object.
 * @return string the date last updated in short date format.
 */
function excel_format_last_updated( BugData $p_bug ) {
	return excel_prepare_string( date( config_get( 'short_date_format' ), $p_bug->last_updated ) );
}

/**
 * Gets the summary field.
 * @param BugData $p_bug A bug object.
 * @return string the formatted summary.
 */
function excel_format_summary( BugData $p_bug ) {
	return excel_prepare_string( $p_bug->summary );
}

/**
 * Gets the formatted selection.
 * @param BugData $p_bug A bug object.
 * @return string an formatted empty string.
 */
function excel_format_selection( BugData $p_bug ) {
	return excel_prepare_string( '' );
}

/**
 * Gets the formatted description field.
 * @param BugData $p_bug A bug object.
 * @return string The formatted description (multi-line).
 */
function excel_format_description( BugData $p_bug ) {
	return excel_prepare_string( $p_bug->description );
}

/**
 * Gets the formatted notes field.
 * @param BugData $p_bug A bug object.
 * @return string The formatted notes (multi-line).
 */
function excel_format_notes( BugData $p_bug ) {
	$t_notes = bugnote_get_all_visible_as_string( $p_bug->id, /* user_bugnote_order */ 'DESC', /* user_bugnote_limit */ 0 );
	return excel_prepare_string( $t_notes );
}

/**
 * Gets the formatted 'steps to reproduce' field.
 * @param BugData $p_bug A bug object.
 * @return string The formatted steps to reproduce (multi-line).
 */
function excel_format_steps_to_reproduce( BugData $p_bug ) {
	return excel_prepare_string( $p_bug->steps_to_reproduce );
}

/**
 * Gets the formatted 'additional information' field.
 * @param BugData $p_bug A bug object.
 * @return string The formatted additional information (multi-line).
 */
function excel_format_additional_information( BugData $p_bug ) {
	return excel_prepare_string( $p_bug->additional_information );
}

/**
 * Gets the formatted value for the specified issue id, project and custom field.
 * @param integer $p_issue_id     The issue id.
 * @param integer $p_project_id   The project id.
 * @param string  $p_custom_field The custom field name (without 'custom_' prefix).
 * @return string The custom field value.
 */
function excel_format_custom_field( $p_issue_id, $p_project_id, $p_custom_field ) {
	$t_field_id = custom_field_get_id_from_name( $p_custom_field );

	if( $t_field_id === false ) {
		return excel_prepare_string( '@' . $p_custom_field . '@' );
	}

	if( custom_field_is_linked( $t_field_id, $p_project_id ) ) {
		$t_def = custom_field_get_definition( $t_field_id );
		$t_value = string_custom_field_value( $t_def, $t_field_id, $p_issue_id );

		if( ( $t_def['type'] == CUSTOM_FIELD_TYPE_NUMERIC ||
			  $t_def['type'] == CUSTOM_FIELD_TYPE_FLOAT
			) && is_numeric( $t_value )
		) {
			return excel_prepare_number( $t_value );
		}

		return excel_prepare_string( $t_value );
	}

	# field is not linked to project
	return excel_prepare_string( '' );
}

/**
 * Gets the formatted value for the specified plugin column value.
 * @param string  $p_column The plugin column name.
 * @param BugData $p_bug    A bug object to print the column for - needed for the display function of the plugin column.
 * @return string The plugin column value.
 */
function excel_format_plugin_column_value( $p_column, BugData $p_bug ) {
	$t_plugin_columns = columns_get_plugin_columns();

	if( !isset( $t_plugin_columns[$p_column] ) ) {
		$t_value = '';
	} else {
		$t_column_object = $t_plugin_columns[$p_column];
		$t_value = $t_column_object->value( $p_bug );
	}

	return excel_prepare_string( $t_value );
}

/**
 * Gets the formatted due date.
 * @param BugData $p_bug A bug object.
 * @return string The formatted due date.
 */
function excel_format_due_date( BugData $p_bug ) {
	$t_value = '';
	if ( !date_is_null( $p_bug->due_date ) && access_has_bug_level( config_get( 'due_date_view_threshold' ), $p_bug->id ) ) {
		$t_value = date( config_get( 'short_date_format' ), $p_bug->due_date );
	}
	return excel_prepare_string( $t_value );
}

/**
 * Gets the sponsorship total for an issue
 * @param BugData $p_bug A bug object.
 * @return string
 * @access public
 */
function excel_format_sponsorship_total( BugData $p_bug ) {
	return excel_prepare_string( $p_bug->sponsorship_total );
}

/**
 * Gets the attachment count for an issue
 * @param BugData $p_bug A bug object.
 * @return string
 * @access public
 */
function excel_format_attachment_count( BugData $p_bug ) {
	# Check for attachments
	$t_attachment_count = 0;
	if( file_can_view_bug_attachments( $p_bug->id, null ) ) {
		$t_attachment_count = file_bug_attachment_count( $p_bug->id );
	}
	return excel_prepare_number( $t_attachment_count );
}

/**
 * Gets the bug note count for an issue
 * @param BugData $p_bug A bug object.
 * @return string
 * @access public
 */
function excel_format_bugnotes_count( BugData $p_bug ) {
	# grab the bugnote count
	$t_bugnote_stats = bug_get_bugnote_stats( $p_bug->id );
	if( null !== $t_bugnote_stats ) {
		$t_bugnote_count = $t_bugnote_stats['count'];
	} else {
		$t_bugnote_count = 0;
	}
	return excel_prepare_number( $t_bugnote_count );
}

/**
 * The <tt>ExcelStyle</tt> class is able to render style information
 *
 * <p>For more information regarding the values taken by the parameters of this class' methods
 * please see <a href="http://msdn.microsoft.com/en-us/library/aa140066(v=office.10).aspx#odc_xmlss_ss:style">
 * the ss:Style documentation</a>.</p>
 *
 */
class ExcelStyle {
	/**
	 * Id
	 */
	private $id;

	/**
	 * Parent id
	 */
	private $parent_id;

	/**
	 * Interior
	 */
	private $interior;

	/**
	 * Font
	 */
	private $font;

	/**
	 * Border
	 */
	private $border;

	/**
	 * Alignment
	 */
	private $alignment;

	/**
	 * Default Constructor
	 * @param string $p_id        The unique style id.
	 * @param string $p_parent_id The parent style id.
	 */
	function __construct( $p_id, $p_parent_id = '' ) {
		$this->id = $p_id;
		$this->parent_id = $p_parent_id;
	}

	/**
	 * Return ID
	 * @return integer
	 */
	function getId() {
		return $this->id;
	}

	/**
	 * Set background color
	 * @param string $p_color   The color in #rrggbb format or a named color.
	 * @param string $p_pattern Fill Pattern.
	 * @return void
	 */
	function setBackgroundColor( $p_color, $p_pattern = 'Solid' ) {
		if( ! isset ( $this->interior ) ) {
			$this->interior = new Interior();
		}

		$this->interior->color = $p_color;
		$this->interior->pattern = $p_pattern;
	}

	/**
	 * Set Font
	 * @param integer $p_bold   Either 1 for bold, 0 for not bold.
	 * @param string  $p_color  The color in #rrggbb format or a named color.
	 * @param string  $p_name   The name of the font.
	 * @param integer $p_italic Either 1 for italic, 0 for not italic.
	 * @return void
	 */
	function setFont( $p_bold, $p_color = '', $p_name = '', $p_italic = -1 ) {
		if( !isset( $this->font ) ) {
			$this->font = new Font();
		}

		if( $p_bold != -1 ) {
			$this->font->bold = $p_bold;
		}
		if( $p_color != '' ) {
			$this->font->color = $p_color;
		}
		if( $p_name != '' ) {
			$this->font->fontName = $p_name;
		}
		if( $p_italic != -1 ) {
			$this->font->italic = $p_italic;
		}
	}

	/**
	 * Sets the border values for the style
	 *
	 * <p>The values are set for the following positions: Left, Top, Right, Bottom. There is no
	 * support for setting individual values.</p>
	 *
	 * @param string  $p_color      The color in #rrggbb format or a named color.
	 * @param string  $p_line_style None, Continuous, Dash, Dot, DashDot, DashDotDot, SlantDashDot, or Double.
	 * @param integer $p_weight     Thickness in points.
	 * @return void
	 */
	function setBorder( $p_color, $p_line_style = 'Continuous', $p_weight = 1 ) {
		if( !isset( $this->border ) ) {
			$this->border = new Border();
		}

		if( $p_color != '' ) {
			$this->border->color = $p_color;
		}

		if( $p_line_style != '' ) {
			$this->border->lineStyle = $p_line_style;
		}

		if( $p_weight != -1 ) {
			$this->border->weight = $p_weight;
		}
	}

	/**
	 * Sets the alignment for the style
	 *
	 * @param integer $p_wrap_text  Either 1 to wrap, 0 to not wrap.
	 * @param string  $p_horizontal Automatic, Left, Center, Right, Fill, Justify, CenterAcrossSelection, Distributed, and JustifyDistributed.
	 * @param string  $p_vertical   Automatic, Top, Bottom, Center, Justify, Distributed, and JustifyDistributed.
	 * @return void
	 */
	function setAlignment( $p_wrap_text, $p_horizontal = '', $p_vertical = '' ) {
		if( !isset( $this->alignment ) ) {
			$this->alignment = new Alignment();
		}

		if( $p_wrap_text != '' ) {
			$this->alignment->wrapText = $p_wrap_text;
		}

		if( $p_horizontal != '' ) {
			$this->alignment->horizontal = $p_horizontal;
		}

		if( $p_vertical != '' ) {
			$this->alignment->vertical = $p_vertical;
		}
	}

	/**
	 * Return XML
	 * @return string
	 */
	function asXml() {
		$t_xml = '<ss:Style ss:ID="' . $this->id.'" ss:Name="'.$this->id.'" ';
		if( $this->parent_id != '' ) {
			$t_xml .= 'ss:Parent="' . $this->parent_id .'" ';
		}
		$t_xml .= '>';
		if( $this->interior ) {
			$t_xml .= $this->interior->asXml();
		}
		if( $this->font ) {
			$t_xml .= $this->font->asXml();
		}
		if( $this->border ) {
			$t_xml .= $this->border->asXml();
		}
		if( $this->alignment ) {
			$t_xml .= $this->alignment->asXml();
		}
		$t_xml .= '</ss:Style>'."\n";

		return $t_xml;
	}
}

/**
 * Interior
 */
class Interior {
	/**
	 * Color
	 */
	public $color;

	/**
	 * Pattern
	 */
	public $pattern;

	/**
	 * Return XML
	 * @return string
	 */
	function asXml() {
		$t_xml = '<ss:Interior ';

		if( $this->color ) {
		   $t_xml .= 'ss:Color="' . $this->color .'" ss:Pattern="'. $this->pattern . '" ';
		}

		$t_xml .= '/>';

		return $t_xml;
	}
}

/**
 * Font
 */
class Font {
	/**
	 * Bold
	 */
	public $bold;

	/**
	 * Colour
	 */
	public $color;

	/**
	 * Font Name
	 */
	public $fontName;

	/**
	 * Italic
	 */
	public $italic;

	/**
	 * Return XML
	 * @return string
	 */
	function asXml() {
		$t_xml = '<ss:Font ';

		if( $this->bold ) {
			$t_xml .= 'ss:Bold="' . $this->bold .'" ';
		}

		if( $this->color ) {
			$t_xml .= 'ss:Color="' . $this->color .'" ';
		}

		if( $this->fontName ) {
			$t_xml .= 'ss:FontName="' . $this->fontName .'" ';
		}

		if( $this->italic ) {
			$t_xml .= 'ss:Italic="' . $this->italic .'" ';
		}

		$t_xml .= '/>';

		return $t_xml;
	}
}

/**
 * Border
 */
class Border {
	/**
	 * Border Positions
	 */
	private $positions = array('Left', 'Top', 'Right', 'Bottom');

	/**
	 * Color
	 */
	public $color;

	/**
	 * Line Style
	 */
	public $lineStyle;

	/**
	 * Border Weight
	 */
	public $weight;

	/**
	 * Return XML
	 * @return string
	 */
	function asXml() {
		$t_xml = '<ss:Borders>';

		foreach ( $this->positions as $p_position ) {
			$t_xml.= '<ss:Border ss:Position="' . $p_position .'" ';

			if( $this->lineStyle ) {
				$t_xml .= 'ss:LineStyle="' . $this->lineStyle .'" ';
			}

			if( $this->color ) {
				$t_xml .= 'ss:Color="' . $this->color .'" ';
			}

			if( $this->weight ) {
				$t_xml .= 'ss:Weight="' . $this->weight .'" ';
			}

			$t_xml.= '/>';
		}

		$t_xml .= '</ss:Borders>';

		return $t_xml;
	}
}

/**
 * Alignment
 */
class Alignment {
	/**
	 * Wrap Text
	 */
	public $wrapText;

	/**
	 * Horizontal
	 */
	public $horizontal;

	/**
	 * Vertical
	 */
	public $vertical;

	/**
	 * Return XML
	 * @return string
	 */
	function asXml() {
		$t_xml = '<ss:Alignment ';

		if( $this->wrapText ) {
			$t_xml .= 'ss:WrapText="' . $this->wrapText.'" ';
		}

		if( $this->horizontal ) {
			$t_xml .= 'ss:Horizontal="' . $this->horizontal.'" ';
		}

		if( $this->vertical ) {
			$t_xml .= 'ss:Vertical="' . $this->vertical.'" ';
		}

		$t_xml .= '/>';

		return $t_xml;
	}
}

// ADD HBT 
// Inicio Req 679 (578)
function as400_prepare_string( $p_value ) {
	$t_type = is_numeric( $p_value ) ? 'Number' : 'String';

	$t_value = str_replace( array ( '&', "\n", '<', '>'), array ( '&amp;', '&#10;', '&lt;', '&gt;'),  $p_value );
	$t_ret = "<Cell><Data ss:Type=\"$t_type\">" . $t_value . "</Data></Cell>\n";

	return $t_ret;
} //Fin Req 679 (578)


// Inicio Req 679 (578)
function as400_prepare_date_string( $p_value ) {
	$t_type = is_numeric( $p_value ) ? 'String' : 'String';

	$t_value = str_replace( array ( '&', "\n", '<', '>'), array ( '&amp;', '&#10;', '&lt;', '&gt;'),  $p_value );
	$t_ret = "<Cell><Data ss:Type=\"$t_type\">" . $t_value . "</Data></Cell>\n";

	return $t_ret;
} //Fin Req 679 (578)

/**
 * Gets the formatted project id value.
 * @param $p_project_id The project id.
 * @returns The project vernue name.
 * Req 679 (578)
 */
function as400_format_project_id( $p_project_id ) {
	return as400_prepare_string( project_vernue_get_name( $p_project_id ) );
}

/**
 * Gets the formatted handler id.
 * @param $p_handler_id The handler id.
 * @returns The handler user name or 'N/A' string.
 * Req 679 (578) 
 */
function as400_format_handler_id( $p_handler_id ) {
	if( $p_handler_id > 0 ) {
		return excel_prepare_string( user_get_name( $p_handler_id ) );
	} else {
		return excel_prepare_string( 'N/A' );
	}
}
/**
 * Se realizo este metodo para
 * obtener el mismo resultado al 
 * exportar las incidencias AS_400
 * que el que se tenia en la version anterior
 * @param $p_eta 
 * @returns Si $p_eta es igual a 10, valor
 * por defecto devuelve un 0 si no el valor
 * que contenga ese campo
 * Req 679 (578) 
 */
function as400_format_eta( $p_eta ) {
	if( $p_eta != 10 ) {
		return excel_prepare_string($p_eta);
	} else {
		return excel_prepare_string( '0' );
	}
}


/**
 * Req 679 (578)
 * Gets the formatted duplicate id.
 * @param $p_duplicate_id The duplicate id.
 * @returns The duplicate id prefixed with 0s.
 */
function excel_format_duplicate_id( $p_duplicate_id ) {
	return excel_prepare_string( bug_format_id( $p_duplicate_id ) );
}

/**
 * Gets the formatted version.
 * @param $p_version The product version
 * @returns the product version for as400.
 * Req 679 (578)
 * Rqto 790 eslondono
 */
function as400_format_version( $p_version ) {
	$trim=trim($p_version);
	$string=(string) $trim;

	$cont=0;

	for ($i = 0; $i < strlen($string); $i++){         
		if(ord($string[$i])!=46){
			
			$cont ++;
		}
		
	}
	
	if ($cont==strlen($string)){
			if ($cont!=0){
				return excel_prepare_string('V_Producto:'.$string);
				
			}else{
				return excel_prepare_string('N/A');
			}
  	}else if ($cont!=strlen($string)){
   		return excel_prepare_string($string.' ');
   	}else{ 
		return excel_prepare_string('N/A');
   	}
}
	
/**
 * Gets the formatted fixed in version for as400.
 * @param $p_fixed_in_version The product fixed in version
 * @returns the fixed in version.
 * Req 679 (578)
 * Rqto 790 eslondono
 */
function as400_format_fixed_in_version( $p_fixed_in_version ) {
	$trim=trim($p_fixed_in_version);
		$string=(string) $trim;
	
		$cont=0;
	
		for ($i = 0; $i < strlen($string); $i++){         
			if(ord($string[$i])!=46){
				
				$cont ++;
		}
		}
		
		if ($cont==strlen($string)){
				if ($cont!=0){
					return excel_prepare_string('V_Producto:'.$string);
					
				}else{
					return excel_prepare_string('N/A');
				}
		  }else if ($cont!=strlen($string)){
			   return excel_prepare_string($string.' ');
		   }else{ 
			return excel_prepare_string('N/A');
		   }
	}

	/**
 * Gets the formatted operating system.
 * @param $p_os The operating system
 * @returns the operating system for as400
 * Req 679 (578)
 * Rqto 790 eslondono
 */
function as400_format_os( $p_os ) {
	$trim=trim($p_os);
	$string=(string) $trim;

	for ($i = 0; $i < strlen($string); $i++){         
		if($to_ascii>=48 && ord($string[$i])<=57){
			$to_ascii= ord($string[0]);	 		
		}else{
			$to_ascii += ord($string[$i]);
		}
   	}
	
	if ($to_ascii>=48 && $to_ascii<=57){
   		return excel_prepare_string('SO: '.$string);
   		}else if($to_ascii>=58 ){
			return excel_prepare_string($string);
		}else if($to_ascii>=33 && $to_ascii<=47){
			return excel_prepare_string($string);
		}else{		
			return excel_prepare_string( 'N/A');
		}		
}

/**
 * Gets the formatted operating system build (version).
 * @param $p_os The operating system build (version)
 * @returns the operating system build (version) for as400
 * Req 679 (578)
 * Rqto 790 eslondono
 */
function as400_format_os_build( $p_os_build ) {
	$trim=trim($p_os_build);
		$string=(string) $trim;
	
		for ($i = 0; $i < strlen($string); $i++){         
			if(ord($string[$i])>=48 && ord($string[$i])<=57){
				$to_ascii= ord($string[0]);	 		
			}else{
				$to_ascii += ord($string[$i]);
			}
		   }
		
		if ($to_ascii>=48 && $to_ascii<=57){
			   return excel_prepare_string('Version_SO:'.$string);
			   }else if($to_ascii>=58 ){
				return excel_prepare_string($string);
			}else if($to_ascii>=33 && $to_ascii<=47){
				return excel_prepare_string($string);
			}else{		
				return excel_prepare_string( 'N/A');
			}
			
		
	}
	
	/**
 * Gets the formatted platform,
 * @param $p_platform The platform
 * @returns the platform for as400.
 * Req 679 (578)
 * Rqto 790 eslondono
 */
function as400_format_platform( $p_platform ) {
	$trim=trim($p_platform);
	$string=(string) $trim;

	for ($i = 0; $i < strlen($string); $i++){         
		if(ord($string[$i])>=48 && ord($string[$i])<=57){
			$to_ascii= ord($string[0]);	 		
		}else{
			$to_ascii += ord($string[$i]);
		}
   	}
	
	if ($to_ascii>=48 && $to_ascii<=57){
   		return excel_prepare_string('Plataforma: '.$string);
   		}else if($to_ascii>=58 ){
			return excel_prepare_string($string);
		}else if($to_ascii>=33 && $to_ascii<=47){
			return excel_prepare_string($string);
		}else{		
			return excel_prepare_string( 'N/A');
		}
}

function as400_format_date_submitted( $p_date_submitted ) {
	return as400_prepare_date_string( date( config_get( 'vernue_date_format' ), $p_date_submitted ) );
	//return excel_prepare_string( date( config_get( 'vernue_date_format' ), $p_date_submitted ) );
}

/**
 * Gets the formatted value for the specified issue id, project and custom field for as400.
 * @param $p_issue_id The issue id.
 * @param $p_project_id The project id.
 * @param $p_custom_field The custom field name (without 'custom_' prefix).
 * @returns The custom field value.
 * Req 679 (578)
 * Rqto 790 eslondono
 */
function as400_format_custom_field( $p_issue_id, $p_project_id, $p_custom_field ) {
	$t_field_id = custom_field_get_id_from_name( $p_custom_field );

	if( $t_field_id === false ) {
		return excel_prepare_string( '@' . $p_custom_field . '@' );
	}

	if( custom_field_is_linked( $t_field_id, $p_project_id ) ) {
		$t_def = custom_field_get_definition( $t_field_id );
		$t_custom_field_value = string_custom_field_value($t_def, $t_field_id, $p_issue_id );
		$t_custom_field_value_trim=trim($t_custom_field_value);
		if($t_custom_field_value_trim != ''){

			if($t_field_id==8){
			
				for ($i = 0; $i < strlen($t_custom_field_value_trim); $i++){         
				if(ord($t_custom_field_value_trim[$i])>=48 && ord($t_custom_field_value_trim[$i])<=57){
					$to_ascii= ord($t_custom_field_value_trim[0]);	 		
				}else{
					$to_ascii += ord($t_custom_field_value_trim[$i]);
				}
		   	}
			
			if ($to_ascii>=48 && $to_ascii<=57){
		   		return excel_prepare_string('Fuente:'.$t_custom_field_value_trim);
		   		}else if($to_ascii>=58 ){
					return excel_prepare_string($t_custom_field_value_trim);
				}else if($to_ascii>=33 && $to_ascii<=47){
					return excel_prepare_string($t_custom_field_value_trim);
				}else{		
					return excel_prepare_string( 'N/A');
				}
				
			}else if ($t_field_id==4){
					$cadena = $t_custom_field_value_trim;
					$cadena_nueva = ereg_replace("[^0-9]","", $cadena);
					$cadena2 = str_replace('160', '', $cadena_nueva);										
					return excel_prepare_string($cadena2);
					
			}else{			
				return excel_prepare_string($t_custom_field_value_trim);
			}
			
			//return excel_prepare_string( $t_custom_field_value_trim);
		}else if($t_field_id==4){
			return excel_prepare_string ('0');
		}else{
			return excel_prepare_string ('N/A');
		}
		
	}else

	// field is not linked to project
	return excel_prepare_string( 'N/A' );
}

#Req 679 (578) Imprime la fecha de corte
function as400_last_date(){
	$now = getdate(); 
	$month = $now["mon"];
	$year = $now["year"];		
	$lastDateMonth = lastDate($month,$year);
	return as400_prepare_date_string ($lastDateMonth);
}
/**
 * Requerimiento 804.
 * Este m�todo genera la primera fila del informe, con los nombres de las columnas
 */
function columnas_informe() {
	#Obtenemos las columanas que con que vamos a trabajar en el reporte.
	// $t_columns = config_get('columnas_informe');

	$t_columns=array('id','severity', 'informe_tipo_incidencia','status','resolution', 'reporter_id', 'handler_id','informe_naturaleza',
								'informe_entrega','informe_iteracion','informe_resonsable_inyeccion','informe_fuente',
								'informe_modulo_funcional','FechaAsig','FechaRsolv','TiempoAtec','informe_casos_prueba_frenados');
	#Iniciamos la fila
	$t_ret = '<Row>';
	#Recorremos las columnas que se van a mostrar para colocar los nombres reales
	foreach( $t_columns as $t_column ) {
		$t_column_title = lang_get($t_column);
		#Ahora concatenamos cada uno de los valores que capturamos.
		$t_ret .= excel_format_column_title( $t_column_title );
	}
	#Finalizamos la fila.
	$t_ret .= '</Row>';
	#Retornamos.
	return $t_ret;
}

/**
 * Requerimiento 804.
 * M�todo que permite env�ar al m�todo excel_prepare_string el valor de 
 * la Fuente para colocarlo en una celda del informe.
 * @param $id
 */
function excel_format_informe_fuente($value) {
	return excel_prepare_string( $value );
}
/**
 * Requerimiento 804.
 * M�todo que permite env�ar al m�todo excel_prepare_string el valor de la 
 * Iteraci�n para colocarlo en una celda del informe.
 * @param $id
 */
function excel_format_informe_iteracion($value) {
	return excel_prepare_string( $value );
}

/**
 * jatellez
 * Requerimiento 946.
 * M�todo que permite env�ar al m�todo excel_prepare_string el valor de los 
 * casos_prueba_frenados para colocarlo en una celda del informe.
 * @param $id
 */
function excel_format_informe_casos_prueba_frenados($value) {
	return excel_prepare_string( $value );
}
/**
 * Requerimiento 804.
 * M�todo que permite env�ar al m�todo excel_prepare_string el valor de 
 * Modulo Funcional para colocarlo en una celda del informe.
 * @param $id
 */
function excel_format_informe_modulo_funcional($value) {
	return excel_prepare_string( $value );
}

/**
 * Requerimiento 804.
 * M�todo que permite env�ar al m�todo excel_prepare_string el valor de Entrega 
 * para colocarlo en una celda del informe.
 * @param $id
 */
function excel_format_informe_entrega($value) {
	return excel_prepare_string( $value );
}

/**
 * Requerimiento 804.
 * M�todo que permite env�ar al m�todo excel_prepare_string el valor de 
 * Tipo de Incidencia para colocarlo en una celda del informe.
 * @param $id
 */
function excel_format_informe_tipo_incidencia($value) {
	return excel_prepare_string( $value );
}

/**
 * Requerimiento 804.
 * M�todo que permite env�ar al m�todo excel_prepare_string el valor de 
 * Naturaleza para colocarlo en una celda del informe.
 * @param $id
 */
function excel_format_informe_naturaleza($value) {
	return excel_prepare_string( $value );
}

/**
 * Requerimiento 804.
 * M�todo que permite env�ar al m�todo excel_prepare_string el valor de
 * Responsable de inyecci�n para colocarlo en una celda del informe.
 * @param $id
 */
function excel_format_informe_resonsable_inyeccion($value) {
	return excel_prepare_string( $value );
}

/**
 * Requerimiento 804.
 * M�todo que permite env�ar al m�todo excel_prepare_string el valor de
 * Responsable de inyecci�n para colocarlo en una celda del informe.
 * @param $id
 */
function excel_format_FechaAsig($value) {
	return excel_prepare_string( $value );
}


/**
 * Requerimiento 804.
 * M�todo que permite env�ar al m�todo excel_prepare_string el valor de
 * Responsable de inyecci�n para colocarlo en una celda del informe.
 * @param $id
 */
function excel_format_FechaRsolv($value) {
	return excel_prepare_string( $value );
}


/**
 * Requerimiento 804.
 * M�todo que permite env�ar al m�todo excel_prepare_string el valor de
 * Responsable de inyecci�n para colocarlo en una celda del informe.
 * @param $id
 */
function excel_format_TiempoAtec($value) {
	return excel_prepare_string( $value );
}

/**
 * Requerimiento 808.
 * Este m�todo genera la primera fila del informe, con los nombres de las columnas
 */
function columnas_informe_niveles_de_servicio() {
	#Obtenemos las columanas que con que vamos a trabajar en el reporte.
	$t_columns = config_get('columnas_informe_niveles_servicio');
	#Iniciamos la fila
	$t_ret = '<Row>';
	#Recorremos las columnas que se van a mostrar para colocar los nombres reales
	foreach( $t_columns as $t_column ) {
		$t_column_title = lang_get($t_column);
		#Ahora concatenamos cada uno de los valores que capturamos.
		$t_ret .= excel_format_column_title( $t_column_title );
	}
	#Finalizamos la fila.
	$t_ret .= '</Row>';
	#Retornamos.
	return $t_ret;
}

/**
 * Requerimiento 808.
 * Este m�todo genera la primera fila del informe, con los nombres de las columnas
 */
function columnas_informe_niveles_servicio_cumplimiento_SLA() {
	#Obtenemos las columanas que con que vamos a trabajar en el reporte.
	$t_columns = config_get('columnas_informe_niveles_servicio_cumplimiento_SLA');
	#Iniciamos la fila
	$t_ret = '<Row>';
	#Recorremos las columnas que se van a mostrar para colocar los nombres reales
	foreach( $t_columns as $t_column ) {
		$t_column_title = lang_get($t_column);
		#Ahora concatenamos cada uno de los valores que capturamos.
		$t_ret .= excel_format_column_title( $t_column_title );
	}
	#Finalizamos la fila.
	$t_ret .= '</Row>';
	#Retornamos.
	return $t_ret;
}

/**
 * Requerimiento 808.
 * M�todo que permite finalizar una hoja en el libro de calculo.
 */
function excel_get_footer_fin_hoja() {
	return "</Table>\n</Worksheet>";
}

/**
 * Requerimiento 808.
 * M�todo que permite crear una nueva hoja en el libro de calculo.
 * @param $p_worksheet_title titulo de la hoja.
 */
function nueva_hoja ($p_worksheet_title) {
	return "<Worksheet ss:Name=\"" . urlencode( $p_worksheet_title ) . "\">\n<Table>\n<Column ss:Index=\"1\" ss:AutoFitWidth=\"0\" ss:Width=\"110\"/>\n";
}

/**
 * Requerimiento 808.
 * M�todo que permite env�ar al m�todo excel_prepare_string el valor de
 * Responsable de inyecci�n para colocarlo en una celda del informe.
 * @param $id
 */
function excel_format_totalIncidenciasPeriodo($value) {
	return excel_prepare_string( $value );
}

/**
 * Requerimiento 808.
 * M�todo que permite imprimir el valor para la columna total incidencias solucionadas.
 * @param $value
 */
function excel_format_totalIncidenciasSolucionadas($value) {
	return excel_prepare_string( $value );
}

/**
 * Requerimiiento 808.
 * M�todo que permite imprimir el valor para la columna total incidencias no
 * solucionadas.
 * @param $value
 */
function excel_format_totalIncidenciasNoSolucionadas($value) {
	return excel_prepare_string( $value );
}

/**
 * Requerimiiento 808.
 * M�todo que permite imprimir el valor para la columna porcentajde de cumplimiento
 * @param $value
 */
function excel_format_porcentajeCumplimiento($value) {
	return excel_prepare_string( $value );
}

/**
 * Requerimiiento 808.
 * M�todo que permite imprimir el valor para la columna cumple?
 * @param $value
 */
function excel_format_cumple($value) {
	return excel_prepare_string( $value );
}

/**
 * Requerimiiento 808.
 * M�todo que permite imprimir una fila en blanco.
 */
function excel_fila_blanco () {
	return "<Row></Row>";
}

/**
 * Requerimiento 808.
 * M�todo que nos permite imprimir un valor cualquiera en el excel.
 * @param String $value
 */
function excel_imprimir_valor_string($value) {
	return excel_prepare_string( $value );
}

/**
 * Requerimiento 808.
 * Este m�todo genera la primera fila del informe, con los nombres de las columnas
 */
function columnas_porcentaje_para_cumplimiento_SLA() {
	#Obtenemos las columanas que con que vamos a trabajar en el reporte.
	$t_columns = config_get('columnas_porcentajes_establecidos_SLA');
	#Iniciamos la fila
	$t_ret = '<Row>';
	#Recorremos las columnas que se van a mostrar para colocar los nombres reales
	foreach( $t_columns as $t_column ) {
		$t_column_title = lang_get($t_column);
		#Ahora concatenamos cada uno de los valores que capturamos.
		$t_ret .= excel_format_column_title( $t_column_title );
	}
	#Finalizamos la fila.
	$t_ret .= '</Row>';
	#Retornamos.
	return $t_ret;
}

/**
 * Requerimiiento 808.
 * M�todo que permite imprimir el valor para la columna cumple?
 * @param $value
 */
function excel_format_porcentaje_cumplido_cada_error_solucionado ($value){
	return excel_prepare_string( $value );
}

/**
 * Requerimiiento 808.
 * M�todo que permite imprimir el valor para la columna cumple?
 * @param $value
 */
function excel_format_cierre_final_de_pruebas ($value){
	return excel_prepare_string( $value );
}
/**
 * Requerimiento 808.
 * Incidencia 52079
 * Este m�todo genera la primera fila del cuadro de resumen con los nombres de las columnas
 */
function columnas_informe_niveles_servicio_cumplimiento_SLA_resumen_titulo_1($t_columns) {
	#Iniciamos la fila
	$t_ret = '<Row>';
	#Recorremos las columnas que se van a mostrar para colocar los nombres reales
	foreach( $t_columns as $t_column ) {
		if (empty($t_column)) {
			#Ahora concatenamos cada uno de los valores que capturamos.
			$t_ret .= excel_format_column_title( $t_column );
		} else {
			#Ahora concatenamos cada uno de los valores que capturamos.
			$t_ret .= excel_format_column_title_2_columnas_unidas( $t_column );
		}
	}
	#Finalizamos la fila.
	$t_ret .= '</Row>';
	#Retornamos.
	return $t_ret;
}

/**
 * Requerimiento 808.
 * Incidencia 52079
 * Este m�todo genera la primera fila del informe, con los nombres de las columnas
 */
function columnas_informe_niveles_servicio_cumplimiento_SLA_resumen_titulo_2($t_columns) {
	#Iniciamos la fila
	$t_ret = '<Row>';
	#Recorremos las columnas que se van a mostrar para colocar los nombres reales
	foreach( $t_columns as $t_column ) {
		#Ahora concatenamos cada uno de los valores que capturamos.
		$t_ret .= excel_format_column_title( $t_column );
	}
	#Finalizamos la fila.
	$t_ret .= '</Row>';
	#Retornamos.
	return $t_ret;
}

/**
 * Requerimiento 808.
 * Incidencia 52079
 * M�todo que nos permite mostrar un titulo en dos celdas unidas.
 * @returns The cell xml.
 */
function excel_format_column_title_2_columnas_unidas( $p_column_title ) {
	return '<Cell ss:MergeAcross="1"><Data ss:Type="String">' . $p_column_title . '</Data></Cell>';
}
/**
 * Reqto 838
 * M�todo que permite env�ar al m�todo excel_prepare_string el valor de 
 * la fecha en que paso a resuelta la incidencia para colocarlo en una celda del informe.
 * @param unknown_type $p_date_resolved
 */

function excel_format_fecha_resuelta( $p_fecha_resuelta ) {
	return excel_prepare_string( $p_fecha_resuelta);
}

/**
 * Reqto 838
 * M�todo que permite env�ar al m�todo excel_prepare_string el valor de 
 * los tiempos de la incidencia para colocarlo en una celda del informe.
 * @param unknown_type $p_date_resolved
 */

function excel_format_tiempo_incidencia( $p_tiempo_incidencia ) {
	return excel_prepare_string( $p_tiempo_incidencia);
}
#Rqto_929 - ayoung
#Se reutilizan las funciones de las notas de RUNT-2 para
#el proyecto Cliente COLPENFAB
#===================================================================
#jatellez rqto 909,
#se crean 20 funciones para las Notas
#====================================================================
/**
 * M�todos que permiten env�ar al m�todo excel_prepare_string el valor de 
 * las notas para colocarlo en una celda del informe.
 * @param 
 */
function excel_format_nota1( $p_nota1 ) {
	return excel_prepare_string( $p_nota1);
}
function excel_format_nota2( $p_nota2 ) {
	return excel_prepare_string( $p_nota2);
}
function excel_format_nota3( $p_nota3 ) {
	return excel_prepare_string( $p_nota3);
}
function excel_format_nota4( $p_nota4 ) {
	return excel_prepare_string( $p_nota4);
}
function excel_format_nota5( $p_nota5 ) {
	return excel_prepare_string( $p_nota5);
}
function excel_format_nota6( $p_nota6 ) {
	return excel_prepare_string( $p_nota6);
}
function excel_format_nota7( $p_nota7 ) {
	return excel_prepare_string( $p_nota7);
}
function excel_format_nota8( $p_nota8 ) {
	return excel_prepare_string( $p_nota8);
}
function excel_format_nota9( $p_nota9 ) {
	return excel_prepare_string( $p_nota9);
}
function excel_format_nota10( $p_nota10) {
	return excel_prepare_string( $p_nota10);
}
function excel_format_nota11( $p_nota11) {
	return excel_prepare_string( $p_nota11);
}
function excel_format_nota12( $p_nota12) {
	return excel_prepare_string( $p_nota12);
}
function excel_format_nota13( $p_nota13) {
	return excel_prepare_string( $p_nota13);
}
function excel_format_nota14( $p_nota14) {
	return excel_prepare_string( $p_nota14);
}
function excel_format_nota15( $p_nota15) {
	return excel_prepare_string( $p_nota15);
}
function excel_format_nota16( $p_nota16) {
	return excel_prepare_string( $p_nota16);
}
function excel_format_nota17( $p_nota17) {
	return excel_prepare_string( $p_nota17);
}
function excel_format_nota18( $p_nota18) {
	return excel_prepare_string( $p_nota18);
}
function excel_format_nota19( $p_nota19) {
	return excel_prepare_string( $p_nota19);
}
function excel_format_nota20( $p_nota20) {
	return excel_prepare_string( $p_nota20);
}
#===================================================================
#jatellez rqto 909,
#se crean 20 funciones para las fechas de las notas 
#====================================================================
/**
 * M�todos que permiten env�ar al m�todo excel_prepare_string el valor de 
 * las fechas_notas para colocarlo en una celda del informe.
 * @param 
 */
function excel_format_fecha_nota1( $p_fecha_nota1 ) {
	return excel_prepare_string( $p_fecha_nota1);
}
function excel_format_fecha_nota2( $p_fecha_nota2 ) {
	return excel_prepare_string( $p_fecha_nota2);
}
function excel_format_fecha_nota3( $p_fecha_nota3 ) {
	return excel_prepare_string( $p_fecha_nota3);
}
function excel_format_fecha_nota4( $p_fecha_nota4 ) {
	return excel_prepare_string( $p_fecha_nota4);
}
function excel_format_fecha_nota5( $p_fecha_nota5 ) {
	return excel_prepare_string( $p_fecha_nota5);
}
function excel_format_fecha_nota6( $p_fecha_nota6 ) {
	return excel_prepare_string( $p_fecha_nota6);
}
function excel_format_fecha_nota7( $p_fecha_nota7 ) {
	return excel_prepare_string( $p_fecha_nota7);
}
function excel_format_fecha_nota8( $p_fecha_nota8 ) {
	return excel_prepare_string( $p_fecha_nota8);
}
function excel_format_fecha_nota9( $p_fecha_nota9 ) {
	return excel_prepare_string( $p_fecha_nota9);
}
function excel_format_fecha_nota10( $p_fecha_nota10 ) {
	return excel_prepare_string( $p_fecha_nota10);
}
function excel_format_fecha_nota11( $p_fecha_nota11 ) {
	return excel_prepare_string( $p_fecha_nota11);
}
function excel_format_fecha_nota12( $p_fecha_nota12 ) {
	return excel_prepare_string( $p_fecha_nota12);
}
function excel_format_fecha_nota13( $p_fecha_nota13 ) {
	return excel_prepare_string( $p_fecha_nota13);
}
function excel_format_fecha_nota14( $p_fecha_nota14 ) {
	return excel_prepare_string( $p_fecha_nota14);
}
function excel_format_fecha_nota15( $p_fecha_nota15 ) {
	return excel_prepare_string( $p_fecha_nota15);
}
function excel_format_fecha_nota16( $p_fecha_nota16 ) {
	return excel_prepare_string( $p_fecha_nota16);
}
function excel_format_fecha_nota17( $p_fecha_nota17 ) {
	return excel_prepare_string( $p_fecha_nota17);
}
function excel_format_fecha_nota18( $p_fecha_nota18 ) {
	return excel_prepare_string( $p_fecha_nota18);
}
function excel_format_fecha_nota19( $p_fecha_nota19 ) {
	return excel_prepare_string( $p_fecha_nota19);
}
function excel_format_fecha_nota20( $p_fecha_nota20 ) {
	return excel_prepare_string( $p_fecha_nota20);
}
#fin rqto 909
#Fin Rqto_929 - ayoung
/**
 * Gets the formatted date last updated.
 * @param $p_last_updated The date last updated.
 * @returns the date last updated in vernue date format.
 * Req 679 (578)
 */
function as400_format_last_updated( $p_last_updated ) {
	return as400_prepare_date_string( date( config_get( 'vernue_date_format' ), $p_last_updated ) );
	//return excel_prepare_string( date( config_get( 'vernue_date_format' ), $p_last_updated ) );
}

// FIN ADD HBT