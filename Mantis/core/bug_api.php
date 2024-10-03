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
 * Bug API
 *
 * @package CoreAPI
 * @subpackage BugAPI
 * @copyright Copyright 2000 - 2002  Kenzaburo Ito - kenito@300baud.org
 * @copyright Copyright 2002  MantisBT Team - mantisbt-dev@lists.sourceforge.net
 * @link http://www.mantisbt.org
 *
 * @uses access_api.php
 * @uses antispam_api.php
 * @uses authentication_api.php
 * @uses bugnote_api.php
 * @uses bug_revision_api.php
 * @uses category_api.php
 * @uses config_api.php
 * @uses constant_inc.php
 * @uses custom_field_api.php
 * @uses database_api.php
 * @uses date_api.php
 * @uses email_api.php
 * @uses error_api.php
 * @uses event_api.php
 * @uses file_api.php
 * @uses helper_api.php
 * @uses history_api.php
 * @uses lang_api.php
 * @uses mention_api.php
 * @uses relationship_api.php
 * @uses sponsorship_api.php
 * @uses tag_api.php
 * @uses user_api.php
 * @uses utility_api.php
 */

require_api( 'access_api.php' );
require_api( 'antispam_api.php' );
require_api( 'authentication_api.php' );
require_api( 'bugnote_api.php' );
require_api( 'bug_revision_api.php' );
require_api( 'category_api.php' );
require_api( 'config_api.php' );
require_api( 'constant_inc.php' );
require_api( 'custom_field_api.php' );
require_api( 'database_api.php' );
require_api( 'date_api.php' );
require_api( 'email_api.php' );
require_api( 'error_api.php' );
require_api( 'event_api.php' );
require_api( 'file_api.php' );
require_api( 'helper_api.php' );
require_api( 'history_api.php' );
require_api( 'lang_api.php' );
require_api( 'mention_api.php' );
require_api( 'relationship_api.php' );
require_api( 'sponsorship_api.php' );
require_api( 'tag_api.php' );
require_api( 'user_api.php' );
require_api( 'utility_api.php' );

use Mantis\Exceptions\ClientException;

/**
 * Bug Data Structure Definition
 *
 * @property int id
 * @property int project_id
 * @property int reporter_id
 * @property int handler_id
 * @property int duplicate_id
 * @property int priority
 * @property int severity
 * @property int reproducibility
 * @property int status
 * @property int resolution
 * @property int projection
 * @property int category_id
 * @property int date_submitted
 * @property int last_updated
 * @property int eta
 * @property string os
 * @property string os_build
 * @property string platform
 * @property string version
 * @property string fixed_in_version
 * @property string target_version
 * @property string build
 * @property int view_state
 * @property string summary
 * @property float sponsorship_total
 * @property int sticky
 * @property int due_date
 * @property int profile_id
 * @property string description
 * @property string steps_to_reproduce
 * @property string additional_information
 */
class BugData {
	/**
	 * Bug ID
	 */
	protected $id;

	/**
	 * Project ID
	 */
	protected $project_id = null;

	/**
	 * Reporter ID
	 */
	protected $reporter_id = 0;

	/**
	 * Bug Handler ID
	 */
	protected $handler_id = 0;

	/**
	 * Duplicate ID
	 */
	protected $duplicate_id = 0;

	/**
	 * Priority
	 */
	protected $priority = NORMAL;

	/**
	 * Severity
	 */
	protected $severity = MINOR;

	/**
	 * Reproducibility
	 */
	protected $reproducibility = 10;

	/**
	 * Status
	 */
	protected $status = NEW_;

	/**
	 * Resolution
	 */
	protected $resolution = OPEN;

	/**
	 * Projection
	 */
	protected $projection = 10;

	/**
	 * Category ID
	 */
	protected $category_id = 1;

	/**
	 * Date Submitted
	 */
	protected $date_submitted = '';

	/**
	 * Last Updated
	 */
	protected $last_updated = '';

	/**
	 * ETA
	 */
	protected $eta = 10;

	/**
	 * OS
	 */
	protected $os = '';

	/**
	 * OS Build
	 */
	protected $os_build = '';

	/**
	 * Platform
	 */
	protected $platform = '';

	/**
	 * Version
	 */
	protected $version = '';

	/**
	 * Fixed in version
	 */
	protected $fixed_in_version = '';

	/**
	 * Target Version
	 */
	protected $target_version = '';

	/**
	 * Build
	 */
	protected $build = '';

	/**
	 * View State
	 */
	protected $view_state = VS_PUBLIC;

	/**
	 * Summary
	 */
	protected $summary = '';

	/**
	 * Sponsorship Total
	 */
	protected $sponsorship_total = 0;

	/**
	 * Sticky
	 */
	protected $sticky = 0;

	/**
	 * Due Date
	 */
	protected $due_date = '';

	// ADD HBT.
	protected $summary_791 = '';
	protected $duration_day_791 = 0;
	protected $duration_hours_791 = 0;
	protected $delivery_belong_791 = '';
	protected $type_delivery_791 = '';
	protected $delivery_status_791 = '';
	protected $date_day_planned_791 = 0;
	protected $date_mounth_planned_791 = 0;
	protected $date_year_planned_791 = 0;
	protected $date_day_real_791 = 0;
	protected $date_mounth_real_791 = 0;
	protected $date_year_real_791 = 0;
	protected $date_mounth_return_791 = 0;
	protected $date_year_return_791 = 0;
	protected $date_day_return_791 = 0;
	protected $cause_return_791 = '' ;

	#querimiento 865
	#Campo que almacena el usuario que tiene asignada la incidencia internamente.
	protected $handler_hbt_id = 0;

	// FIN ADD HBT

	/**
	 * Profile ID
	 */
	protected $profile_id = 0;

	/**
	 * Description
	 */
	protected $description = '';

	/**
	 * Steps to reproduce
	 */
	protected $steps_to_reproduce = '';

	/**
	 * Additional Information
	 */
	protected $additional_information = '';

	/**
	 * Stats
	 */
	private $_stats = null;

	/**
	 * Attachment Count
	 */
	public $attachment_count = null;

	/**
	 * Bugnotes count
	 */
	public $bugnotes_count = null;

	/**
	 * Indicates if bug is currently being loaded from database
	 */
	private $loading = false;

	/**
	 * return number of file attachment's linked to current bug
	 * @return integer
	 */
	public function get_attachment_count() {
		if( $this->attachment_count === null ) {
			$this->attachment_count = file_bug_attachment_count( $this->id );
			return $this->attachment_count;
		} else {
			return $this->attachment_count;
		}
	}

	/**
	 * return number of bugnotes's linked to current bug
	 * @return integer
	 */
	public function get_bugnotes_count() {
		if( $this->bugnotes_count === null ) {
			$this->bugnotes_count = self::bug_get_bugnote_count();
			return $this->bugnotes_count;
		} else {
			return $this->bugnotes_count;
		}
	}

	/**
	 * Overloaded Function handling property sets
	 *
	 * @param string $p_name  Property name.
	 * @param string $p_value Value to set.
	 * @private
	 * @return void
	 */
	public function __set( $p_name, $p_value ) {
		switch( $p_name ) {
			# integer types
			case 'id':
			case 'project_id':
			case 'reporter_id':
			case 'handler_id':
			case 'duplicate_id':
			case 'priority':
			case 'severity':
			case 'reproducibility':
			case 'status':
			case 'resolution':
			case 'eta':
			case 'projection':
			case 'category_id':
				$p_value = (int)$p_value;
				break;
			case 'target_version':
				if( !$this->loading && $this->$p_name != $p_value ) {
					# Only set target_version if user has access to do so
					if( !access_has_project_level( config_get( 'roadmap_update_threshold' ) ) ) {
						trigger_error( ERROR_ACCESS_DENIED, ERROR );
					}
				}
				break;
			case 'due_date':
				if( !is_numeric( $p_value ) ) {
					$p_value = date_strtotime( $p_value );
				}
				break;
			case 'summary':
				# MySQL 4-bytes UTF-8 chars workaround #21101
				$p_value = db_mysql_fix_utf8( $p_value );
				# Fall through
			case 'build':
				if ( !$this->loading ) {
					$p_value = trim( $p_value );
				}
				break;
			case 'description':
			case 'steps_to_reproduce':
			case 'additional_information':
				# MySQL 4-bytes UTF-8 chars workaround #21101
				$p_value = db_mysql_fix_utf8( $p_value );
				break;

		}
		$this->$p_name = $p_value;
	}

	/**
	 * Overloaded Function handling property get
	 *
	 * @param string $p_name Property name.
	 * @private
	 * @return string|integer|boolean
	 */
	public function __get( $p_name ) {
		if( $this->is_extended_field( $p_name ) ) {
			$this->fetch_extended_info();
		}
		return $this->{$p_name};
	}

	/**
	 * Overloaded Function handling property isset
	 *
	 * @param string $p_name Property name.
	 * @private
	 * @return boolean
	 */
	public function __isset( $p_name ) {
		return isset( $this->{$p_name} );
	}

	/**
	 * fast-load database row into bugobject
	 * @param array $p_row Database result to load into a bug object.
	 * @return void
	 */
	public function loadrow( array $p_row ) {
		$this->loading = true;

		foreach( $p_row as $t_var => $t_val ) {
			$this->__set( $t_var, $p_row[$t_var] );
		}
		$this->loading = false;
	}

	/**
	 * Retrieves extended information for bug (e.g. bug description)
	 * @return void
	 */
	private function fetch_extended_info() {
		/*HBT Se comenta por Req 679 para que saque error al momento de que el campo descripción este vacio.
		if( $this->description == '' ) {
			$t_text = bug_text_cache_row( $this->id );

			$this->description = $t_text['description'];
			$this->steps_to_reproduce = $t_text['steps_to_reproduce'];
			$this->additional_information = $t_text['additional_information'];
		}*/
	}

	/**
	 * Returns if the field is an extended field which needs fetch_extended_info()
	 *
	 * @param string $p_field_name Field Name.
	 * @return boolean
	 */
	private function is_extended_field( $p_field_name ) {
		switch( $p_field_name ) {
			case 'description':
			case 'steps_to_reproduce':
			case 'additional_information':
				return true;
			default:
				return false;
		}
	}

	/**
	 * Returns the number of bugnotes for the given bug_id
	 * @return integer number of bugnotes
	 * @access private
	 * @uses database_api.php
	 */
	private function bug_get_bugnote_count() {
		if( !access_has_project_level( config_get( 'private_bugnote_threshold' ), $this->project_id ) ) {
			$t_restriction = 'AND view_state=' . VS_PUBLIC;
		} else {
			$t_restriction = '';
		}

		db_param_push();
		$t_query = 'SELECT COUNT(*) FROM {bugnote}
					  WHERE bug_id =' . db_param() . ' ' . $t_restriction;
		$t_result = db_query( $t_query, array( $this->id ) );

		return db_result( $t_result );
	}

	/**
	 * validate current bug object for database insert/update
	 * triggers error on failure
	 * @param boolean $p_update_extended Whether to validate extended fields.
	 * @return void
	 */
	function validate( $p_update_extended = true ) {
		# Summary cannot be blank
		if( is_blank( $this->summary ) ) {
			error_parameters( lang_get( 'summary' ) );
			trigger_error( ERROR_EMPTY_FIELD, ERROR );
		}

		if( $p_update_extended ) {
			# Description field cannot be empty
			if( is_blank( $this->description ) ) {
				error_parameters( lang_get( 'description' ) );
				trigger_error( ERROR_EMPTY_FIELD, ERROR );
			}
		}

		# Make sure a category is set
		if( 0 == $this->category_id && !config_get( 'allow_no_category' ) ) {
			error_parameters( lang_get( 'category' ) );
			trigger_error( ERROR_EMPTY_FIELD, ERROR );
		}

		# Ensure that category id is a valid category
		if( $this->category_id > 0 ) {
			category_ensure_exists( $this->category_id );
		}

		if( !is_blank( $this->duplicate_id ) && ( $this->duplicate_id != 0 ) && ( $this->id == $this->duplicate_id ) ) {
			trigger_error( ERROR_BUG_DUPLICATE_SELF, ERROR );
			# never returns
		}
	}

	/**
	 * Insert a new bug into the database
	 * @return integer integer representing the bug identifier that was created
	 * @access public
	 * @uses database_api.php
	 * @uses lang_api.php
	 */
	function create() {
		self::validate( true );

		antispam_check();

		# check due_date format
		if( is_blank( $this->due_date ) ) {
			$this->due_date = date_get_null();
		}
		# check date submitted and last modified
		if( is_blank( $this->date_submitted ) ) {
			$this->date_submitted = db_now();
		}
		if( is_blank( $this->last_updated ) ) {
			$this->last_updated = db_now();
		}

		# Insert text information
		db_param_push();
		// HBT Cnsulta original
		/*$t_query = 'INSERT INTO {bug_text}
					    ( description, steps_to_reproduce, additional_information )
					  VALUES
					    ( ' . db_param() . ',' . db_param() . ',' . db_param() . ')';
		db_query( $t_query, array( $this->description, $this->steps_to_reproduce, $this->additional_information ) );*/
		// HBT En esta consulta agregar la variable impact_analysis y esto implica agregar un nuevo parámetro de entrada en
		// VALUES db_param() y en db_query agregar $this->impact_analysis
		$t_query = 'INSERT INTO {bug_text}
					    ( description, steps_to_reproduce, additional_information,impact_analysis  )
					  VALUES
					    ( ' . db_param() . ',' . db_param() . ',' . db_param() . ',' . db_param() . ')';
		db_query( $t_query, array( $this->description, $this->steps_to_reproduce, $this->additional_information, $this->impact_analysis  ) );

		# Get the id of the text information we just inserted
		# NOTE: this is guaranteed to be the correct one.
		# The value LAST_INSERT_ID is stored on a per connection basis.

		$t_text_id = db_insert_id( db_get_table( 'bug_text' ) );

		# check to see if we want to assign this right off
		$t_original_status = $this->status;

		# if not assigned, check if it should auto-assigned.
		if( 0 == $this->handler_id ) {
			# if a default user is associated with the category and we know at this point
			# that that the bug was not assigned to somebody, then assign it automatically.
			db_param_push();
			$t_query = 'SELECT user_id FROM {category} WHERE id=' . db_param();
			$t_result = db_query( $t_query, array( $this->category_id ) );
			$t_handler = db_result( $t_result );

			if( $t_handler !== false && user_exists( $t_handler ) ) {
				$this->handler_id = $t_handler;
			}
		}

		# Check if bug was pre-assigned or auto-assigned.
		$t_status = bug_get_status_for_assign( NO_USER, $this->handler_id, $this->status);

		# Insert the rest of the data
		db_param_push();
		$t_query = 'INSERT INTO {bug}
					    ( project_id,reporter_id, handler_id,duplicate_id,
					      priority,severity, reproducibility,status,
					      resolution,projection, category_id,date_submitted,
					      last_updated,eta, bug_text_id,
					      os, os_build,platform, version,build,
					      profile_id, summary, view_state, sponsorship_total, sticky, fixed_in_version,
					      target_version, due_date
					    )
					  VALUES
					    ( ' . db_param() . ',' . db_param() . ',' . db_param() . ',' . db_param() . ',
					      ' . db_param() . ',' . db_param() . ',' . db_param() . ',' . db_param() . ',
					      ' . db_param() . ',' . db_param() . ',' . db_param() . ',' . db_param() . ',
					      ' . db_param() . ',' . db_param() . ',' . db_param() . ',' . db_param() . ',
					      ' . db_param() . ',' . db_param() . ',' . db_param() . ',' . db_param() . ',
					      ' . db_param() . ',' . db_param() . ',' . db_param() . ',' . db_param() . ',
					      ' . db_param() . ',' . db_param() . ',' . db_param() . ',' . db_param() . ')';
		db_query( $t_query, array( $this->project_id, $this->reporter_id, $this->handler_id, $this->duplicate_id, $this->priority, $this->severity, $this->reproducibility, $t_status, $this->resolution, $this->projection, $this->category_id, $this->date_submitted, $this->last_updated, $this->eta, $t_text_id, $this->os, $this->os_build, $this->platform, $this->version, $this->build, $this->profile_id, $this->summary, $this->view_state, $this->sponsorship_total, $this->sticky, $this->fixed_in_version, $this->target_version, $this->due_date ) );

		$this->id = db_insert_id( db_get_table( 'bug' ) );

		# log new bug
		history_log_event_special( $this->id, NEW_BUG );

		# log changes, if any (compare happens in history_log_event_direct)
		history_log_event_direct( $this->id, 'status', $t_original_status, $t_status );
		history_log_event_direct( $this->id, 'handler_id', 0, $this->handler_id );

		return $this->id;
	}

	/**
	 * Process mentions in the current issue, for example, after the issue is created.
	 * @return void
	 * @access public
	 */
	function process_mentions() {
		# Now that the issue is added process the @ mentions
		$t_all_mentioned_user_ids = array();

		$t_mentioned_user_ids = mention_get_users( $this->summary );
		$t_all_mentioned_user_ids = array_merge( $t_all_mentioned_user_ids, $t_mentioned_user_ids );
		
		$t_mentioned_user_ids = mention_get_users( $this->description );
		$t_all_mentioned_user_ids = array_merge( $t_all_mentioned_user_ids, $t_mentioned_user_ids );

		if( !is_blank( $this->steps_to_reproduce ) ) {
			$t_mentioned_user_ids = mention_get_users( $this->steps_to_reproduce );
			$t_all_mentioned_user_ids = array_merge( $t_all_mentioned_user_ids, $t_mentioned_user_ids );
		}

		if( !is_blank( $this->additional_information ) ) {
			$t_mentioned_user_ids = mention_get_users( $this->additional_information );
			$t_all_mentioned_user_ids = array_merge( $t_all_mentioned_user_ids, $t_mentioned_user_ids );
		}

		$t_filtered_mentioned_user_ids = access_has_bug_level_filter(
			config_get( 'view_bug_threshold' ),
			$this->id,
			$t_all_mentioned_user_ids );

		$t_removed_mentions_user_ids = array_diff( $t_all_mentioned_user_ids, $t_filtered_mentioned_user_ids );

		if( !empty( $t_all_mentioned_user_ids ) ) {
			$t_mention_text = $this->description . "\n\n";

			if( !is_blank( $this->steps_to_reproduce ) ) {
				$t_mention_text .= lang_get( 'email_steps_to_reproduce' ) . "\n\n";
				$t_mention_text .= $this->steps_to_reproduce . "\n\n";
			}

			if( !is_blank( $this->additional_information ) ) {
				$t_mention_text .= lang_get( 'email_additional_information' ) . "\n\n";
				$t_mention_text .= $this->additional_information . "\n\n";
			}

			mention_process_user_mentions(
				$this->id,
				$t_filtered_mentioned_user_ids,
				$t_mention_text,
				$t_removed_mentions_user_ids );
		}
	}

	/**
     * Update a bug from the given data structure
     *  If the third parameter is true, also update the longer strings table
     * @param boolean $p_update_extended Whether to update extended fields.
     * @param boolean $p_bypass_mail     Whether to bypass sending email notifications.
     * @internal param boolean $p_bypass_email Default false, set to true to avoid generating emails (if sending elsewhere)
     * @return boolean (always true)
     * @access public
	 */
	function update( $p_update_extended = false, $p_bypass_mail = false ) {
		self::validate( $p_update_extended );

		$c_bug_id = $this->id;

		if( is_blank( $this->due_date ) ) {
			$this->due_date = date_get_null();
		}

		$t_old_data = bug_get( $this->id, true );

		# Update all fields
		# Ignore date_submitted and last_updated since they are pulled out
		#  as unix timestamps which could confuse the history log and they
		#  shouldn't get updated like this anyway.  If you really need to change
		#  them use bug_set_field()
		db_param_push();
		$t_query = 'UPDATE {bug}
					SET project_id=' . db_param() . ', reporter_id=' . db_param() . ',
						handler_id=' . db_param() . ', duplicate_id=' . db_param() . ',
						priority=' . db_param() . ', severity=' . db_param() . ',
						reproducibility=' . db_param() . ', status=' . db_param() . ',
						resolution=' . db_param() . ', projection=' . db_param() . ',
						category_id=' . db_param() . ', eta=' . db_param() . ',
						os=' . db_param() . ', os_build=' . db_param() . ',
						platform=' . db_param() . ', version=' . db_param() . ',
						build=' . db_param() . ', fixed_in_version=' . db_param() . ',';

		$t_fields = array(
			$this->project_id, $this->reporter_id,
			$this->handler_id, $this->duplicate_id,
			$this->priority, $this->severity,
			$this->reproducibility, $this->status,
			$this->resolution, $this->projection,
			$this->category_id, $this->eta,
			$this->os, $this->os_build,
			$this->platform, $this->version,
			$this->build, $this->fixed_in_version,
		);
		$t_roadmap_updated = false;
		if( access_has_project_level( config_get( 'roadmap_update_threshold' ) ) ) {
			$t_query .= '
						target_version=' . db_param() . ',';
			$t_fields[] = $this->target_version;
			$t_roadmap_updated = true;
		}

		$t_query .= '
						view_state=' . db_param() . ',
						summary=' . db_param() . ',
						sponsorship_total=' . db_param() . ',
						sticky=' . db_param() . ',
						due_date=' . db_param() . '
					WHERE id=' . db_param();
		$t_fields[] = $this->view_state;
		$t_fields[] = $this->summary;
		$t_fields[] = $this->sponsorship_total;
		$t_fields[] = (bool)$this->sticky;
		$t_fields[] = $this->due_date;
		$t_fields[] = $this->id;

		db_query( $t_query, $t_fields );

		bug_clear_cache( $this->id );

		# log changes
		history_log_event_direct( $c_bug_id, 'project_id', $t_old_data->project_id, $this->project_id );
		history_log_event_direct( $c_bug_id, 'reporter_id', $t_old_data->reporter_id, $this->reporter_id );
		history_log_event_direct( $c_bug_id, 'handler_id', $t_old_data->handler_id, $this->handler_id );
		history_log_event_direct( $c_bug_id, 'priority', $t_old_data->priority, $this->priority );
		history_log_event_direct( $c_bug_id, 'severity', $t_old_data->severity, $this->severity );
		history_log_event_direct( $c_bug_id, 'reproducibility', $t_old_data->reproducibility, $this->reproducibility );
		history_log_event_direct( $c_bug_id, 'status', $t_old_data->status, $this->status );
		history_log_event_direct( $c_bug_id, 'resolution', $t_old_data->resolution, $this->resolution );
		history_log_event_direct( $c_bug_id, 'projection', $t_old_data->projection, $this->projection );
		history_log_event_direct( $c_bug_id, 'category', category_full_name( $t_old_data->category_id, false ), category_full_name( $this->category_id, false ) );
		history_log_event_direct( $c_bug_id, 'eta', $t_old_data->eta, $this->eta );
		history_log_event_direct( $c_bug_id, 'os', $t_old_data->os, $this->os );
		history_log_event_direct( $c_bug_id, 'os_build', $t_old_data->os_build, $this->os_build );
		history_log_event_direct( $c_bug_id, 'platform', $t_old_data->platform, $this->platform );
		history_log_event_direct( $c_bug_id, 'version', $t_old_data->version, $this->version );
		history_log_event_direct( $c_bug_id, 'build', $t_old_data->build, $this->build );
		history_log_event_direct( $c_bug_id, 'fixed_in_version', $t_old_data->fixed_in_version, $this->fixed_in_version );
		if( $t_roadmap_updated ) {
			history_log_event_direct( $c_bug_id, 'target_version', $t_old_data->target_version, $this->target_version );
		}
		history_log_event_direct( $c_bug_id, 'view_state', $t_old_data->view_state, $this->view_state );
		history_log_event_direct( $c_bug_id, 'summary', $t_old_data->summary, $this->summary );
		history_log_event_direct( $c_bug_id, 'sponsorship_total', $t_old_data->sponsorship_total, $this->sponsorship_total );
		history_log_event_direct( $c_bug_id, 'sticky', $t_old_data->sticky, $this->sticky );

		history_log_event_direct( $c_bug_id, 'due_date',
			( $t_old_data->due_date != date_get_null() ) ? $t_old_data->due_date : null,
			( $this->due_date != date_get_null() ) ? $this->due_date : null
		);

		# Update extended info if requested
		if( $p_update_extended ) {
			$t_bug_text_id = bug_get_field( $c_bug_id, 'bug_text_id' );

			// HBT Se agrega la columan impact_analysis=" . db_param() . "  y en db_query $this->additional_information,
			db_param_push();
			$t_query = 'UPDATE {bug_text}
							SET description=' . db_param() . ',
								steps_to_reproduce=' . db_param() . ',
								additional_information=' . db_param() . ',
								impact_analysis=" . db_param() . " 
							WHERE id=' . db_param();
			db_query( $t_query, array(
				$this->description,
				$this->steps_to_reproduce,
				$this->additional_information,
				$this->impact_analysis,
				$t_bug_text_id ) );

				// HBT consulta original
				// $t_query = 'UPDATE {bug_text}
				// SET description=' . db_param() . ',
				// 	steps_to_reproduce=' . db_param() . ',
				// 	additional_information=' . db_param() . '
				// WHERE id=' . db_param();
				// db_query( $t_query, array(
				// 	$this->description,
				// 	$this->steps_to_reproduce,
				// 	$this->additional_information,
				// 	$t_bug_text_id ) );

			bug_text_clear_cache( $c_bug_id );

			$t_current_user = auth_get_current_user_id();

			if( $t_old_data->description != $this->description ) {
				if( bug_revision_count( $c_bug_id, REV_DESCRIPTION ) < 1 ) {
					bug_revision_add( $c_bug_id, $t_old_data->reporter_id, REV_DESCRIPTION, $t_old_data->description, 0, $t_old_data->date_submitted );
				}
				$t_revision_id = bug_revision_add( $c_bug_id, $t_current_user, REV_DESCRIPTION, $this->description );
				history_log_event_special( $c_bug_id, DESCRIPTION_UPDATED, $t_revision_id );
			}

			# HBT impact_analysis
			if( $t_old_data->impact_analysis != $this->impact_analysis ) {
				if ( bug_revision_count( $c_bug_id, REV_IMPACT_ANALYSIS ) < 1 ) {
					$t_revision_id = bug_revision_add( $c_bug_id, $t_current_user, REV_IMPACT_ANALYSIS, $t_old_data->impact_analysis, 0, $t_old_data->date_submitted );
				}
				$t_revision_id = bug_revision_add( $c_bug_id, $t_current_user, REV_IMPACT_ANALYSIS, $this->impact_analysis );
				history_log_event_special( $c_bug_id, IMPACT_ANALYSIS, $t_revision_id );
			} // FIN HBT

			if( $t_old_data->steps_to_reproduce != $this->steps_to_reproduce ) {
				if( bug_revision_count( $c_bug_id, REV_STEPS_TO_REPRODUCE ) < 1 ) {
					bug_revision_add( $c_bug_id, $t_old_data->reporter_id, REV_STEPS_TO_REPRODUCE, $t_old_data->steps_to_reproduce, 0, $t_old_data->date_submitted );
				}
				$t_revision_id = bug_revision_add( $c_bug_id, $t_current_user, REV_STEPS_TO_REPRODUCE, $this->steps_to_reproduce );
				history_log_event_special( $c_bug_id, STEP_TO_REPRODUCE_UPDATED, $t_revision_id );
			}

			if( $t_old_data->additional_information != $this->additional_information ) {
				if( bug_revision_count( $c_bug_id, REV_ADDITIONAL_INFO ) < 1 ) {
					bug_revision_add( $c_bug_id, $t_old_data->reporter_id, REV_ADDITIONAL_INFO, $t_old_data->additional_information, 0, $t_old_data->date_submitted );
				}
				$t_revision_id = bug_revision_add( $c_bug_id, $t_current_user, REV_ADDITIONAL_INFO, $this->additional_information );
				history_log_event_special( $c_bug_id, ADDITIONAL_INFO_UPDATED, $t_revision_id );
			}
		}

		# Update the last update date
		bug_update_date( $c_bug_id );

		# allow bypass if user is sending mail separately
		if( false == $p_bypass_mail ) {
			# If handler changes, send out owner change email
			if( $t_old_data->handler_id != $this->handler_id ) {
				//HBT  Se cambia por la incovacion de email_generic
				// La cual esta configurada para enviar los correos con el servidor de HBT
				$resultado = email_generic( $c_bug_id, 'owner', 'email_notification_title_for_action_bug_assigned' );
				return $resultado;
				//Se comenta HBT
				// email_owner_changed( $c_bug_id, $t_old_data->handler_id, $this->handler_id );
				// return true;
			} 

			# status changed
			if( $t_old_data->status != $this->status ) {
				$t_status = MantisEnum::getLabel( config_get( 'status_enum_string' ), $this->status );
				$t_status = str_replace( ' ', '_', $t_status );
				//HBT  Se cambia por la incovacion de email_generic
				// La cual esta configurada para enviar los correos con el servidor de HBT
				$resultado = email_generic( $c_bug_id, $t_status, 'email_notification_title_for_status_bug_' . $t_status );
				return $resultado;
				//Se comenta HBT
				// email_bug_status_changed( $c_bug_id, $t_status );
				// return true;
			}

			# @todo handle priority change if it requires special handling
			# generic update notification
			//HBT  Se cambia por la incovacion de email_generic
			// La cual esta configurada para enviar los correos con el servidor de HBT
			$resultado = email_generic( $c_bug_id, 'updated', 'email_notification_title_for_action_bug_updated' );
		
			return $resultado; 
			// HBT Se comenta 
			//email_bug_updated( $c_bug_id );
		}

		return true;
	}
}

$g_cache_bug = array();
$g_cache_bug_text = array();

/**
 * Cache a database result-set containing full contents of bug_table row.
 * $p_stats parameter is an optional array representing bugnote statistics.
 * This parameter can be "false" if the bug has no bugnotes, so the cache can differentiate
 * from a still not cached stats registry.
 * @param array $p_bug_database_result  Database row containing all columns from mantis_bug_table.
 * @param array|boolean|null $p_stats   Optional: array representing bugnote statistics, or false to store empty cache value
 * @return array returns an array representing the bug row if bug exists
 * @access public
 */
function bug_cache_database_result( array $p_bug_database_result, $p_stats = null ) {
	global $g_cache_bug;

	if( !is_array( $p_bug_database_result ) || isset( $g_cache_bug[(int)$p_bug_database_result['id']] ) ) {
		if( !is_null($p_stats) ) {
			# force store the bugnote statistics
			return bug_add_to_cache( $p_bug_database_result, $p_stats );
		} else {
			return $g_cache_bug[(int)$p_bug_database_result['id']];
		}
	}

	return bug_add_to_cache( $p_bug_database_result, $p_stats );
}

/**
 * Cache a bug row if necessary and return the cached copy
 * @param integer $p_bug_id         Identifier of bug to cache from mantis_bug_table.
 * @param boolean $p_trigger_errors Set to true to trigger an error if the bug does not exist.
 * @return boolean|array returns an array representing the bug row if bug exists or false if bug does not exist
 * @access public
 * @uses database_api.php
 */
function bug_cache_row( $p_bug_id, $p_trigger_errors = true ) {
	global $g_cache_bug;

	if( isset( $g_cache_bug[$p_bug_id] ) ) {
		return $g_cache_bug[$p_bug_id];
	}

	$c_bug_id = (int)$p_bug_id;

	db_param_push();
	$t_query = 'SELECT * FROM {bug} WHERE id=' . db_param();
	$t_result = db_query( $t_query, array( $c_bug_id ) );

	$t_row = db_fetch_array( $t_result );

	if( !$t_row ) {
		$g_cache_bug[$c_bug_id] = false;

		if( $p_trigger_errors ) {
			throw new ClientException( "Issue #$c_bug_id not found", ERROR_BUG_NOT_FOUND, array( $p_bug_id ) );
		}

		return false;
	}

	return bug_add_to_cache( $t_row );
}

/**
 * Cache a set of bugs
 * @param array $p_bug_id_array Integer array representing bug identifiers to cache.
 * @return void
 * @access public
 * @uses database_api.php
 */
function bug_cache_array_rows( array $p_bug_id_array ) {
	global $g_cache_bug;
	$c_bug_id_array = array();

	foreach( $p_bug_id_array as $t_bug_id ) {
		if( !isset( $g_cache_bug[(int)$t_bug_id] ) ) {
			$c_bug_id_array[] = (int)$t_bug_id;
		}
	}

	if( empty( $c_bug_id_array ) ) {
		return;
	}

	$t_query = 'SELECT * FROM {bug} WHERE id IN (' . implode( ',', $c_bug_id_array ) . ')';
	$t_result = db_query( $t_query );

	while( $t_row = db_fetch_array( $t_result ) ) {
		bug_add_to_cache( $t_row );
	}
	return;
}

/**
 * Inject a bug into the bug cache.
 * $p_stats parameter is an optional array representing bugnote statistics.
 * This parameter can be "false" if the bug has no bugnotes, so the cache can differentiate
 * from a still not cached stats registry.
 * @param array $p_bug_row A bug row to cache.
 * @param array|boolean|null $p_stats   Array of Bugnote stats to cache, false to store empty value, null to skip
 * @return array
 * @access private
 */
function bug_add_to_cache( array $p_bug_row, $p_stats = null ) {
	global $g_cache_bug;

	$g_cache_bug[(int)$p_bug_row['id']] = $p_bug_row;

	if( !is_null( $p_stats ) ) {
		$g_cache_bug[(int)$p_bug_row['id']]['_stats'] = $p_stats;
	}

	return $g_cache_bug[(int)$p_bug_row['id']];
}

/**
 * Clear a bug from the cache or all bugs if no bug id specified.
 * @param integer $p_bug_id A bug identifier to clear (optional).
 * @return boolean
 * @access public
 */
function bug_clear_cache( $p_bug_id = null ) {
	global $g_cache_bug;

	if( null === $p_bug_id ) {
		$g_cache_bug = array();
	} else {
		unset( $g_cache_bug[(int)$p_bug_id] );
	}

	return true;
}

/**
 * Cache a bug text row if necessary and return the cached copy
 * @param integer $p_bug_id         Integer bug id to retrieve text for.
 * @param boolean $p_trigger_errors If the second parameter is true (default), trigger an error if bug text not found.
 * @return boolean|array returns false if not bug text found or array of bug text
 * @access public
 * @uses database_api.php
 */
function bug_text_cache_row( $p_bug_id, $p_trigger_errors = true ) {
	global $g_cache_bug_text;

	$c_bug_id = (int)$p_bug_id;

	if( isset( $g_cache_bug_text[$c_bug_id] ) ) {
		return $g_cache_bug_text[$c_bug_id];
	}

	db_param_push();
	$t_query = 'SELECT bt.* FROM {bug_text} bt, {bug} b
				  WHERE b.id=' . db_param() . ' AND b.bug_text_id = bt.id';
	$t_result = db_query( $t_query, array( $c_bug_id ) );

	$t_row = db_fetch_array( $t_result );

	if( !$t_row ) {
		$g_cache_bug_text[$c_bug_id] = false;

		if( $p_trigger_errors ) {
			throw new ClientException(
				"Issue '$p_bug_id' not found",
				ERROR_BUG_NOT_FOUND,
				array( $p_bug_id ) );
		}

		return false;
	}

	$g_cache_bug_text[$c_bug_id] = $t_row;

	return $t_row;
}

/**
 * Clear a bug's bug text from the cache or all bug text if no bug id specified.
 * @param integer $p_bug_id A bug identifier to clear (optional).
 * @return boolean
 * @access public
 */
function bug_text_clear_cache( $p_bug_id = null ) {
	global $g_cache_bug_text;

	if( null === $p_bug_id ) {
		$g_cache_bug_text = array();
	} else {
		unset( $g_cache_bug_text[(int)$p_bug_id] );
	}

	return true;
}

/**
 * Check if a bug exists
 * @param integer $p_bug_id Integer representing bug identifier.
 * @return boolean true if bug exists, false otherwise
 * @access public
 */
function bug_exists( $p_bug_id ) {
	$c_bug_id = (int)$p_bug_id;

	# Check for invalid id values
	if( $c_bug_id <= 0 || $c_bug_id > DB_MAX_INT ) {
		return false;
	}

	# bug exists if bug_cache_row returns any value
	if( bug_cache_row( $c_bug_id, false ) ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Check if a bug exists. If it doesn't then trigger an error
 * @param integer $p_bug_id Integer representing bug identifier.
 * @return void
 * @access public
 */
function bug_ensure_exists( $p_bug_id ) {
	if( !bug_exists( $p_bug_id ) ) {
		throw new ClientException(
			"Issue #$p_bug_id not found",
			ERROR_BUG_NOT_FOUND,
			array( $p_bug_id ) );
	}
}

/**
 * check if the given user is the reporter of the bug
 * @param integer $p_bug_id  Integer representing bug identifier.
 * @param integer $p_user_id Integer representing a user identifier.
 * @return boolean return true if the user is the reporter, false otherwise
 * @access public
 */
function bug_is_user_reporter( $p_bug_id, $p_user_id ) {
	if( bug_get_field( $p_bug_id, 'reporter_id' ) == $p_user_id ) {
		return true;
	} else {
		return false;
	}
}

/**
 * check if the given user is the handler of the bug
 * @param integer $p_bug_id  Integer representing bug identifier.
 * @param integer $p_user_id Integer representing a user identifier.
 * @return boolean return true if the user is the handler, false otherwise
 * @access public
 */
function bug_is_user_handler( $p_bug_id, $p_user_id ) {
	if( bug_get_field( $p_bug_id, 'handler_id' ) == $p_user_id ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Check if the bug is readonly and shouldn't be modified
 * For a bug to be readonly the status has to be >= bug_readonly_status_threshold and
 * current user access level < update_readonly_bug_threshold.
 * @param integer $p_bug_id Integer representing bug identifier.
 * @return boolean
 * @access public
 * @uses access_api.php
 * @uses config_api.php
 */
function bug_is_readonly( $p_bug_id ) {
	$t_status = bug_get_field( $p_bug_id, 'status' );
	if( $t_status < config_get( 'bug_readonly_status_threshold', null, null, bug_get_field( $p_bug_id, 'project_id' ) ) ) {
		return false;
	}

	if( access_has_bug_level( config_get( 'update_readonly_bug_threshold' ), $p_bug_id ) ) {
		return false;
	}

	return true;
}

/**
 * Check if a given bug is resolved
 * @param integer $p_bug_id Integer representing bug identifier.
 * @return boolean true if bug is resolved, false otherwise
 * @access public
 * @uses config_api.php
 */
function bug_is_resolved( $p_bug_id ) {
	$t_bug = bug_get( $p_bug_id );
	return( $t_bug->status >= config_get( 'bug_resolved_status_threshold', null, null, $t_bug->project_id ) );
}

/**
 * Check if a given bug is closed
 * @param integer $p_bug_id Integer representing bug identifier.
 * @return boolean true if bug is closed, false otherwise
 * @access public
 * @uses config_api.php
 */
function bug_is_closed( $p_bug_id ) {
	$t_bug = bug_get( $p_bug_id );
	return( $t_bug->status >= config_get( 'bug_closed_status_threshold', null, null, $t_bug->project_id ) );
}

/**
 * Return a bug's overdue warning level.
 * Determines the level based on the difference between the bug's due date
 * and the current date/time, based on the defined delays
 * @see $g_due_date_warning_levels
 *
 * @param $p_bug_id
 *
 * @return int|false Warning level (0 = overdue), false if N/A.
 */
function bug_overdue_level( $p_bug_id ) {
	if( bug_is_resolved( $p_bug_id ) ) {
		return false;
	}

	$t_bug = bug_get( $p_bug_id );
	$t_due_date = $t_bug->due_date;

	if( date_is_null( $t_due_date ) ) {
		return false;
	}

	$t_warning_levels = config_get( 'due_date_warning_levels', null, null, $t_bug->project_id );
	if( !empty( $t_warning_levels ) && !is_array( $t_warning_levels ) ) {
		trigger_error( ERROR_GENERIC );
	}

	$t_now = db_now();
	foreach( $t_warning_levels as $t_level => $t_delay ) {
		if( $t_now > $t_due_date - $t_delay ) {
			return $t_level;
		}
	}
	return false;
}

/**
 * Check if a given bug is overdue
 * @param integer $p_bug_id Integer representing bug identifier.
 * @return boolean true if bug is overdue, false otherwise
 * @access public
 * @uses database_api.php
 */
function bug_is_overdue( $p_bug_id ) {
	return bug_overdue_level( $p_bug_id ) === 0;
}

/**
 * Validate workflow state to see if bug can be moved to requested state
 * @param integer $p_bug_status    Current bug status.
 * @param integer $p_wanted_status New bug status.
 * @return boolean
 * @access public
 * @uses config_api.php
 * @uses utility_api.php
 */
function bug_check_workflow( $p_bug_status, $p_wanted_status ) {
	$t_status_enum_workflow = config_get( 'status_enum_workflow' );

	if( count( $t_status_enum_workflow ) < 1 ) {
		# workflow not defined, use default enum
		return true;
	}

	if( $p_bug_status == $p_wanted_status ) {
		# no change in state, allow the transition
		return true;
	}

	# There should always be a possible next status, if not defined, then allow all.
	if( !isset( $t_status_enum_workflow[$p_bug_status] ) ) {
		return true;
	}

	# workflow defined - find allowed states
	$t_allowed_states = $t_status_enum_workflow[$p_bug_status];

	return MantisEnum::hasValue( $t_allowed_states, $p_wanted_status );
}

/**
 * Copy a bug from one project to another. Also make copies of issue notes, attachments, history,
 * email notifications etc.
 * @param integer $p_bug_id                A bug identifier.
 * @param integer $p_target_project_id     A target project identifier.
 * @param boolean $p_copy_custom_fields    Whether to copy custom fields.
 * @param boolean $p_copy_relationships    Whether to copy relationships.
 * @param boolean $p_copy_history          Whether to copy history.
 * @param boolean $p_copy_attachments      Whether to copy attachments.
 * @param boolean $p_copy_bugnotes         Whether to copy bugnotes.
 * @param boolean $p_copy_monitoring_users Whether to copy monitoring users.
 * @return integer representing the new bug identifier
 * @access public
 */
function bug_copy( $p_bug_id, $p_target_project_id = null, $p_copy_custom_fields = false, $p_copy_relationships = false, $p_copy_history = false, $p_copy_attachments = false, $p_copy_bugnotes = false, $p_copy_monitoring_users = false ) {

	$t_bug_id = (int)$p_bug_id;
	$t_target_project_id = (int)$p_target_project_id;

	$t_bug_data = bug_get( $t_bug_id, true );

	# retrieve the project id associated with the bug
	if( ( $p_target_project_id == null ) || is_blank( $p_target_project_id ) ) {
		$t_target_project_id = $t_bug_data->project_id;
	}

	$t_bug_data->project_id = $t_target_project_id;
	$t_bug_data->reporter_id = auth_get_current_user_id();
	$t_bug_data->date_submitted = db_now();
	$t_bug_data->last_updated = db_now();

	$t_new_bug_id = $t_bug_data->create();

	# MASC ATTENTION: IF THE SOURCE BUG HAS TO HANDLER THE bug_create FUNCTION CAN TRY TO AUTO-ASSIGN THE BUG
	# WE FORCE HERE TO DUPLICATE THE SAME HANDLER OF THE SOURCE BUG
	# @todo VB: Shouldn't we check if the handler in the source project is also a handler in the destination project?
	bug_set_field( $t_new_bug_id, 'handler_id', $t_bug_data->handler_id );

	bug_set_field( $t_new_bug_id, 'duplicate_id', $t_bug_data->duplicate_id );
	bug_set_field( $t_new_bug_id, 'status', $t_bug_data->status );
	bug_set_field( $t_new_bug_id, 'resolution', $t_bug_data->resolution );
	bug_set_field( $t_new_bug_id, 'projection', $t_bug_data->projection );
	bug_set_field( $t_new_bug_id, 'eta', $t_bug_data->eta );
	bug_set_field( $t_new_bug_id, 'fixed_in_version', $t_bug_data->fixed_in_version );
	bug_set_field( $t_new_bug_id, 'target_version', $t_bug_data->target_version );
	bug_set_field( $t_new_bug_id, 'sponsorship_total', 0 );
	bug_set_field( $t_new_bug_id, 'sticky', 0 );
	bug_set_field( $t_new_bug_id, 'due_date', $t_bug_data->due_date );

	# COPY CUSTOM FIELDS
	if( $p_copy_custom_fields ) {
		db_param_push();
		$t_query = 'SELECT field_id, bug_id, value, text FROM {custom_field_string} WHERE bug_id=' . db_param();
		$t_result = db_query( $t_query, array( $t_bug_id ) );

		while( $t_bug_custom = db_fetch_array( $t_result ) ) {
			$c_field_id = (int)$t_bug_custom['field_id'];
			$c_new_bug_id = (int)$t_new_bug_id;
			$c_value = $t_bug_custom['value'];
			$c_text = $t_bug_custom['text'];

			db_param_push();
			$t_query = 'INSERT INTO {custom_field_string}
						   ( field_id, bug_id, value, text )
						   VALUES (' . db_param() . ', ' . db_param() . ', ' . db_param() . ', ' . db_param() . ')';
			db_query( $t_query, array( $c_field_id, $c_new_bug_id, $c_value, $c_text ) );
		}
	}

	# Copy Relationships
	if( $p_copy_relationships ) {
		relationship_copy_all( $t_bug_id, $t_new_bug_id );
	}

	# Copy bugnotes
	if( $p_copy_bugnotes ) {
		db_param_push();
		$t_query = 'SELECT * FROM {bugnote} WHERE bug_id=' . db_param();
		$t_result = db_query( $t_query, array( $t_bug_id ) );

		while( $t_bug_note = db_fetch_array( $t_result ) ) {
			$t_bugnote_text_id = $t_bug_note['bugnote_text_id'];

			db_param_push();
			$t_query2 = 'SELECT * FROM {bugnote_text} WHERE id=' . db_param();
			$t_result2 = db_query( $t_query2, array( $t_bugnote_text_id ) );

			$t_bugnote_text_insert_id = -1;
			if( $t_bugnote_text = db_fetch_array( $t_result2 ) ) {
				db_param_push();
				$t_query2 = 'INSERT INTO {bugnote_text}
							   ( note )
							   VALUES ( ' . db_param() . ' )';
				db_query( $t_query2, array( $t_bugnote_text['note'] ) );
				$t_bugnote_text_insert_id = db_insert_id( db_get_table( 'bugnote_text' ) );
			}

			db_param_push();
			$t_query2 = 'INSERT INTO {bugnote}
						   ( bug_id, reporter_id, bugnote_text_id, view_state, date_submitted, last_modified )
						   VALUES ( ' . db_param() . ',
						   			' . db_param() . ',
						   			' . db_param() . ',
						   			' . db_param() . ',
						   			' . db_param() . ',
						   			' . db_param() . ')';
			db_query( $t_query2, array( $t_new_bug_id, $t_bug_note['reporter_id'], $t_bugnote_text_insert_id, $t_bug_note['view_state'], $t_bug_note['date_submitted'], $t_bug_note['last_modified'] ) );
		}
	}

	# Copy attachments
	if( $p_copy_attachments ) {
	    file_copy_attachments( $t_bug_id, $t_new_bug_id );
	}

	# Copy users monitoring bug
	if( $p_copy_monitoring_users ) {
		bug_monitor_copy( $t_bug_id, $t_new_bug_id );
	}

	# COPY HISTORY
	history_delete( $t_new_bug_id );	# should history only be deleted inside the if statement below?
	if( $p_copy_history ) {
		# @todo problem with this code: the generated history trail is incorrect because the note IDs are those of the original bug, not the copied ones
		# @todo actually, does it even make sense to copy the history ?
		db_param_push();
		$t_query = 'SELECT * FROM {bug_history} WHERE bug_id = ' . db_param();
		$t_result = db_query( $t_query, array( $t_bug_id ) );

		while( $t_bug_history = db_fetch_array( $t_result ) ) {
			db_param_push();
			$t_query = 'INSERT INTO {bug_history}
						  ( user_id, bug_id, date_modified, field_name, old_value, new_value, type )
						  VALUES ( ' . db_param() . ',' . db_param() . ',' . db_param() . ',
						  		   ' . db_param() . ',' . db_param() . ',' . db_param() . ',
						  		   ' . db_param() . ' );';
			db_query( $t_query, array( $t_bug_history['user_id'], $t_new_bug_id, $t_bug_history['date_modified'], $t_bug_history['field_name'], $t_bug_history['old_value'], $t_bug_history['new_value'], $t_bug_history['type'] ) );
		}
	} else {
		# Create a "New Issue" history entry
		history_log_event_special( $t_new_bug_id, NEW_BUG );
	}

	# Create history entries to reflect the copy operation
	history_log_event_special( $t_new_bug_id, BUG_CREATED_FROM, '', $t_bug_id );
	history_log_event_special( $t_bug_id, BUG_CLONED_TO, '', $t_new_bug_id );

	return $t_new_bug_id;
}

/**
 * Moves an issue from a project to another.
 *
 * @todo Validate with sub-project / category inheritance scenarios.
 * @param integer $p_bug_id            The bug to be moved.
 * @param integer $p_target_project_id The target project to move the bug to.
 * @return void
 * @access public
 */
function bug_move( $p_bug_id, $p_target_project_id ) {
	# Attempt to move disk based attachments to new project file directory.
	file_move_bug_attachments( $p_bug_id, $p_target_project_id );

	# Move the issue to the new project.
	bug_set_field( $p_bug_id, 'project_id', $p_target_project_id );

	# Update the category if needed
	$t_category_id = bug_get_field( $p_bug_id, 'category_id' );

	# Bug has no category
	if( $t_category_id == 0 ) {
		# Category is required in target project, set it to default
		if( ON != config_get( 'allow_no_category', null, null, $p_target_project_id ) ) {
			bug_set_field( $p_bug_id, 'category_id', config_get( 'default_category_for_moves', null, null, $p_target_project_id ) );
		}
	} else {
		# Check if the category is global, and if not attempt mapping it to the new project
		$t_category_project_id = category_get_field( $t_category_id, 'project_id' );

		if( $t_category_project_id != ALL_PROJECTS
		  && !in_array( $t_category_project_id, project_hierarchy_inheritance( $p_target_project_id ) )
		) {
			# Map by name
			$t_category_name = category_get_field( $t_category_id, 'name' );
			$t_target_project_category_id = category_get_id_by_name( $t_category_name, $p_target_project_id, false );
			if( $t_target_project_category_id === false ) {
				# Use target project's default category for moves, since there is no match by name.
				$t_target_project_category_id = config_get( 'default_category_for_moves', null, null, $p_target_project_id );
			}
			bug_set_field( $p_bug_id, 'category_id', $t_target_project_category_id );
		}
	}
}

/**
 * allows bug deletion :
 * delete the bug, bugtext, bugnote, and bugtexts selected
 * @param integer $p_bug_id Integer representing bug identifier.
 * @return void
 * @access public
 */
function bug_delete( $p_bug_id ) {
	$c_bug_id = (int)$p_bug_id;

	# call pre-deletion custom function
	helper_call_custom_function( 'issue_delete_validate', array( $p_bug_id ) );

	event_signal( 'EVENT_BUG_DELETED', array( $c_bug_id ) );

	# log deletion of bug
	history_log_event_special( $p_bug_id, BUG_DELETED, bug_format_id( $p_bug_id ) );

	//HBT Se declara la variable $resultado para saber si el correo fue enviado con exito
	//hubo inconvenientes al momento de enviarlo. 
	$resultado =email_bug_deleted( $p_bug_id ); /* HBT Se alamacena el resultado */ 
	email_relationship_bug_deleted( $p_bug_id );

	# call post-deletion custom function.  We call this here to allow the custom function to access the details of the bug before
	# they are deleted from the database given it's id.  The other option would be to move this to the end of the function and
	# provide it with bug data rather than an id, but this will break backward compatibility.
	helper_call_custom_function( 'issue_delete_notify', array( $p_bug_id ) );

	# Unmonitor bug for all users
	bug_unmonitor( $p_bug_id, null );

	# Delete custom fields
	custom_field_delete_all_values( $p_bug_id );

	# Delete bugnotes
	bugnote_delete_all( $p_bug_id );

	# Delete all sponsorships
	sponsorship_delete_all( $p_bug_id );

	# Delete all relationships
	relationship_delete_all( $p_bug_id );

	# Delete files
	file_delete_attachments( $p_bug_id );

	# Detach tags
	tag_bug_detach_all( $p_bug_id, false );

	# Delete the bug history
	history_delete( $p_bug_id );

	# Delete bug info revisions
	bug_revision_delete( $p_bug_id );

	# Delete the bugnote text
	$t_bug_text_id = bug_get_field( $p_bug_id, 'bug_text_id' );

	db_param_push();
	$t_query = 'DELETE FROM {bug_text} WHERE id=' . db_param();
	db_query( $t_query, array( $t_bug_text_id ) );

	# Delete the bug entry
	db_param_push();
	$t_query = 'DELETE FROM {bug} WHERE id=' . db_param();
	db_query( $t_query, array( $c_bug_id ) );

	bug_clear_cache_all( $p_bug_id );
	return $resultado; // HBT Retornamos el resultado
}

/**
 * Delete all bugs associated with a project
 * @param integer $p_project_id Integer representing a project identifier.
 * @access public
 * @uses database_api.php
 * @return void
 */
function bug_delete_all( $p_project_id ) {
	$c_project_id = (int)$p_project_id;

	db_param_push();
	$t_query = 'SELECT id FROM {bug} WHERE project_id=' . db_param();
	$t_result = db_query( $t_query, array( $c_project_id ) );

	while( $t_row = db_fetch_array( $t_result ) ) {
		bug_delete( $t_row['id'] );
	}

	# @todo should we check the return value of each bug_delete() and
	#  return false if any of them return false? Presumable bug_delete()
	#  will eventually trigger an error on failure so it won't matter...
}

/**
 * Returns the extended record of the specified bug, this includes
 * the bug text fields
 * @todo include reporter name and handler name, the problem is that
 *      handler can be 0, in this case no corresponding name will be
 *      found.  Use equivalent of (+) in Oracle.
 * @param integer $p_bug_id Integer representing bug identifier.
 * @return array
 * @access public
 */
function bug_get_extended_row( $p_bug_id ) {
	$t_base = bug_cache_row( $p_bug_id );
	$t_text = bug_text_cache_row( $p_bug_id );

	# merge $t_text first so that the 'id' key has the bug id not the bug text id
	return array_merge( $t_text, $t_base );
}

/**
 * Returns the record of the specified bug
 * @param integer $p_bug_id Integer representing bug identifier.
 * @return array
 * @access public
 */
function bug_get_row( $p_bug_id ) {
	return bug_cache_row( $p_bug_id );
}

/**
 * Returns an object representing the specified bug
 * @param integer $p_bug_id       Integer representing bug identifier.
 * @param boolean $p_get_extended Whether to include extended information (including bug_text).
 * @return BugData BugData Object
 * @access public
 */
function bug_get( $p_bug_id, $p_get_extended = false ) {
	if( $p_get_extended ) {
		$t_row = bug_get_extended_row( $p_bug_id );
	} else {
		$t_row = bug_get_row( $p_bug_id );
	}

	$t_bug_data = new BugData;
	$t_bug_data->loadrow( $t_row );
	return $t_bug_data;
}

/**
 * Convert row [from database] to bug object
 * @param array $p_row Bug database row.
 * @return BugData
 */
function bug_row_to_object( array $p_row ) {
	$t_bug_data = new BugData;
	$t_bug_data->loadrow( $p_row );
	return $t_bug_data;
}

/**
 * return the specified field of the given bug
 *  if the field does not exist, display a warning and return ''
 * @param integer $p_bug_id     Integer representing bug identifier.
 * @param string  $p_field_name Field name to retrieve.
 * @return string
 * @access public
 */
function bug_get_field( $p_bug_id, $p_field_name ) {
	$t_row = bug_get_row( $p_bug_id );

	if( isset( $t_row[$p_field_name] ) ) {
		return $t_row[$p_field_name];
	} else {
		error_parameters( $p_field_name );
		trigger_error( ERROR_DB_FIELD_NOT_FOUND, WARNING );
		return '';
	}
}

/**
 * return the specified text field of the given bug
 *  if the field does not exist, display a warning and return ''
 * @param integer $p_bug_id     Integer representing bug identifier.
 * @param string  $p_field_name Field name to retrieve.
 * @return string
 * @access public
 */
function bug_get_text_field( $p_bug_id, $p_field_name ) {
	$t_row = bug_text_cache_row( $p_bug_id );

	if( isset( $t_row[$p_field_name] ) ) {
		return $t_row[$p_field_name];
	} else {
		error_parameters( $p_field_name );
		trigger_error( ERROR_DB_FIELD_NOT_FOUND, WARNING );
		return '';
	}
}

/**
 * return the bug summary
 *  this is a wrapper for the custom function
 * @param integer $p_bug_id  Integer representing bug identifier.
 * @param integer $p_context Representing SUMMARY_CAPTION, SUMMARY_FIELD.
 * @return string
 * @access public
 * @uses helper_api.php
 */
function bug_format_summary( $p_bug_id, $p_context ) {
	return helper_call_custom_function( 'format_issue_summary', array( $p_bug_id, $p_context ) );
}

/**
 * return the timestamp for the most recent time at which a bugnote
 *  associated with the bug was modified
 * @param integer $p_bug_id Integer representing bug identifier.
 * @return boolean|integer false or timestamp in integer format representing newest bugnote timestamp
 * @access public
 * @uses database_api.php
 */
function bug_get_newest_bugnote_timestamp( $p_bug_id ) {
	$c_bug_id = (int)$p_bug_id;

	db_param_push();
	$t_query = 'SELECT last_modified FROM {bugnote} WHERE bug_id=' . db_param() . ' ORDER BY last_modified DESC';
	$t_result = db_query( $t_query, array( $c_bug_id ), 1 );
	$t_row = db_result( $t_result );

	if( false === $t_row ) {
		return false;
	} else {
		return $t_row;
	}
}

/**
 * For a list of bug ids, returns an array of bugnote stats.
 * If a bug has no visible bugnotes, returns "false" as the stats item for that bug id.
 * @param array $p_bugs_id         Array of Integer representing bug identifiers.
 * @param integer|null $p_user_id  User for checking access levels. null defaults to current user
 * @return array                   Array of bugnote stats
 * @access public
 * @uses database_api.php
 */
function bug_get_bugnote_stats_array( array $p_bugs_id, $p_user_id = null ) {
	if( empty( $p_bugs_id ) ) {
		return array();
	}

	$t_id_array = array();
	foreach( $p_bugs_id as $t_id ) {
		$t_id_array[$t_id] = (int)$t_id;
	}
	if( db_is_mssql() ) {
		# MSSQL is limited to 2100 parameters per query, see #24393
		$t_chunks = array_chunk( $t_id_array, 2100, true );
	} else {
		$t_chunks = array( $t_id_array );
	}

	if ( null === $p_user_id ) {
		$t_user_id = auth_get_current_user_id();
	}
	else {
		$t_user_id = $p_user_id;
	}

	# We need to check for each bugnote if user has permissions to view in respective project.
	# bugnotes are grouped by project_id and bug_id to save calls to config_get
	$t_sql = 'SELECT n.id, n.bug_id, n.reporter_id, n.view_state, n.last_modified, n.date_submitted, b.project_id'
		. ' FROM {bugnote} n JOIN {bug} b ON (n.bug_id = b.id)'
		. ' WHERE %s'
		. ' ORDER BY b.project_id, n.bug_id, n.last_modified';
	$t_query = new DbQuery();
	$t_query->sql( sprintf( $t_sql, $t_query->sql_in( 'n.bug_id', 'bug_ids' ) ) );

	$t_counter = 0;
	$t_stats = array();
	foreach( $t_chunks as $t_chunk_ids ) {
		$t_current_project_id = null;
		$t_current_bug_id = null;

		$t_query->bind( 'bug_ids', $t_chunk_ids );
		$t_query->execute();
		while( $t_query_row = $t_query->fetch() ) {
			/**
			 * Variables defined in the loop's first iteration
			 * @var bool $t_private_bugnote_visible
			 * @var int  $t_note_count
			 * @var int  $t_last_submit_date
			 */
			$c_bug_id = (int)$t_query_row['bug_id'];
			if( 0 == $t_counter || $t_current_project_id !== $t_query_row['project_id'] ) {
				# evaluating a new project from the rowset
				$t_current_project_id = $t_query_row['project_id'];
				$t_user_access_level = access_get_project_level( $t_query_row['project_id'], $t_user_id );
				$t_private_bugnote_visible = access_compare_level(
					$t_user_access_level,
					config_get( 'private_bugnote_threshold', null, $t_user_id, $t_query_row['project_id'] )
				);
			}
			if( 0 == $t_counter || $t_current_bug_id !== $c_bug_id ) {
				# evaluating a new bug from the rowset
				$t_current_bug_id = $c_bug_id;
				$t_note_count = 0;
				$t_last_submit_date = 0;
			}
			$t_note_visible = $t_private_bugnote_visible
				|| $t_query_row['reporter_id'] == $t_user_id
				|| ( VS_PUBLIC == $t_query_row['view_state'] );
			if( $t_note_visible ) {
				# only count the bugnote if user has access
				$t_stats[$c_bug_id]['bug_id'] = $c_bug_id;
				$t_stats[$c_bug_id]['last_modified'] = $t_query_row['last_modified'];
				$t_stats[$c_bug_id]['count'] = ++$t_note_count;
				$t_stats[$c_bug_id]['last_modified_bugnote'] = $t_query_row['id'];
				if( $t_query_row['date_submitted'] > $t_last_submit_date ) {
					$t_last_submit_date = $t_query_row['date_submitted'];
					$t_stats[$c_bug_id]['last_submitted_bugnote'] = $t_query_row['id'];
				}
				if( isset( $t_id_array[$c_bug_id] ) ) {
					unset( $t_id_array[$c_bug_id] );
				}
			}
			$t_counter++;
		}
	}

	# The remaining bug ids, are those without visible notes. Save false as cached value
	foreach( $t_id_array as $t_id ) {
		$t_stats[$t_id] = false;
	}
	return $t_stats;
}

/**
 * return the timestamp for the most recent time at which a bugnote
 * associated with the bug was modified and the total bugnote
 * count in one db query
 * @param integer $p_bug_id Integer representing bug identifier.
 * @return array|false Bugnote stats, false if no bugnotes
 * @access public
 * @uses database_api.php
 */
function bug_get_bugnote_stats( $p_bug_id ) {
	global $g_cache_bug;
	$c_bug_id = (int)$p_bug_id;

	if( array_key_exists( '_stats', $g_cache_bug[$c_bug_id] ) ) {
		return $g_cache_bug[$c_bug_id]['_stats'];
	}
	else {
		$t_stats = bug_get_bugnote_stats_array( array( $p_bug_id ) );
		return $t_stats[$p_bug_id];
	}
}

/**
 * Get array of attachments associated with the specified bug id.  The array will be
 * sorted in terms of date added (ASC).  The array will include the following fields:
 * id, title, diskfile, filename, filesize, file_type, date_added, user_id.
 * @param integer $p_bug_id Integer representing bug identifier.
 * @return array array of results or empty array
 * @access public
 * @uses database_api.php
 * @uses file_api.php
 */
function bug_get_attachments( $p_bug_id ) {
	db_param_push();
	$t_query = 'SELECT id, title, diskfile, filename, filesize, file_type, date_added, user_id, bugnote_id
		                FROM {bug_file}
		                WHERE bug_id=' . db_param() . '
		                ORDER BY date_added';
	$t_db_result = db_query( $t_query, array( $p_bug_id ) );

	$t_result = array();

	while( $t_row = db_fetch_array( $t_db_result ) ) {
		$t_result[] = $t_row;
	}

	return $t_result;
}

/**
 * Set the value of a bug field
 * @param integer                $p_bug_id     Integer representing bug identifier.
 * @param string                 $p_field_name Pre-defined field name.
 * @param boolean|integer|string $p_value      Value to set.
 * @return boolean (always true)
 * @access public
 * @uses database_api.php
 * @uses history_api.php
 */
function bug_set_field( $p_bug_id, $p_field_name, $p_value ) {
	$c_bug_id = (int)$p_bug_id;
	$c_value = null;

	switch( $p_field_name ) {
		# boolean
		case 'sticky':
			$c_value = $p_value;
			break;

		# integer
		case 'project_id':
		case 'reporter_id':
		case 'handler_id':
		case 'duplicate_id':
		case 'priority':
		case 'severity':
		case 'reproducibility':
		case 'status':
		case 'resolution':
		case 'projection':
		case 'category_id':
		case 'eta':
		case 'view_state':
		case 'profile_id':
		case 'sponsorship_total':
			$c_value = (int)$p_value;
			break;

		# string
		case 'os':
		case 'os_build':
		case 'platform':
		case 'version':
		case 'fixed_in_version':
		case 'target_version':
		case 'build':
		case 'summary':
			$c_value = $p_value;
			break;

		# dates
		case 'last_updated':
		case 'date_submitted':
		case 'due_date':
			if( !is_numeric( $p_value ) ) {
				trigger_error( ERROR_GENERIC, ERROR );
			}
			$c_value = $p_value;
			break;

		default:
			trigger_error( ERROR_DB_FIELD_NOT_FOUND, WARNING );
			break;
	}

	$t_current_value = bug_get_field( $p_bug_id, $p_field_name );

	# return if status is already set
	if( $c_value == $t_current_value ) {
		return true;
	}

	# Update fields
	db_param_push();
	$t_query = 'UPDATE {bug} SET ' . $p_field_name . '=' . db_param() . ' WHERE id=' . db_param();
	db_query( $t_query, array( $c_value, $c_bug_id ) );

	# updated the last_updated date
	if( $p_field_name != 'last_updated' ) {
		bug_update_date( $p_bug_id );
	}

	# log changes except for duplicate_id which is obsolete and should be removed in
	# MantisBT 1.3.
	switch( $p_field_name ) {
		case 'duplicate_id':
			break;

		case 'category_id':
			history_log_event_direct( $p_bug_id, 'category', category_full_name( $t_current_value, false ), category_full_name( $c_value, false ) );
			break;

		default:
			history_log_event_direct( $p_bug_id, $p_field_name, $t_current_value, $c_value );
	}

	bug_clear_cache( $p_bug_id );

	return true;
}

/**
 * assign the bug to the given user
 * @param integer $p_bug_id          A bug identifier.
 * @param integer $p_user_id         A user identifier.
 * @param string  $p_bugnote_text    The bugnote text.
 * @param boolean $p_bugnote_private Indicate whether bugnote is private.
 * @return boolean
 * @access public
 * @uses database_api.php
 */
function bug_assign( $p_bug_id, $p_user_id, $p_bugnote_text = '', $p_bugnote_private = false ) {
	if( $p_user_id != NO_USER ) {
		$t_bug_sponsored = config_get( 'enable_sponsorship' )
			&& sponsorship_get_amount( sponsorship_get_all_ids( $p_bug_id ) ) > 0;
		# The new handler is checked at project level
		$t_project_id = bug_get_field( $p_bug_id, 'project_id' );
		if( !access_has_project_level( config_get( 'handle_bug_threshold' ), $t_project_id, $p_user_id ) ) {
			trigger_error( ERROR_HANDLER_ACCESS_TOO_LOW, ERROR );
		}
		if( $t_bug_sponsored && !access_has_project_level( config_get( 'handle_sponsored_bugs_threshold' ), $t_project_id, $p_user_id ) ) {
			trigger_error( ERROR_SPONSORSHIP_HANDLER_ACCESS_LEVEL_TOO_LOW, ERROR );
		}
	}

	# extract current information into history variables
	$h_status = bug_get_field( $p_bug_id, 'status' );
	$h_handler_id = bug_get_field( $p_bug_id, 'handler_id' );

	$t_ass_val = bug_get_status_for_assign( $h_handler_id, $p_user_id, $h_status );

	if( ( $t_ass_val != $h_status ) || ( $p_user_id != $h_handler_id ) ) {

		# get user id
		db_param_push();
		$t_query = 'UPDATE {bug}
					  SET handler_id=' . db_param() . ', status=' . db_param() . '
					  WHERE id=' . db_param();
		db_query( $t_query, array( $p_user_id, $t_ass_val, $p_bug_id ) );

		# log changes
		history_log_event_direct( $p_bug_id, 'status', $h_status, $t_ass_val );
		history_log_event_direct( $p_bug_id, 'handler_id', $h_handler_id, $p_user_id );

		# Add bugnote if supplied ignore false return
		if( !is_blank( $p_bugnote_text ) ) {
			$t_bugnote_id = bugnote_add( $p_bug_id, $p_bugnote_text, 0, $p_bugnote_private, 0, '', null, false );
			bugnote_process_mentions( $p_bug_id, $t_bugnote_id, $p_bugnote_text );
		}

		# updated the last_updated date
		bug_update_date( $p_bug_id );

		bug_clear_cache( $p_bug_id );

		# Send email for change of handler
		// email_owner_changed( $p_bug_id, $h_handler_id, $p_user_id ); se comenta HBT 
		# send assignd to email ADD HBT 
		$resultado = email_assign( $p_bug_id ); // FIN ADD HBT
	}
	else {//ADD HBT 
		return true; 
	}// FIN ADD HBT

	return $resultado; //HBT
	// return true; se comenta 
}

/**
 * close the given bug
 * @param integer $p_bug_id          A bug identifier.
 * @param string  $p_bugnote_text    The bugnote text.
 * @param boolean $p_bugnote_private Whether the bugnote is private.
 * @param string  $p_time_tracking   Time tracking value.
 * @return boolean (always true)
 * @access public
 */
function bug_close( $p_bug_id, $p_bugnote_text = '', $p_bugnote_private = false, $p_time_tracking = '0:00' ) {
	$p_bugnote_text = trim( $p_bugnote_text );

	# Add bugnote if supplied ignore a false return
	# Moved bugnote_add before bug_set_field calls in case time_tracking_no_note is off.
	# Error condition stopped execution but status had already been changed
	if( !is_blank( $p_bugnote_text ) || $p_time_tracking != '0:00' ) {
		$t_bugnote_id = bugnote_add( $p_bug_id, $p_bugnote_text, $p_time_tracking, $p_bugnote_private, 0, '', null, false );
		bugnote_process_mentions( $p_bug_id, $t_bugnote_id, $p_bugnote_text );
	}

	bug_set_field( $p_bug_id, 'status', config_get( 'bug_closed_status_threshold' ) );

	email_close( $p_bug_id );
	email_relationship_child_closed( $p_bug_id );

	return true;
}

/**
 * resolve the given bug
 * @param integer $p_bug_id           A bug identifier.
 * @param integer $p_resolution       Resolution status.
 * @param string  $p_fixed_in_version Fixed in version.
 * @param string  $p_bugnote_text     The bugnote text.
 * @param integer $p_duplicate_id     A duplicate identifier.
 * @param integer $p_handler_id       A handler identifier.
 * @param boolean $p_bugnote_private  Whether this is a private bugnote.
 * @param string  $p_time_tracking    Time tracking value.
 * @access public
 * @return boolean
 */
function bug_resolve( $p_bug_id, $p_resolution, $p_fixed_in_version = '', $p_bugnote_text = '', $p_duplicate_id = null, $p_handler_id = null, $p_bugnote_private = false, $p_time_tracking = '0:00' ) {
	$c_resolution = (int)$p_resolution;
	$p_bugnote_text = trim( $p_bugnote_text );

	# Add bugnote if supplied
	# Moved bugnote_add before bug_set_field calls in case time_tracking_no_note is off.
	# Error condition stopped execution but status had already been changed
	if( !is_blank( $p_bugnote_text ) || $p_time_tracking != '0:00' ) {
		$t_bugnote_id = bugnote_add( $p_bug_id, $p_bugnote_text, $p_time_tracking, $p_bugnote_private, 0, '', null, false );
		bugnote_process_mentions( $p_bug_id, $t_bugnote_id, $p_bugnote_text );
	}

	$t_duplicate = !is_blank( $p_duplicate_id ) && ( $p_duplicate_id != 0 );
	if( $t_duplicate ) {
		if( $p_bug_id == $p_duplicate_id ) {
			trigger_error( ERROR_BUG_DUPLICATE_SELF, ERROR );

			# never returns
		}

		# the related bug exists...
		bug_ensure_exists( $p_duplicate_id );

		relationship_upsert( $p_bug_id, $p_duplicate_id, BUG_DUPLICATE, /* email_for_source */ false );

		# Copy list of users monitoring the duplicate bug to the original bug
		$t_old_reporter_id = bug_get_field( $p_bug_id, 'reporter_id' );
		$t_old_handler_id = bug_get_field( $p_bug_id, 'handler_id' );
		if( user_exists( $t_old_reporter_id ) ) {
			bug_monitor( $p_duplicate_id, $t_old_reporter_id );
		}
		if( user_exists( $t_old_handler_id ) ) {
			bug_monitor( $p_duplicate_id, $t_old_handler_id );
		}
		bug_monitor_copy( $p_bug_id, $p_duplicate_id );

		bug_set_field( $p_bug_id, 'duplicate_id', (int)$p_duplicate_id );
	}

	bug_set_field( $p_bug_id, 'status', config_get( 'bug_resolved_status_threshold' ) );
	bug_set_field( $p_bug_id, 'fixed_in_version', $p_fixed_in_version );
	bug_set_field( $p_bug_id, 'resolution', $c_resolution );

	# only set handler if specified explicitly or if bug was not assigned to a handler
	if( null == $p_handler_id ) {
		if( bug_get_field( $p_bug_id, 'handler_id' ) == 0 ) {
			$p_handler_id = auth_get_current_user_id();
			bug_set_field( $p_bug_id, 'handler_id', $p_handler_id );
		}
	} else {
		bug_set_field( $p_bug_id, 'handler_id', $p_handler_id );
	}

	$resultado = email_resolved( $p_bug_id ); // HBT Almacenamos el resultado
	email_relationship_child_resolved( $p_bug_id );

	return $resultado; /* HBT retornamos el resultado */
	// return true; se comenta 
}

/**
 * reopen the given bug
 * @param integer $p_bug_id          A bug identifier.
 * @param string  $p_bugnote_text    The bugnote text.
 * @param string  $p_time_tracking   Time tracking value.
 * @param boolean $p_bugnote_private Whether this is a private bugnote.
 * @return boolean (always true)
 * @access public
 * @uses database_api.php
 * @uses email_api.php
 * @uses bugnote_api.php
 * @uses config_api.php
 */
function bug_reopen( $p_bug_id, $p_bugnote_text = '', $p_time_tracking = '0:00', $p_bugnote_private = false ) {
	$p_bugnote_text = trim( $p_bugnote_text );

	# Add bugnote if supplied
	# Moved bugnote_add before bug_set_field calls in case time_tracking_no_note is off.
	# Error condition stopped execution but status had already been changed
	if( !is_blank( $p_bugnote_text ) || $p_time_tracking != '0:00' ) {
		$t_bugnote_id = bugnote_add( $p_bug_id, $p_bugnote_text, $p_time_tracking, $p_bugnote_private, 0, '', null, false );
		bugnote_process_mentions( $p_bug_id, $t_bugnote_id, $p_bugnote_text );
	}
	
	bug_set_field( $p_bug_id, 'status', config_get( 'bug_reopen_status' ) );
	bug_set_field( $p_bug_id, 'resolution', config_get( 'bug_reopen_resolution' ) );

	// email_bug_reopened( $p_bug_id ); Se comenta HBT 

	$resultado = email_reopen( $p_bug_id ); /* HBT se alamcena el resultado y se invoca la email_reopen creada en el archo email.php */
	return $resultado;//  retornamos el resultado
	// return true; se comenta
}

/**
 * updates the last_updated field
 * @param integer $p_bug_id Integer representing bug identifier.
 * @return boolean (always true)
 * @access public
 * @uses database_api.php
 */
function bug_update_date( $p_bug_id ) {
	db_param_push();
	$t_query = 'UPDATE {bug} SET last_updated=' . db_param() . ' WHERE id=' . db_param();
	db_query( $t_query, array( db_now(), $p_bug_id ) );

	bug_clear_cache( $p_bug_id );

	return true;
}

/**
 * enable monitoring of this bug for the user
 * @param integer $p_bug_id  Integer representing bug identifier.
 * @param integer $p_user_id Integer representing user identifier.
 * @return boolean true if successful, false if unsuccessful
 * @access public
 * @uses database_api.php
 * @uses history_api.php
 * @uses user_api.php
 */
function bug_monitor( $p_bug_id, $p_user_id ) {
	$c_bug_id = (int)$p_bug_id;
	$c_user_id = (int)$p_user_id;

	# Make sure we aren't already monitoring this bug
	if( user_is_monitoring_bug( $c_user_id, $c_bug_id ) ) {
		return true;
	}

	# Don't let the anonymous user monitor bugs
	if( user_is_anonymous( $c_user_id ) ) {
		return false;
	}

	# Insert monitoring record
	db_param_push();
	$t_query = 'INSERT INTO {bug_monitor} ( user_id, bug_id ) VALUES (' . db_param() . ',' . db_param() . ')';
	db_query( $t_query, array( $c_user_id, $c_bug_id ) );

	# log new monitoring action
	history_log_event_special( $c_bug_id, BUG_MONITOR, $c_user_id );

	# updated the last_updated date
	bug_update_date( $p_bug_id );

	email_monitor_added( $p_bug_id, $p_user_id );

	return true;
}

/**
 * Returns the list of users monitoring the specified bug
 *
 * @param integer $p_bug_id Integer representing bug identifier.
 * @return array
 */
function bug_get_monitors( $p_bug_id ) {
	if( ! access_has_bug_level( config_get( 'show_monitor_list_threshold' ), $p_bug_id ) ) {
		return array();
	}

	# get the bugnote data
	db_param_push();
	$t_query = 'SELECT user_id, enabled
			FROM {bug_monitor} m, {user} u
			WHERE m.bug_id=' . db_param() . ' AND m.user_id = u.id
			ORDER BY u.realname, u.username';
	$t_result = db_query( $t_query, array( $p_bug_id ) );

	$t_users = array();
	while( $t_row = db_fetch_array( $t_result ) ) {
		$t_users[] = $t_row['user_id'];
	}

	user_cache_array_rows( $t_users );

	return $t_users;
}

/**
 * Copy list of users monitoring a bug to the monitor list of a second bug
 * @param integer $p_source_bug_id Integer representing the bug identifier of the source bug.
 * @param integer $p_dest_bug_id   Integer representing the bug identifier of the destination bug.
 * @return void
 * @access public
 * @uses database_api.php
 * @uses history_api.php
 * @uses user_api.php
 */
function bug_monitor_copy( $p_source_bug_id, $p_dest_bug_id ) {
	$c_source_bug_id = (int)$p_source_bug_id;
	$c_dest_bug_id = (int)$p_dest_bug_id;

	db_param_push();
	$t_query = 'SELECT user_id FROM {bug_monitor} WHERE bug_id = ' . db_param();
	$t_result = db_query( $t_query, array( $c_source_bug_id ) );

	while( $t_bug_monitor = db_fetch_array( $t_result ) ) {
		if( user_exists( $t_bug_monitor['user_id'] ) &&
			!user_is_monitoring_bug( $t_bug_monitor['user_id'], $c_dest_bug_id ) ) {
			db_param_push();
			$t_query = 'INSERT INTO {bug_monitor} ( user_id, bug_id )
				VALUES ( ' . db_param() . ', ' . db_param() . ' )';
			db_query( $t_query, array( $t_bug_monitor['user_id'], $c_dest_bug_id ) );
			history_log_event_special( $c_dest_bug_id, BUG_MONITOR, $t_bug_monitor['user_id'] );
		}
	}
}

/**
 * disable monitoring of this bug for the user
 * if $p_user_id = null, then bug is unmonitored for all users.
 * @param integer $p_bug_id  Integer representing bug identifier.
 * @param integer $p_user_id Integer representing user identifier.
 * @return boolean (always true)
 * @access public
 * @uses database_api.php
 * @uses history_api.php
 */
function bug_unmonitor( $p_bug_id, $p_user_id ) {
	# Delete monitoring record
	db_param_push();
	$t_query = 'DELETE FROM {bug_monitor} WHERE bug_id = ' . db_param();
	$t_db_query_params[] = $p_bug_id;

	if( $p_user_id !== null ) {
		$t_query .= ' AND user_id = ' . db_param();
		$t_db_query_params[] = $p_user_id;
	}

	db_query( $t_query, $t_db_query_params );

	# log new un-monitor action
	history_log_event_special( $p_bug_id, BUG_UNMONITOR, (int)$p_user_id );

	# updated the last_updated date
	bug_update_date( $p_bug_id );

	return true;
}

/**
 * Pads the bug id with the appropriate number of zeros.
 * @param integer $p_bug_id A bug identifier.
 * @return string
 * @access public
 * @uses config_api.php
 */
function bug_format_id( $p_bug_id ) {
	$t_padding = config_get( 'display_bug_padding' );
	$t_string = sprintf( '%0' . (int)$t_padding . 'd', $p_bug_id );

	return event_signal( 'EVENT_DISPLAY_BUG_ID', $t_string, array( $p_bug_id ) );
}

/**
 * Returns the resulting status for a bug after an assignment action is performed.
 * If the option "auto_set_status_to_assigned" is enabled, the resulting status
 * is calculated based on current handler and status , and requested modifications.
 * @param integer $p_current_handler	Current handler user id
 * @param integer $p_new_handler		New handler user id
 * @param integer $p_current_status		Current bug status
 * @param integer $p_new_status			New bug status (as being part of a status change combined action)
 * @return integer		Calculated status after assignment
 */
function bug_get_status_for_assign( $p_current_handler, $p_new_handler, $p_current_status, $p_new_status = null ) {
	if( null === $p_new_status ) {
		$p_new_status = $p_current_status;
	}
	if( config_get( 'auto_set_status_to_assigned' ) ) {
		$t_assigned_status = config_get( 'bug_assigned_status' );

		if(		$p_current_handler == NO_USER &&
				$p_new_handler != NO_USER &&
				$p_new_status == $p_current_status &&
				$p_new_status < $t_assigned_status &&
				bug_check_workflow( $p_current_status, $t_assigned_status ) ) {

			return $t_assigned_status;
		}
	}
	return $p_new_status;
}

/**
 * Clear a bug from all the related caches or all bugs if no bug id specified.
 * @param integer $p_bug_id A bug identifier to clear (optional).
 * @return boolean
 * @access public
 */
function bug_clear_cache_all( $p_bug_id = null ) {
	bug_clear_cache( $p_bug_id );
	bug_text_clear_cache( $p_bug_id );
	file_bug_attachment_count_clear_cache( $p_bug_id );
	bugnote_clear_bug_cache( $p_bug_id );
	tag_clear_cache_bug_tags( $p_bug_id );
	custom_field_clear_cache_values( $p_bug_id );

	$t_plugin_objects = columns_get_plugin_columns();
	foreach( $t_plugin_objects as $t_plugin_column ) {
		$t_plugin_column->clear_cache();
	}
	return true;
}

/**
 * Populate the caches related to the selected columns
 * @param array $p_bugs	Array of BugData objects
 * @param array $p_selected_columns	Array of columns to show
 */
function bug_cache_columns_data( array $p_bugs, array $p_selected_columns ) {
	$t_bug_ids = array();
	$t_user_ids = array();
	$t_project_ids = array();
	$t_category_ids = array();
	foreach( $p_bugs as $t_bug ) {
		$t_bug_ids[] = (int)$t_bug->id;
		$t_user_ids[] = (int)$t_bug->handler_id;
		$t_user_ids[] = (int)$t_bug->reporter_id;
		$t_project_ids[] = (int)$t_bug->project_id;
		$t_category_ids[] = (int)$t_bug->category_id;
	}
	$t_user_ids = array_unique( $t_user_ids );
	$t_project_ids = array_unique( $t_project_ids );
	$t_category_ids = array_unique( $t_category_ids );

	$t_custom_field_ids = array();
	$t_users_cached = false;
	foreach( $p_selected_columns as $t_column ) {

		if( column_is_plugin_column( $t_column ) ) {
			$plugin_objects = columns_get_plugin_columns();
			$plugin_objects[$t_column]->cache( $p_bugs );
			continue;
		}

		if( column_is_custom_field( $t_column ) ) {
			$t_cf_name = column_get_custom_field_name( $t_column );
			$t_cf_id = custom_field_get_id_from_name( $t_cf_name );
			if( $t_cf_id ) {
				$t_custom_field_ids[] = $t_cf_id;
				continue;
			}
		}

		switch( $t_column ) {
			case 'attachment_count':
				file_bug_attachment_count_cache( $t_bug_ids );
				break;
			case 'handler_id':
			case 'reporter_id':
			case 'status':
				if( !$t_users_cached ) {
					user_cache_array_rows( $t_user_ids );
					$t_users_cached = true;
				}
				break;
			case 'project_id':
				project_cache_array_rows( $t_project_ids );
				break;
			case 'category_id':
				category_cache_array_rows( $t_category_ids );
				break;
			case 'tags':
				tag_cache_bug_tag_rows( $t_bug_ids );
				break;
		}
	}

	if( !empty( $t_custom_field_ids ) ) {
		custom_field_cache_values( $t_bug_ids, $t_custom_field_ids );
	}
}

// ADD HBT 
/**
 * M�todo que permite determinar si una fecha ingresada por la interfaz grafica
 * cumple con los tres campos (a�o-mes-dia).
 * @param unknown_type $year a�o de la fecha
 * @param unknown_type $mounth mes de la fecha
 * @param unknown_type $day dia de la fecha;
 */
function validar_fecha_estructura ($year, $mounth, $day, $campo_fecha) {
	// Si los tres campos son vacios quiere decir que no se selecciono ninguna fecha
	// por lo que retornamos true para indicar que esta correcto
	if ($year == 0 && $mounth == 0 && $day == 0) {
		return;
	} else {
		// Si por el contrario llega a tener alg�n campo en blanco
		// quiere decir que no se seleccion� la fecha completa
		// a�o-mes-dia.
		if ($year == 0 || $mounth == 0 || $day == 0) {
			trigger_error('A la ' . $campo_fecha . ' le faltan datos', ERROR );
		}
	}
}

/**
 * Requerimiento 791.
 * 
 * Este m�todo permite validar que las fechas de un entregable no sean menores a la
 * fecha de devoluci�n del entregable anterior. Adem�s permite verificar que la estructura
 * de las fechas sea la correcta (DD/MM/AAA) y que no sean fechas festivas o no laborables.
 * Tambi�n se evita:
 * 1.	Tener una fecha real, de devoluci�n y/o causa de devoluci�n sin tener una fecha planeada. 
 * 2.	Tener una fecha de devoluci�n y/o causa de devoluci�n sin tener una fecha real. 
 * 3.	Tener una fecha de devoluci�n sin tener una causa de devoluci�n y viceversa.
 * 4.	Tener una fecha de devoluci�n menor a la fecha real de la entrega.
 * @param unknown_type $bug
 * @param unknown_type $entrega_anterior
 */
function validar_fechas_entregas_editar($bug, $entrega_anterior, $nueva) {
	/*
	 * En caso de agregar la primera entrega por medio de la ventana
	 * de edici�n, se deber� hacer la misma validaci�n que hacemos para
	 * crear una entrega en la ventana de crear entrega.
	 */
	if ($entrega_anterior == null) {
		// Si es una nueva entrega nos dirigimos a la validaciones para crear una entrega.
		if ($nueva == true) {
			validar_fechas_entregas_crear($bug, $nueva);
			// evitamos hacer las validaciones de esta caso.
			return;
		} else {
			// Se entra a las validaciones para editar la primera entrega.
			editar_primera_entrega($bug);
			return;
		}

	}
	// Validamos que la fecha planeada tenga una estructura correcta.
	validar_fecha_estructura($bug->date_year_planned_791, $bug->date_mounth_planned_791,
	$bug->date_day_planned_791, lang_get('planned_date_791'));

	// Validamos que la fecha real tenga una estructura correcta.
	validar_fecha_estructura($bug->date_year_real_791, $bug->date_mounth_real_791,
	$bug->date_day_real_791, lang_get('real_date_791'));

	// Validamos que la fecha de devoluci�n tenga una estructura correcta.
	validar_fecha_estructura($bug->date_year_return_791, $bug->date_mounth_return_791,
	$bug->date_day_return_791, lang_get('return_date_791'));

	//Validamos que la fecha planeada sea un d�a laborable.
	validar_fecha_no_laborable($bug->date_year_planned_791, $bug->date_mounth_planned_791,
	$bug->date_day_planned_791, lang_get('planned_date_791'));

	//Validamos que la fecha real sea un d�a laborable.
	validar_fecha_no_laborable($bug->date_year_real_791, $bug->date_mounth_real_791,
	$bug->date_day_real_791, lang_get('real_date_791'));

	//Validamos que la fecha de devoluci�n sea un d�a laborable.
	validar_fecha_no_laborable($bug->date_year_return_791, $bug->date_mounth_return_791,
	$bug->date_day_return_791, lang_get('return_date_791'));
	
	/*
	 * Si la fecha planeada no esta vacia, osea sus campos son mayores a cero (0),
	 * se van a comparar que la fecha planeada sea mayor o igual a la fecha de devoluci�n
	 * de la entrega anterior.
	 */
	if ($bug->date_year_planned_791 > 0 && $bug->date_mounth_planned_791 > 0
	&& $bug->date_day_planned_791 > 0) {
		/*
		 * Coparamos que la fecha de planeada de la nueva entrega sea mayor o
		 * igual a la fecha de devoluci�n de la entrega anterior.
		 */
		comprar_fechas($entrega_anterior['fecha_devolucion_anio'], $entrega_anterior['fecha_devolucion_mes'],
		$entrega_anterior['fecha_devolucion_dia'], $bug->date_year_planned_791, $bug->date_mounth_planned_791,
		$bug->date_day_planned_791, lang_get('error_devolucion_mayor_planeada'));
		/*
		 * Si la fecha real no esta vacia, osea sus campos son mayores a cero (0),
		 * se van a comparar que la fecha real sea mayor o igual a la fecha de devoluci�n
		 * de la entrega anterior.
		 */
		if ($bug->date_year_real_791 > 0 && $bug->date_mounth_real_791 > 0
		&& $bug->date_day_real_791 > 0) {
			/*
			 * Coparamos que la fecha de planeada de la nueva entrega sea mayor o
			 * igual a la fecha de devoluci�n de la entrega anterior.
			 */
			comprar_fechas($entrega_anterior['fecha_devolucion_anio'], $entrega_anterior['fecha_devolucion_mes'],
			$entrega_anterior['fecha_devolucion_dia'], $bug->date_year_real_791, $bug->date_mounth_real_791,
			$bug->date_day_real_791, lang_get('error_devolucion_mayor_real'));
			/*
			 * Si la fecha de devoluci�n no esta vacia, osea sus campos son mayores a cero (0),
			 * se van a comparar que la fecha de devoluci�n sea mayor o igual a la fecha real
			 * de la entrega actual
			 */
			if ($bug->date_year_return_791 > 0 && $bug->date_mounth_return_791 > 0
			&& $bug->date_day_return_791 > 0) {
				/*
				 * Coparamos que la fecha de de devoluci�n de la nueva entrega sea mayor o
				 * igual a la fecha real de la entrega.
				 */
				comprar_fechas($bug->date_year_real_791, $bug->date_mounth_real_791,
				$bug->date_day_real_791, $bug->date_year_return_791, $bug->date_mounth_return_791,
				$bug->date_day_return_791 , lang_get('error_real_mayor_devolucion'));
				/*
				 * Si hay una fecha de devoluci�n, necesariomente debe haber una causa
				 * de devoluci�n, de lo contario habr� un errror.
				 */
				if (is_blank($bug->cause_return_791)) {
					trigger_error((lang_get('error_devolucion_sin_causa')),ERROR);
				}
			}  else {
				/*
				 * No se puede tener una causa de devoluci�n si no se tiene
				 * una fecha de devoluci�n.
				 */
				if (!is_blank($bug->cause_return_791)) {
					trigger_error((lang_get('error_causa_sin_devolucion')),ERROR);
				}
			}
		} else {
			/*
			 * No se podr� ingresar una fecha de devoluci�n sin tener una fecha real.
			 */
			if ($bug->date_year_return_791 > 0 && $bug->date_mounth_return_791 > 0
			&& $bug->date_day_return_791 > 0) {
				trigger_error(lang_get('error_devolucion_sin_planeada'),ERROR);
			}
			/*
			 * No se puede tener una causa de devoluci�n si no se tiene
			 * una fecha real.
			 */
			if (!is_blank($bug->cause_return_791)) {
				trigger_error((lang_get('error_causa_sin_real')),ERROR);
			}
		}
	} else {
		/*
		 * No se podr� ingresar una una fecha real sin tener una fecha planeada.
		 */
		if ($bug->date_year_real_791 > 0 && $bug->date_mounth_real_791 > 0
		&& $bug->date_day_real_791 > 0) {
			trigger_error(lang_get('error_real_sin_planeada'),ERROR);
		}
		/*
		 * No se podr� ingresar una fecha de devoluci�n sin tener una fecha planeadaa.
		 */
		if ($bug->date_year_return_791 > 0 && $bug->date_mounth_return_791 > 0
		&& $bug->date_day_return_791 > 0) {
			trigger_error(lang_get('error_devolucion_sin_planeada'),ERROR);
		}
		/*
		 * No se puede tener una causa de devoluci�n si no se tiene una
		 * fecha planeada
		 */
		if (!is_blank($bug->cause_return_791)) {
			trigger_error((lang_get('error_causa_sin_planeada')),ERROR);
		}
			
	}
}

function comprar_fechas ($anio_base, $mes_base, $dia_base, $anio_comparar, $mes_comparar, $dia_comparar, $error = 'error') {
	// si el a�o a comparar es mayor a el base, saldremos de la validadci�n, pues
	// esto indicar�a que la fecha a comparar es mayor a la base.
	if ($anio_comparar > $anio_base) {
		return;
	} else {
		// Si el a�o a comparar no es mayor, preguntamos si es igual, para continuar 
		// con la comparaci�n entre mes y d�a. 
		if ($anio_comparar == $anio_base) {
			// si el mes a comparar es mayor a el base, saldremos de la validadci�n, pues
			// esto indicar�a que la fecha a comparar es mayor a la base.
			if ($mes_comparar > $mes_base) {
				return;
			} else {
				// Si el mes a comparar no es mayor, preguntamos si es igual, para continuar 
				// con la comparaci�n entre los d�as. 
				if ($mes_comparar == $mes_base) {
					// si el dia a comparar es mayor a el base, saldremos de la validadci�n, pues
					// esto indicar�a que la fecha a comparar es mayor a la base.
					if ($dia_comparar > $dia_base) {
						return;
					} else {
						// Si el d�a a comparar no es mayor, preguntamos si es igual. Si es igual
						// saldremos del m�todo pues la fecha base no es mayor a la comparada
						if ($dia_comparar == $dia_base) {
							return;
						} else {
							// Mostramos error en la pantalla, la fecha es mayor a la maxima del sistema
							error_fecha($error);
						}
					}
				} else {
					// Mostramos error en la pantalla, la fecha es mayor a la maxima del sistema
					error_fecha($error);
				}
			}
		} else {
			// Mostramos error en la pantalla, la fecha es mayor a la maxima del sistema
			error_fecha($error);
		}
	}
}

function error_fecha ($error) {
	trigger_error($error, ERROR );
}

/**
 * Requerimiento 791.
 * 
 * M�todo para determinar si vamos a actualizar una entrega o vamos a crear una 
 * nueva entrega. Todo depende de si todas las entregas del entregalbe que llega al 
 * m�todo tiene una fecha de devoluci�n, significar� que se va a realizar una nueva entrega,
 * de lo contrario es claro que vamos a editar la �ltima entrega que tenemos para el 
 * entregable.
 * @param $bug entrega que estamos actualizando.
 */
function entregas_actualizar_o_nueva ($bug) {
	// De esta tabla vamos a sacar los datos de la entrega 
	$table_entregas = 'mantis_bug_entregas_table';
	/*
	 * Con esta consulta obtenemos un 1 o un 0. Para traer un 1 la cantidad de entregas
	 * con fechas de devoluci�n deben ser iguales a la cantidad de entregas de un 
	 * entregable. De no cumplirse la condici�n anterior se devolvera un 0.
	 */
	$query = "select if (cantidad_entregas = entregas_devueltas, 1, 0) as nueva 
	from (select count(1) as cantidad_entregas from $table_entregas 
	where id_bug =" . db_param() . ") entregas, 
	(select count(1) as entregas_devueltas from $table_entregas
	where id_bug = " . db_param() . " and fecha_devolucion_dia is not null and fecha_devolucion_dia >0
	and fecha_devolucion_mes is not null and fecha_devolucion_mes >0
	and fecha_devolucion_anio is not null and fecha_devolucion_anio >0) devueltas";
	/*
	 * Ejecutamos la consulta y le enviamos los dos parametros que requiere 
	 * la consulta. Para ambos env�amos el id del entregable.
	 */
	$result = db_query($query, Array($bug->id,$bug->id));
	/*
	 * Si obtuvimos un resultado 1 (positivos) retornamos un true, de lo contrario
	 * retornaremos un false.
	 */
	if ($result->fields[nueva] == 1) {
		return true;
	} else {
		return false;
	}
}

function bug_entregas_maxima( $p_bug_id) {
	// Tabla a la que vamos a realizar la consulta de los datos de la entrega
	$t_mantis_bug_entrega = 'mantis_bug_entregas_table';
	// Consulta para obtener los datos de la entrega que tenga la fecha 
	// de devoluci�n m�s alta
	$query = "select id, fecha_planeada_dia, fecha_planeada_mes, fecha_planeada_anio,
		fecha_real_dia, fecha_real_mes, fecha_real_anio,  
		fecha_devolucion_dia, fecha_devolucion_mes, fecha_devolucion_anio, causa
		from mantis_bug_entregas_table where id = (	select id
		from (select id, fecha_devolucion_anio, fecha_devolucion_mes, fecha_devolucion_dia
			from (select id, fecha_devolucion_anio, fecha_devolucion_mes, fecha_devolucion_dia
			from mantis_bug_entregas_table 
			where id_bug = ".db_param()." and fecha_devolucion_anio = 
			(select max(fecha_devolucion_anio)
			from mantis_bug_entregas_table where id_bug = ".db_param().")) anioMayor
			where anioMayor. fecha_devolucion_mes =
			(select max(fecha_devolucion_mes)
			from (select id, fecha_devolucion_anio, fecha_devolucion_mes, fecha_devolucion_dia
			from mantis_bug_entregas_table
			where fecha_devolucion_anio = (select max(fecha_devolucion_anio)	
			from mantis_bug_entregas_table)) mesMaximo)limit 1) diaMaximo
		where fecha_devolucion_dia =
			(select max(fecha_devolucion_dia)
			from (select id, fecha_devolucion_anio, fecha_devolucion_mes, fecha_devolucion_dia
			from (select id, fecha_devolucion_anio, fecha_devolucion_mes, fecha_devolucion_dia
			from mantis_bug_entregas_table
			where id_bug = ".db_param()." and fecha_devolucion_anio = (select max(fecha_devolucion_anio)
			from mantis_bug_entregas_table where id_bug = ".db_param().")) anioMayor
			where anioMayor. fecha_devolucion_mes = (select max(fecha_devolucion_mes)
			from (select id, fecha_devolucion_anio, fecha_devolucion_mes, fecha_devolucion_dia	
			from mantis_bug_entregas_table  where fecha_devolucion_anio = 
			(select max(fecha_devolucion_anio) from mantis_bug_entregas_table)) mesMaximo)limit 1) diaMaximo)) ";
	// Damos los parametros y ejecutamos la consulta.
	$result = db_query( $query, Array( $p_bug_id, $p_bug_id, $p_bug_id, $p_bug_id ) );
//	// En este array vamos a guardar los datos de la entrega.
//	$entrega = array();
	//N�mero de entregas que tiene un entregable.
	$entrega_count = db_num_rows( $result );
	// Si la consulta no tiene datos, salimos del m�todo.
	if ($entrega_count == 0) {
		return null;
	}
	// Recorremos los resultados de la consulta.
	for( $i = 0, $j = 0;$i < $entrega_count;++$i ) {
		// Obtenemos linea por lina los resultados arrojados de la consulta
		$t_row = db_fetch_array( $result );
		// Sacamos los valores de las columnas.
		$v_id = $t_row['id'];
		$v_dia_planeado = $t_row['fecha_planeada_dia'];
		$v_mes_planeado = $t_row['fecha_planeada_mes'];
		$v_anio_planeado = $t_row['fecha_planeada_anio'];
		$v_dia_real = $t_row['fecha_real_dia'];
		$v_mes_real = $t_row['fecha_real_mes'];
		$v_anio_real = $t_row['fecha_real_anio'];
		$v_dia_devolucion = $t_row['fecha_devolucion_dia'];
		$v_mes_devolucion = $t_row['fecha_devolucion_mes'];
		$v_anio_devolucion = $t_row['fecha_devolucion_anio'];
		$v_causa = $t_row['causa'];
		// Guardamos los datos de cada entrega
		$entrega['id'] = $v_id;
		$entrega['fecha_planeada_dia'] = $v_dia_planeado;
		$entrega['fecha_planeada_mes'] = $v_mes_planeado;
		$entrega['fecha_planeada_anio'] = $v_anio_planeado;
		$entrega['fecha_real_dia'] = $v_dia_real;
		$entrega['fecha_real_mes'] = $v_mes_real;
		$entrega['fecha_real_anio'] = $v_anio_real;
		$entrega['fecha_devolucion_dia'] = $v_dia_devolucion;
		$entrega['fecha_devolucion_mes'] = $v_mes_devolucion;
		$entrega['fecha_devolucion_anio'] = $v_anio_devolucion;
		$entrega['causa'] = $v_causa;		
		return $entrega;
	}
	// Retornamos el arreglo con las entregas del entregable.
	return null;
}

/**
 * Requerimiento 791.
 * 
 * M�todo para obtener el id de la entrega que vamos a editar.
 * @param $id_bug
 */
function get_id_entrega_a_actualizar($id_bug) {
	// Tabla en la que se almacenan las entregas.
	$table_entregas = 'mantis_bug_entregas_table';
	/*
	 * Obtenemos la entrega, de el entregable que llega al m�todo,
	 *  que no tenga una fecha de devoluci�n.
	 */
	$query = "select id from $table_entregas where id_bug = " . db_param() . " 
		and (fecha_devolucion_dia is null or fecha_devolucion_dia = 0) 
		and (fecha_devolucion_mes is null or fecha_devolucion_mes = 0)
		and (fecha_devolucion_anio is null or fecha_devolucion_anio = 0)";
	// Enviamos el id de la entrega a la consulta y obtenemos los resultados.
	$result = db_query($query, Array($id_bug));
	// Retornamos el id de la consulta.
	return $result->fields[id];
}

/**
 * Requerimiento 791.
 * 
 * M�todo para obtener el id de la entrega que vamos a editar.
 * @param $id_bug
 */
function get_entrega_a_actualizar($id_bug) {
	// Tabla en la que se almacenan las entregas.
	$table_entregas = 'mantis_bug_entregas_table';
	/*
	 * Obtenemos la entrega, de el entregable que llega al m�todo,
	 *  que no tenga una fecha de devoluci�n.
	 */
	$query = "select id, 
			id_bug, 
			fecha_planeada_dia, 
			fecha_planeada_mes, 
			fecha_planeada_anio, 
			fecha_real_dia, 
			fecha_real_mes, 
			fecha_real_anio, 
			fecha_devolucion_dia, 
			fecha_devolucion_mes, 
			fecha_devolucion_anio, 
			causa
		from $table_entregas where id_bug = " . db_param() . " 
		and (fecha_devolucion_dia is null or fecha_devolucion_dia = 0) 
		and (fecha_devolucion_mes is null or fecha_devolucion_mes = 0)
		and (fecha_devolucion_anio is null or fecha_devolucion_anio = 0)";
	// Enviamos el id de la entrega a la consulta y obtenemos los resultados.
	$result = db_query($query, Array($id_bug));
	// Retornamos el id de la consulta.
	return $result->fields;
}

/**
 * Requerimiento 791.
 * 
 * Este m�todo permite validar que no se cambie la fecha planeada de la primera 
 * entrega, al momento de editar dicha entrega, por una fecha menor a la almacenada 
 * en el sistema.
 * 
 * Tambi�n se evita:
 * 1.	Tener una fecha real, de devoluci�n y/o causa de devoluci�n sin tener una fecha planeada. 
 * 2.	Tener una fecha de devoluci�n y/o causa de devoluci�n sin tener una fecha real. 
 * 3.	Tener una fecha de devoluci�n sin tener una causa de devoluci�n y viceversa.
 * 4.	Tener una fecha de devoluci�n menor a la fecha real de la entrega.
 * 
 * @param unknown_type $bug
 * @param unknown_type $old_bug
 */
function editar_primera_entrega($bug) {
	// Validamos que la fecha planeada tenga una estructura correcta.
	validar_fecha_estructura($bug->date_year_planned_791, $bug->date_mounth_planned_791,
	$bug->date_day_planned_791, lang_get('planned_date_791'));

	// Validamos que la fecha real tenga una estructura correcta.
	validar_fecha_estructura($bug->date_year_real_791, $bug->date_mounth_real_791,
	$bug->date_day_real_791, lang_get('real_date_791'));

	// Validamos que la fecha de devoluci�n tenga una estructura correcta.
	validar_fecha_estructura($bug->date_year_return_791, $bug->date_mounth_return_791,
	$bug->date_day_return_791, lang_get('return_date_791'));

	//Validamos que la fecha planeada sea un d�a laborable.
	validar_fecha_no_laborable($bug->date_year_planned_791, $bug->date_mounth_planned_791,
	$bug->date_day_planned_791, lang_get('planned_date_791'));

	//Validamos que la fecha real sea un d�a laborable.
	validar_fecha_no_laborable($bug->date_year_real_791, $bug->date_mounth_real_791,
	$bug->date_day_real_791, lang_get('real_date_791'));

	//Validamos que la fecha de devoluci�n sea un d�a laborable.
	validar_fecha_no_laborable($bug->date_year_return_791, $bug->date_mounth_return_791,
	$bug->date_day_return_791, lang_get('return_date_791'));

	$old_bug = get_entrega_a_actualizar($bug->id);
	
	if ($bug->date_year_planned_791 > 0 && $bug->date_mounth_planned_791 > 0
	&& $bug->date_day_planned_791 > 0) {
		/*
		 * Coparamos que la nueva fecha de planeada de la entrega sea mayor o
		 * igual a la fecha planeada guardada en el sistema.
		 */
		comprar_fechas($old_bug['fecha_planeada_anio'], $old_bug['fecha_planeada_mes'],
		$old_bug['fecha_planeada_dia'], $bug->date_year_planned_791, $bug->date_mounth_planned_791,
		$bug->date_day_planned_791, lang_get('error_planeada_menor_planeada'));
		/*
		 * Si la fecha real no esta vacia, osea sus campos son mayores a cero (0),
		 * se van a comparar que la fecha real sea mayor o igual a la fecha de devoluci�n
		 * de la entrega anterior.
		 */
		if ($bug->date_year_real_791 > 0 && $bug->date_mounth_real_791 > 0
		&& $bug->date_day_real_791 > 0) {			
			/*
			 * Si la fecha de devoluci�n no esta vacia, osea sus campos son mayores a cero (0),
			 * se van a comparar que la fecha de devoluci�n sea mayor o igual a la fecha real
			 * de la entrega actual
			 */
			if ($bug->date_year_return_791 > 0 && $bug->date_mounth_return_791 > 0
			&& $bug->date_day_return_791 > 0) {
				/*
				 * Coparamos que la fecha de de devoluci�n de la nueva entrega sea mayor o
				 * igual a la fecha real de la entrega.
				 */
				comprar_fechas($bug->date_year_real_791, $bug->date_mounth_real_791,
				$bug->date_day_real_791, $bug->date_year_return_791, $bug->date_mounth_return_791,
				$bug->date_day_return_791 , lang_get('error_real_mayor_devolucion'));
				/*
				 * Si hay una fecha de devoluci�n, necesariomente debe haber una causa
				 * de devoluci�n, de lo contario habr� un errror.
				 */
				if (is_blank($bug->cause_return_791)) {
					trigger_error((lang_get('error_devolucion_sin_causa')),ERROR);
				}
			}  else {
				/*
				 * No se puede tener una causa de devoluci�n si no se tiene
				 * una fecha de devoluci�n.
				 */
				if (!is_blank($bug->cause_return_791)) {
					trigger_error((lang_get('error_causa_sin_devolucion')),ERROR);
				}
			}
		} else {
			/*
			 * No se podr� ingresar una fecha de devoluci�n sin tener una fecha real.
			 */
			if ($bug->date_year_return_791 > 0 && $bug->date_mounth_return_791 > 0
			&& $bug->date_day_return_791 > 0) {
				trigger_error(lang_get('error_devolucion_sin_planeada'),ERROR);
			}
			/*
			 * No se puede tener una causa de devoluci�n si no se tiene
			 * una fecha real.
			 */
			if (!is_blank($bug->cause_return_791)) {
				trigger_error((lang_get('error_causa_sin_real')),ERROR);
			}
		}
	} else {
		/*
		 * No se podr� ingresar una una fecha real sin tener una fecha planeada.
		 */
		if ($bug->date_year_real_791 > 0 && $bug->date_mounth_real_791 > 0
		&& $bug->date_day_real_791 > 0) {
			trigger_error(lang_get('error_real_sin_planeada'),ERROR);
		}
		/*
		 * No se podr� ingresar una fecha de devoluci�n sin tener una fecha planeadaa.
		 */
		if ($bug->date_year_return_791 > 0 && $bug->date_mounth_return_791 > 0
		&& $bug->date_day_return_791 > 0) {
			trigger_error(lang_get('error_devolucion_sin_planeada'),ERROR);
		}
		/*
		 * No se puede tener una causa de devoluci�n si no se tiene una
		 * fecha planeada
		 */
		if (!is_blank($bug->cause_return_791)) {
			trigger_error((lang_get('error_causa_sin_planeada')),ERROR);
		}
			
	}
}

/**
 *Requerimiento 795.
 *En este m�todo se van determinar si las fechas de planeaci�n, real y
 *de devoluci�n, al igual que la causa de devoluci�n cumplen con las
 *condiciones necesarias para el estado en el que se encuentra la entrega.
 *
 *De no estar alguno de lo datos, mencionados anteriomente, en un estado
 *o formato adecuado, se mostrar� un error en pantalla.
 * @param $bug Entrega que vamos a analizar.
 */
function validar_estados_con_fechas($bug) {
	$desarrollo = ((int)config_get('status_Desarrollo_791'));
	switch ($bug->status){
		case $desarrollo:
			/*
			 * Cuando el estado de la entrega esta en "Desarrollo"
			 * La fecha real y fecha de devoluci�n debe estar en ceros (0),
			 * al igual que la causa de la devoluci�n que deber� estar vacia.
			 * La fecha planeada podr� estar en cero (0) o tener un valor.
			 */
			if ($bug->date_year_real_791 != 0 || $bug->date_year_return_791 !=0
			|| is_blank($bug->cause_return_791) == false) {
				trigger_error(lang_get('error_estado_desarrollo'),ERROR);
			}
			break;
		case ((int)config_get('status_Entregado_791')):
			/*
			 * Cuando el estado de la entrega esta en "Entregado"
			 * la fecha planeada y la fecha real deber� ser mayor a cero (0),
			 * y la fecha de devoluci�n deber� estar en ceros(0). Adem�s la causa
			 * de devoluci�n deber� estar vacia.
			 */
			if ($bug->date_year_planned_791 == 0 || $bug->date_year_real_791 ==0
			|| $bug->date_year_return_791 !=0 || is_blank($bug->cause_return_791) == false) {
				trigger_error(lang_get('error_estado_entregado'),ERROR);
			}
			break;
		case ((int)config_get('status_Ajsutes_791')):
			/*
			 * Cuando el estado de la entrega esta en "Ajustes"
			 * la fecha planeada, real y de devoluci�n deber�n ser superiores a
			 * cero (0). Adem�s la causa de devoluci�n no podr� estar vacia.
			 */
			if ($bug->date_year_planned_791 == 0 || $bug->date_year_real_791 == 0 ||
			$bug->date_year_return_791 ==0 || is_blank($bug->cause_return_791) == true) {
				trigger_error(lang_get('error_estado_ajustes'),ERROR);
			}
			break;
		case ((int)config_get('status_Aprobado_791')):
			/*
			 * Cuando el estado de la entrega esta en "Aprobado"
			 * la fecha de planeaci�n y la fecha real no podr�n estar en cero (0),
			 * y la fecha de devoluci�n deber� estar en cero(0), al igual que
			 * la causa de la devoluci�n deber� estar vacia.
			 */
			if ($bug->date_year_planned_791 == 0 || $bug->date_year_real_791 ==0
			|| $bug->date_year_return_791 !=0 || is_blank($bug->cause_return_791) == false) {
				trigger_error(lang_get('error_estado_aprobado'),ERROR);
			}
			break;

		default:
			/*
			 * Se mostrar� un error indicando que el estado no existe para el
			 * entregable.
			 */
			trigger_error(lang_get('error_sin_estado'),ERROR);
			break;
	}
}
	
	/**
	 * Requerimiento 804.
	 * Este m�todo permite obtener las incidencias que se van a mostrar en el 
	 * informe del tiempo en que tarda una incidencia desde que es asignada 
	 * hasta que es resulta definitivamente.
	 * @param $project_id
	 * @param $dia_inicio
	 * @param $mes_inicio
	 * @param $anio_inicio
	 * @param $dia_fin
	 * @param $mes_fin
	 * @param $anio_fin
	 */
	function get_incidencias_informe_proteccion($project_id, $dia_inicio, $mes_inicio, 
		$anio_inicio, $dia_fin, $mes_fin, $anio_fin) {
		#para generar el informe filtramos las incidencias del proyecto en el
		#rango de fechas dado, para empezar a quitar las incidencias que no
		#apliquen en el informe.		
		$incidencias = get_incidencias_entre_fechas($project_id, $dia_inicio, $mes_inicio, $anio_inicio, $dia_fin, $mes_fin, $anio_fin);
		#Si no se obtienen resultado de incidencias para el proyecto en el rango 
		#de fechas establecido para el proyecto, retornaremos null.
		if ($incidencias == null) {
			return null;
		}
		#Antes de retornar las incidencias vamos a filtrarlas por las que 
		#cumplen con las condiciones para estar en el reporte
		return filtrar_incidencia($incidencias);
	}
	
	
	/**
	 * Requerimiento 804
	 * Modificado por Requerimiento 815
	 * M�todo que obtiene las incidencias en un rango determinado de fechas.
	 * @param $project_id
	 * @param $dia_inicio
	 * @param $mes_inicio
	 * @param $anio_inicio
	 * @param $dia_fin
	 * @param $mes_fin
	 * @param $anio_fin
	 */
	function get_incidencias_entre_fechas($project_id, $dia_inicio, $mes_inicio, $anio_inicio, $dia_fin, $mes_fin, $anio_fin){
		#Tabla en la que se almacenan las incidencias.
		$table_bug = db_get_table('bug');
		#Consulta que obtiene el id, la severidad, el estado y la resoluci�n 
		#de las incidencias para el proyecto que llega al m�todo en un rango
		#de fechas determida.
		#jatellez 946
		#dbetancourt cambio Diana Ni�o
		
		$query = "SELECT id, 
					severity,
					status,
					resolution,
					reporter_id,
					handler_id,
					category_id					
				FROM mantis_bug_table
				WHERE 	project_id = " . db_param() . "
					AND DATE_FORMAT(FROM_UNIXTIME(date_submitted),'%Y-%m-%d:%H:%i') 
						BETWEEN 
							DATE_FORMAT(STR_TO_DATE(" . db_param() . ", '%Y-%m-%d:%H:%i'),'%Y-%m-%d:%H:%i') 
							AND 
							DATE_FORMAT(STR_TO_DATE(" . db_param() . ", '%Y-%m-%d:%H:%i'),'%Y-%m-%d:%H:%i')";
		#Organizamos la fecha de inicio, concatenando el a�o el mes y el d�a de inicio.
		$fecha_inicio = string_display_line( get_enum_element('date_year_791',$anio_inicio )). '-' .
			string_display_line( get_enum_element('date_mounth_791',$mes_inicio )).  '-' .
			string_display_line( get_enum_element('date_day_791',$dia_inicio ));
		#Organizamos la fecha fin, concatenando el a�o el mes y el d�a fin.	
		$fecha_fin = string_display_line( get_enum_element('date_year_791',$anio_fin )).  '-' .
			string_display_line( get_enum_element('date_mounth_791',$mes_fin )).  '-' .
			string_display_line( get_enum_element('date_day_791',$dia_fin ));
		#Requerimiento 815
		#Agregamos a la fecha inicio que sea desde la hora 0 e indicamos en la fecha
		#fin que tome solo hasta la �ltima hora laboral del d�a fin.
		$fecha_inicio = $fecha_inicio . ':00:00';
		$fecha_fin = $fecha_fin . ':' . config_get('hora_17') . ':00';
		#Ejecutamos la consulta y pasamos los parametros: proyecto y rango de fechas.
		$result = db_query($query, Array($project_id, $fecha_inicio, $fecha_fin));
		$count = db_num_rows( $result );
		#Si la consulta no tiene datos, salimos del m�todo.
		if ($count == 0) {
			return null;
		}
		$bug = array();
		# Recorremos los resultados de la consulta.
		for( $i = 0; $i < $count; $i++ ) {
			# Obtenemos linea por lina los resultados arrojados de la consulta
			$t_row = db_fetch_array( $result );
			# Obtenemos los valores de las columnas.
			$bug[$i]['id'] = $t_row['id'];
			$bug[$i]['severity'] = $t_row['severity'];
			$bug[$i]['status'] = $t_row['status'];
			$bug[$i]['resolution'] = $t_row['resolution'];
			#jatellez 946
			$bug[$i]['reporter_id'] = $t_row['reporter_id'];
			$bug[$i]['handler_id'] = $t_row['handler_id'];
			#dbetancourt cambio Diana Ni�o
			$bug[$i]['category_id'] = $t_row['category_id'];
		}
		#Retornamos las incidencias en el rango de fechas determinado.
		return $bug;
	}
	
	
	/**
	 * Rquerimiento 804.
	 * M�todo que permite filtar las incidencias que no cumplen los requisitos 
	 * para estar en el informe de tiempos en resolver incidencias. Adem�s para 
	 * las incidenicas que cumplan los requisitos, se les calcula y busca los 
	 * campos necesarios para completar el informe.
	 * @param $incidencias
	 */
	function filtrar_incidencia($incidencias) {
		#Obetenemos solamente las incidencias que fueron asignadas alguna
		#vez al usuario eleg�do.
		#jhlc
		$incidencias = incidencias_asigandas_usuario_elegido($incidencias);
		#Obtenemos las incidencias con los campos personalizados de cada una.
		$incidencias = incidencias_con_campos_personalizados($incidencias);
		#Obtenemos las incidencias con la fecha en que se asigno la incidencia 
		#al usuario eleg�do.
		$incidencias = fechas_asignacion($incidencias);
		#Obtenemos las incidencias con la fecha en que se resolvi� la incidencia.
		$incidencias = fechas_resolvio($incidencias);
		#Obtenemos las incidencias con el tiempo de atenci�n por parte del HBT.
		$incidencias = tiempo_atencion($incidencias);
		#Retornamos las incidencias.
		return $incidencias;
	}
	
	
	/**
	 * Requerimiento 804.
	 * M�todo que permite eliminar las incidencias que no han sido asignadas
	 * al usuario eleg�do en alg�n momento de la historia de la incidencia.
	 * @param $incidencias
	 */
	function incidencias_asigandas_usuario_elegido ($incidencias) {
		#Contamos la cantidad de incidencias que llegan al m�todo.
		$t_row_count = count( $incidencias );
		$historial = array();
		$contador_historial = 0;
		$contador_no_asignadas = 0;
		$bug_no_asignadas = array();
		#recorremos las incidencias para ir consultando el historial de cada una.
		for( $i = 0; $i < $t_row_count; $i++ ) {
			#Obtenemos la incidencia en la posici�n i
			$incidencia = $incidencias[$i];
			#consultamos el historial de la incidencia y lo almacenamos.
			 $historial_temp = get_historial_incidenca_asignada($incidencia);
			 #si el resultado es diferente de null, la incidencia fue asignada
			 #al usuario eleg�do.
			 if ($historial_temp != null) {
			 	#guardamos el historial en la incidencia.
			 	$incidencias[$i]['historial'] = $historial_temp;
			 	$contador_historial ++;
			 } else {
			 	#almacenamos la posici�n de la incidencia para eliminarla del informe.
			 	$bug_no_asignadas[$contador_no_asignadas] = $i;
			 	$contador_no_asignadas ++;
			 }
		}		
		#Vamos eliminar las posiciones que se almacenaron en el array de las incidencias
		#no asignadas.
		for( $j = 0; $j < ($contador_no_asignadas); $j++ ) {
			$bug_no = $bug_no_asignadas[$j];
			unset($incidencias[$bug_no]);				
		}
		#re-indexamos el array.
		$incidencias = array_values($incidencias);
		#retornamos las incidencias nuevamente reordenadas.
		return $incidencias;
	}
	
	
	/**
	 * Requerimiento 804.
	 * En este m�todo se obtiene el historial de una incidencia. Adem�s se valida
	 * que en alg�n momento haya sido asignada al usuario eleg�do, de lo contrar�o 
	 * se retornar� null, para indicar que esta incidencia no fue asignada a 
	 * el usuario eleg�do, y por ende no se tomar� en cuenta para el informe
	 * de tiempo en resolver una incidencia.
	 * @param $incidencia incidencia a la cual se le va a buscar el historial.
	 */
	function get_historial_incidenca_asignada ($incidencia) {
		#tabla en del historial de las incidencias.
		$history = db_get_table('bug_history');
		#consulta para obtener el historial de las incidencias.
		$query = "SELECT his.date_modified, 
					his.user_id, his.field_name, his.old_value, his.new_value, 
					his.bug_id
				FROM mantis_bug_history_table his
				WHERE his.bug_id = " . db_param() . " 
					AND (	
						(his.field_name =  'handler_id')
						OR
						(his.field_name =  'status' AND 
							(his.new_value = 20 OR his.new_value = 30 
							OR his.new_value = 50 OR his.new_value = 80
							OR his.new_value = 90))		
					)	
				ORDER BY (DATE_FORMAT(FROM_UNIXTIME(his.date_modified),'%Y-%m-%d %H:%i')) ASC";
		#Ejecutamos la consulta y enviamos el id de la incidencia.
		$result = db_query($query, Array($incidencia['id']));
		#Contamos la cantidad de filas que tiene la consulta.
		$count = db_num_rows( $result );
		#Declaramos el array donde se almacenar�n los logs que conforman 
		#el historial de la incidencia.
		$history_bug = array();
		#Recorremos el historial obtenidoi por la consulta.
		for ( $i = 0; $i < $count; $i++ ) {
			#Obtenemos linea por lina los resultados arrojados de la consulta
			$t_row = db_fetch_array( $result );
			#Guardamos cada valor obtenido de la consulta en el array 
			#del historial.
			#Primero pasamos el timestamp a un formato date.
			$t_normal_date_format = config_get( 'normal_date_format' );	
			$history_bug[$i]['fecha'] = date( $t_normal_date_format, $t_row['date_modified'] );
			$history_bug[$i]['usuario'] = $t_row['user_id'];
			$history_bug[$i]['nombre_campo'] = $t_row['field_name'];
			$history_bug[$i]['old_value'] = $t_row['old_value'];
			$history_bug[$i]['new_value'] = $t_row['new_value'];
			$history_bug[$i]['bug_id'] = $t_row['bug_id'];			
		}
		#recorremos el historial.
		for( $k = 0; $k < $count; $k++ ) {
			$history = $history_bug[$k];
			#buscamos el campo asignado a.
			if ($history['nombre_campo'] == config_get('asignada_a')) {
				# verificamos que este asignado a el usuario eleg�do.
				#jhlcif ($history['new_value'] == config_get('usuario_proteccion_informe')|| $history['new_value'] == config_get('usuario_incidencias_proteccion_informe')) {
					#retornamos el historial de la entrega.
					return $history_bug;
				#jhlc}
			}
		}
		# retornamos null en caso que nunca se haya asigando la incidencia al 
		#usuario eleg�do.
		return null; 
	}
	
	
	/**
	 * Requerimiento 804.
	 * M�todo que obtiene el valor de los campos personalizados de las incidencias
	 * que llegan al m�todo.
	 * @param $incidencias
	 */
	function incidencias_con_campos_personalizados ($incidencias) {
		#Obtenemos el tama�o del arreglo.
		$tamano = count($incidencias);
		#Recorremos el arreglo.
		for ($i = 0; $i < $tamano; $i++) {
			#Obtenemos la incidencia en la posici�n i
			$incidencia = $incidencias[$i];
			#Obtenemos los valores de los campos personalizados y los almacenamos
			#en el array de incidencias que llega al m�todo.
			$incidencias[$i]['informe_tipo_incidencia'] = 
				get_valor_campo_personalizado($incidencia['id'], 
				config_get('informe_tipo_incidencia'));
			$incidencias[$i]['informe_naturaleza'] = 
				get_valor_campo_personalizado($incidencia['id'], 
				config_get('informe_naturaleza'));
			$incidencias[$i]['informe_entrega'] = 
				get_valor_campo_personalizado($incidencia['id'], 
				config_get('informe_entrega'));
			$incidencias[$i]['informe_iteracion'] =
				get_valor_campo_personalizado($incidencia['id'], 
				config_get('informe_iteracion'));
			$incidencias[$i]['informe_resonsable_inyeccion'] = 
				get_valor_campo_personalizado($incidencia['id'], 
				config_get('informe_resonsable_inyeccion'));
			$incidencias[$i]['informe_fuente'] = 
				get_valor_campo_personalizado($incidencia['id'], 
				config_get('informe_fuente'));
			$incidencias[$i]['informe_modulo_funcional'] = 
				get_valor_campo_personalizado($incidencia['id'], 
				config_get('informe_modulo_funcional'));
			#jatellez 946.. se agreg� el campo personalizado informe_casos_prueba_frenados
			#para obtener su valor de la bd
			$incidencias[$i]['informe_casos_prueba_frenados'] = 
				get_valor_campo_personalizado($incidencia['id'], 
				config_get('informe_casos_prueba_frenados'));			
		}
		#retornamos las incidencias con los valores de los campos personalizados.
		return $incidencias;
	}
	
	
	/**
	 * Requerimiento 804
	 * Este m�todo se utiliza para obtener la fecha de asignaci�n. Para obtener
	 * esta fecha se busaca la fecha en que la incidencia fue asiganada al 
	 * usuario eleg�do.
	 * @param $incidencias array de incidencias.
	 */
	function fechas_asignacion($incidencias) {
		#Contamos la cantidad de incidencias que llegan al m�todo.
		$count = count( $incidencias );		
		#recorremos las incidencias para ir consultando el historial de cada una.
		for( $i = 0; $i < $count; $i++ ) {
			#Obtenemos la incidencia en la posici�n i
			$incidencia = $incidencias[$i];
			#contamos las historias de la incidencia
			$count_his = count($incidencia['historial']);
			#recorremos el arreglo de historias de la incidencia
			for( $j = 0; $j < $count_his; $j++ ) {
				#Obtenemos la historia en la posici�n i
				$history = $incidencia['historial'][$j];
				if ($history['nombre_campo'] == config_get('asignada_a')) {
					# verificamos que este asignado a el usuario eleg�do.
					#jhlc if ($history['new_value'] == config_get('usuario_proteccion_informe')	|| $history ['new_value'] == config_get('usuario_incidencias_proteccion_informe')) {
						$incidencias[$i]['FechaAsig'] = $history['fecha'];
						$j = $count_his;
					#jhlc}
				}
			}
		}
		return $incidencias;		
	}
	
	
	/**
	 * Requerimiento 804.
	 * M�todo que obtiene la fecha en que se resolvieron las incidencias.
	 * Para obtener esta fecha tomamos la �ltima cuando:
	 * 1. La incidencia es de tipo error y la resoluci�n es correg�da
	 * se paso a un estado resuelta.
	 * 2. La incidencia es de tipo error y la resoluci�n es cualquiera que
	 * paso a estado resuelta o se necesitan m�s datos.
	 * 3. La incidencia que no es de tipo error y la resoluci�n es cualquiera que
	 * paso a esta resuelta o se necesitan m�s datos.
	 * @param unknown_type $incidencias
	 */
	function fechas_resolvio($incidencias) {
		#Contamos la cantidad de incidencias que llegan al m�todo.
		$count = count( $incidencias );		
		#recorremos las incidencias.
		for( $i = 0; $i < $count; $i++ ) {
			#Obtenemos la incidencia en la posici�n i
			$incidencia = $incidencias[$i];
			#Para obtener la fecha en que se resolvi�, vamos a tener en cuenta 3 casos:
			# 1. La incidencia es de tipo error y la resoluci�n es correg�da
			# 2. La incidencia es de tipo error y la resoluci�n es cualquiera.
			# 3. La incidencia no es de tipo error y la resoluci�n es cualquiera.
			#Preguntamos si al incidencia es de tipo error.
			if ($incidencia['informe_tipo_incidencia'] == config_get('tipo_incidencia_informe')) {
				#Preguntamos si al incidencia tiene una resoluci�n resulta.
				if ($incidencia['resolution'] == config_get('resolucion_informe')) {
					#La fecha resolvi� es la �ltima fecha en que se paso a estado resulto.
					$incidencias[$i]['FechaRsolv'] = 
						get_ultima_fecha_estado_resuelto($incidencia['historial']);
				} else {
					#La fecha resolvi� es la �ltima fecha en que se paso a estado 
					#resuelta o se necesitan m�s datos.
					$incidencias[$i]['FechaRsolv'] =
						get_ultima_fecha_estado_resuelto_o_se_necesitan_mas_datos($incidencia['historial']);
				}
			} else {
				#La fecha resolvi� es la �ltima fecha en que se paso a estado 
				#resuelta o se necesitan m�s datos.
				$incidencias[$i]['FechaRsolv'] =
						get_ultima_fecha_estado_resuelto_o_se_necesitan_mas_datos($incidencia['historial']);
			}			
			#Rqto_970 - ayoung
			#Validamos en este punto, que si la fecha no se pudo obtener es por que no se ha llevado la incidencia a resuelta o necesitan m�s datos
			#con usuarios HBT.
			#Se valida que obtenga la posible fecha de un posible estado cambiado a cerrada por el cliente
			if ($incidencias[$i]['FechaRsolv'] == NULL){
				$incidencias[$i]['FechaRsolv'] =
						get_ultima_fecha_estado_cerrada($incidencia['historial']);
			}
			#Fin Rqto_970 - ayoung
		}
		#Retornamos nuevamente las incidencias con el nuevo campo.
		return $incidencias;
	}
	
	
	/**
	 * Requerimiento 804.
	 * M�todo que permite obtener la �ltima fecha en que una incidencia paso a 
	 * estado resuelto por una persona de HBT.
	 * @param $historial historial de la incidencia.
	 */
	function get_ultima_fecha_estado_resuelto($historial) {
		#obtenemos el tama�o del array
		$count_his = count($historial);
		$fecha_resuleta = '';
		#recorremos el arreglo de historias de la incidencia
		for( $j = 0; $j < $count_his; $j++ ) {
			#Obtenemos la historia en la posici�n i
			$history = $historial[$j];
			#Verificamos que el campo modificado sea estado.
			if ($history['nombre_campo'] == config_get('estado')) {
				#verificamos que el nuevo valor sea resuelto.
				if ($history['new_value'] == config_get('estado_resuelto')) {
					#Ahora verificamos que el cambio lo haya echo una persona 
					#de HBT y no un usuario tipo cliente (MD5)
					$tipo_usuario = get_tipo_usuario($history['usuario']);
					if ($tipo_usuario['acceso'] == config_get('usuario_LDAP')) {
						#Obtenemos la fecha.
						$fecha_resuleta = $history['fecha'];
					}
				}
			}
		}
		#Retornamos la fecha obtenida del historial.
		return $fecha_resuleta;
	}
	
	
	/**
	 * Requerimiento 804.
	 * M�todo que permite obtener la �ltima fecha en que una incidencia paso a 
	 * estado resuelto o a estado se necesitam m�s datos, por una persona de HBT.
	 * @param $historial historial de la incidencia.
	 */
	function get_ultima_fecha_estado_resuelto_o_se_necesitan_mas_datos($historial) {
		#obtenemos el tama�o del array
		$count_his = count($historial);
		$fecha_resuleta = '';
		#recorremos el arreglo de historias de la incidencia
		for( $j = 0; $j < $count_his; $j++ ) {
			#Obtenemos la historia en la posici�n i
			$history = $historial[$j];
			#Verificamos que el campo modificado sea estado.
			if ($history['nombre_campo'] == config_get('estado')) {
				#verificamos que el nuevo valor sea resuelto o se necesitan m�s datos.
				if ($history['new_value'] == config_get('estado_resuelto')
					||$history['new_value'] == config_get('estado_se_necesitan_mas_datos') ) {
					#Ahora verificamos que el cambio lo haya echo una persona 
					#de HBT y no un usuario tipo cliente (MD5)
					$tipo_usuario = get_tipo_usuario($history['usuario']);
					if ($tipo_usuario['acceso'] == config_get('usuario_LDAP')) {
						#Obtenemos la fecha.
						$fecha_resuleta = $history['fecha'];
					}
				}
			}
		}
		#Retornamos la fecha obtenida del historial.
		return $fecha_resuleta;
	}
	
	/**
	 * Requerimientoo 804.
	 * M�todo que permite obtener el tipo de acceso de un usuario.
	 * @param $usuario id del usuario.
	 * @return 1 si el usuario pertenece a LDAP.
	 * 		   2 si el usuario es tipo cliente, autentificaci�n MD5
	 */
	function get_tipo_usuario ($usuario) {
		#Tabla donde se almacenan los usuarios.
	 	$tabla_usuario = db_get_table('user');
	 	#consulta para obtener el acceso de un usuario.
	 	$query = "SELECT acceso FROM $tabla_usuario WHERE id = " . db_param();
	 	#Ejecutamos la consulta y pasamos el parametro del id de usuarios.
	 	$result = db_query($query, Array($usuario));
	 	#retornamos el nivel de acceso del usuario.
	 	return $result->fields;
	 }
	 
	 
	 /**
	  * Requerimiento 804.
	  * M�todo que permite obtener el tiempo en que una incidencia es atendida por 
	  * el personal HBT. Para este procesoso vamos a tener en cuenta las fechas en 
	  * que se asingan, aceptan, resulven o se pasan a estado se necesitan m�s datos.
	  * @param $incidencias
	  */
	 function tiempo_atencion($incidencias) {
	 	#Contamos la cantidad de incidencias que llegan al m�todo.
		$count = count( $incidencias );		
		#recorremos las incidencias para ir consultando el historial de cada una.
		for( $i = 0; $i < $count; $i++ ) {
			#Obtenemos la incidencia en la posici�n i
			$incidencia = $incidencias[$i];
			#variables para almacenar el n�mero de horas y de minutos que se demora.
			$tiempo_hora = 0;
			$tiempo_minuto = 0;		
			#variables para almacenar la fecha en que iniciamos la atenci�n de una incidencia
			# y fecha en que se termina nuestro compromiso con la incidencia.
			$fecha_inicio = '';
			$fecha_fin = '';
			#Varible que indica que no ha sido asignada. 
			$asignada = 0;
			#Contamos cuantos items de historial tiene la incidencia.
			$count_historial = count($incidencia['historial']);
			for( $j = 0; $j < $count_historial; $j++ ) {
				#Obtenemos la incidencia en la posici�n i
				$history = $incidencia['historial'][$j];
				
				#Inicialmente buscamos la primera vez que la incidencia es asignada
				#nuestro usuario eleg�do, para tomar esa fecha como la inicial.
				if($asignada == 0 && $fecha_inicio == '') {
					if ($history['nombre_campo'] == config_get('asignada_a')) {
						# verificamos que este asignado a el usuario eleg�do.
						#jhlc if ($history['new_value'] == config_get('usuario_proteccion_informe') || $history['new_value'] == config_get('usuario_incidencias_proteccion_informe')) {
							#tomamos la fecha en que se dio el suceso para representar la fecha de inicio
							$fecha_inicio = $history['fecha'];
							#Ahora indicamos que la incidencia ya fue asignada.
							$asignada ++;
						#jhlc }
					}
				} else {
					#Si ya tenemos fecha inicial pero no tenemos la fecha final, entramos ac�
					if ($fecha_fin == '' && $fecha_inicio != '') {
						#Si el campo que se modific� fue el estado.
						if ($history['nombre_campo'] == config_get('estado')) {
							# verificamos que este asignado a el usuario eleg�do.
							if ($history['new_value'] == config_get('estado_se_necesitan_mas_datos')
								|| $history['new_value'] == config_get('estado_resuelto')) {
								#Ahora verificamos que el cambio lo haya echo una persona 
								#de HBT y no un usuario tipo cliente (MD5)
								$tipo_usuario = get_tipo_usuario($history['usuario']);
								if ($tipo_usuario['acceso'] == config_get('usuario_LDAP')) {
									#tomamos la fecha en que se dio el suceso para representar la fecha fin
									$fecha_fin = $history['fecha'];
									#ahora calculamos cuantas horas hay entre las dos fechas.
									$tiempo_total = horas_entre_fechas($fecha_inicio, $fecha_fin);
									#Obtenemos la hora y los minutos.
									$tiempo_hora += $tiempo_total['hora'];
									$tiempo_minuto += $tiempo_total['minuto'];
									#Inicializamos las dos fechas.
									$fecha_inicio = '';
									$fecha_fin = '';
								}
							}	
						} 						
							
					} else {
						#Si ambas fechas esta vacias, volvemos a buscar la fecha inicial.
						if ($fecha_fin == '' && $fecha_inicio == '') {
							#Si el campo que se modific� fue el estado.
							if ($history['nombre_campo'] == config_get('estado')) {
								#tomaremos la fecha de inicio cuando la incidencia haya sido pasada
								#a un estado asignada o aceptada.
								if ($history['new_value'] == config_get('estado_asignada') ||
									$history['new_value'] == config_get('estado_aceptada')) {
										#tomamos la fecha en que se dio el suceso para 
										#representar la fecha de inicio
										$fecha_inicio = $history['fecha'];
								}	
							}
						} else {
							#Si ambas fechas no estan vac�as, calculamos el tiempo entre las fechas
							$tiempo_total = horas_entre_fechas($fecha_inicio, $fecha_fin);
							#Obtenemos la hora y los minutos.
							$tiempo_hora += $tiempo_total['hora'];
							$tiempo_minuto += $tiempo_total['minuto'];
							#Inicializamos las dos fechas.
							$fecha_inicio = '';
							$fecha_fin = '';
						}
					}
					#Si el estado que se modific� fue la asignaci�n.
					if ($history['nombre_campo'] == config_get('asignada_a')) {
						#Si la asignaci�n fue a otro usuario no asociado a HBT, indicamos que
						#hasta este punto la incidencia estuvo a cargo de HBT.
						$tipo_usuario = get_tipo_usuario($history['new_value']);
						if ($tipo_usuario['acceso'] != config_get('usuario_LDAP')) {
							#Si la fecha de inicio no contiene un valor y el usuarios asignado
							#es diferente a nuestro usuario eleg�do.
							#jhlc if ($fecha_inicio != '' && $history['new_value'] != config_get('usuario_proteccion_informe') && $history['new_value'] !=config_get('usuario_incidencias_proteccion_informe')) {
								#tomamos la fecha en que se dio el suceso para representar la fecha fin
								$fecha_fin = $history['fecha'];
								#ahora calculamos cuantas tiempo hay entre las dos fechas.
								$tiempo_total = horas_entre_fechas($fecha_inicio, $fecha_fin);
								#Obtenemos las horas y los minutos
								$tiempo_hora += $tiempo_total['hora'];
								$tiempo_minuto += $tiempo_total['minuto'];
							#jhlc}
							# inicializamos las fechas.
							$fecha_inicio = '';
							$fecha_fin = '';
							#Indicamos que debemos volver a buscar cuando es asignado nuestro
							#usuario eleg�do a la incidencia.
							$asignada = 0;
						}
					}
				}
			}
			#Requerimiento 822
			
			#Si el c�lculo de tiempos en horas y minutos es cero
			if ($tiempo_hora==0 && $tiempo_minuto==0){
				#Requerimiento 843
				#se cuenta el historial
				$count_historial = count($incidencia['historial']);
				#se coloca la fecha de inicio vacia
				$fecha_inicio='';
				$f=0;
				$cerrada=0;
				$valor= $count_historial-1;
				#se itera para realizar el recorrido por el historial
				for( $f = 0; $f < $count_historial; $f++ ) {
					#se guarda el historial de la incidencia en la posici�n $f
					$history = $incidencia['historial'][$f];
					#se pregunta si la fecha de inicio esta vacia	
					if($fecha_inicio == ''){
						#se pregunta si el campo es asignada a.
						if ($history['nombre_campo'] == config_get('asignada_a')) {
							#se pregunta si el nuevo valor corresponde al del usuario de protecci�n.
							#jhlc if ($history['new_value']== config_get('usuario_proteccion_informe')|| $history['new_value'] == config_get('usuario_incidencias_proteccion_informe')){
								#Se asigna la fecha de inicio.	
								$fecha_inicio= $history['fecha'];
							#jhlc}

						}
					}
					#Se pregunta si la fecha de inicio es diferente a vacia y si la fecha fin esta vacia.
					if($fecha_inicio != '' && $fecha_fin == ''){
						#se pregunta si el nombre del cammpo es asignada a.	
						if($history['nombre_campo']== config_get('asignada_a')){
							#Si la asignaci�n fue a otro usuario no asociado a HBT, indicamos que
							#hasta este punto la incidencia estuvo a cargo de HBT.
							$tipo_usuario = get_tipo_usuario($history['new_value']);
							if ($tipo_usuario['acceso'] != config_get('usuario_LDAP')) {
								#Si la fecha de inicio no contiene un valor y el usuarios asignado
								#es diferente a nuestro usuario eleg�do.
								#jhlc if ($history['new_value'] != config_get('usuario_proteccion_informe') && $history['new_value'] != config_get('usuario_incidencias_proteccion_informe')){
									#tomamos la fecha en que se dio el suceso para representar la fecha fin
									$fecha_fin = $history['fecha'];
									#ahora calculamos cuantas tiempo hay entre las dos fechas.
									$tiempo_total = horas_entre_fechas($fecha_inicio, $fecha_fin);
									#Obtenemos las horas y los minutos
									$tiempo_hora += $tiempo_total['hora'];
									$tiempo_minuto += $tiempo_total['minuto'];
								#jhlc }
								#inicializamos las fechas.
								$fecha_inicio = '';
								$fecha_fin = '';
								#Indicamos que debemos volver a buscar cuando es asignado nuestro
								#usuario eleg�do a la incidencia.
								$asignada = 0;
							}
						}
							#se pregunta si el nombre del campo es el estado
							if($history['nombre_campo']== config_get('estado')){
								#se pregunta si el nuevo valor es cerrado	
								if($history['new_value']== config_get('estado_cerrada')){
									#Se asigna el valor a la fecha fin
									$fecha_fin= $history['fecha'];
									#Se calcula el tiempo total entre fechas.
									$tiempo_total = horas_entre_fechas($fecha_inicio, $fecha_fin);
									#Obtenemos las horas y los minutos
									$tiempo_hora += $tiempo_total['hora'];
									$tiempo_minuto += $tiempo_total['minuto'];
									#inicializamos las fechas.
									$fecha_inicio = '';
									$fecha_fin = '';
									#Indicamos que debemos volver a buscar cuando es asignado nuestro
									#usuario eleg�do a la incidencia.
									$asignada = 0;
									$cerrada++;
							}
						}
					}if($f ==$valor && $fecha_fin=='' && $fecha_inicio !='' && $cerrada==0){

						$dia_fin= gpc_get_string('dia_fin',config_get( 'date_day_791_enum_string' ));
						#Se captura el mes fin que se ingresa para generar el reporte
						$mes_fin= gpc_get_string('mes_fin',config_get( 'date_mounth_791_enum_string' ));
						#Se captura el a�o fin que se ingresa para generar el reporte
						$anio_fin= gpc_get_string('anio_fin',config_get( 'date_year_791_enum_string' ));
						#Se captura el dia de inicio en que se asigna la incidencia
						$dia_inicio = substr($fecha_inicio,-8, 2);
						#Se captura el mes de inicio en que se asigna la incidencia
						$mes_inicio = substr($fecha_inicio,-11, 2);
						#Se captura el a�o de inicio en que se asigna la incidencia
						$anio_inicio = substr($fecha_inicio,-14, 2);
							
						#si el a�o de inicio es mayor al fin se asignan los tiempos en cero.
						if($anio_inicio > $anio_fin){
							$tiempo_hora=0;
							$tiempo_minuto=0;
						#si el a�o de inicio es igual al fin pero el mes inicio es mayor al fin se asignan los tiempos en cero.	
						}else if($anio_fin== $anio_inicio && $mes_inicio>$mes_fin){
							
							$tiempo_hora=0;
							$tiempo_minuto=0;
						#si el a�o de inicio es igual al fin y el mes inicio es igual al mes fin, pero el dia de inicio es mayor se asignan los tiempos en cero.
						}else if ($anio_fin== $anio_inicio && $mes_inicio==$mes_fin && $dia_inicio>$dia_fin){
							
							$tiempo_hora=0;
							$tiempo_minuto=0;
							
						}else{
							#Se concatena el dia el mes el a�o y la fecha
							$fecha_f= get_enum_element( 'date_year_791', $anio_fin ) .'-' . get_enum_element( 'date_mounth_791', $mes_fin ) . '-' . get_enum_element( 'date_day_791', $dia_fin ) . ' ' . config_get('hora_17') . ':00';
							#Se asigna el valor de la fecha_fin
							$fecha_fin=$fecha_f;
							#Se realiza la sumatoria de los tiempos con las fechas dadas.
							$tiempo_total = horas_entre_fechas($fecha_inicio, $fecha_fin);
							#Obtenemos las horas y los minutos
							$tiempo_hora += $tiempo_total['hora'];
							$tiempo_minuto += $tiempo_total['minuto'];
						}
					}
						
				}
			}
			#Fin Requerimiento 843
			#Fin Requerimiento 822
			
			#ahora vamos a convertir todos los minutos obtenidos a minutos hora,
			#no permitiendo que pasen de 60
			while ($tiempo_minuto >= 60) {
				$tiempo_minuto = $tiempo_minuto - 60;
				#Cada vez que resten minutos, se aumentar� una hora.
				$tiempo_hora ++;
			} 
			
			#Vamos a agregar el cero a la izquierda cuando los minutos sean de 1 a 9.
			$decimal = ($tiempo_minuto/10);
			#Obtenemos el primer n�mero de los minutos.
			$numero = (int)substr($decimal,0, 1);
			#Si el residuo es 0 se indica que es un n�mero de dos cifras
			if ($numero <=0) {
				$tiempo_minuto = '0'.$tiempo_minuto;
			}
			#Almacenamos en cada incidencia el tiempo de atenci�n
			#en formato Hora:Minuto.
			$incidencias[$i]['TiempoAtec'] = $tiempo_hora . ':'.$tiempo_minuto;
		}
		#retornamos las incidencias.
		return $incidencias;
	 }
	 
	 
	 /**
	  * Requerimiento 804.
	  * M�todo que permite obtener el n�mero de horas y minutos que hay entre dos 
	  * fechas, teniendo en cuenta que las horas laborables diarias son de 8 horas,
	  * el horario de atenci�n es de 08:00 AM a 12:00 M y de 13:00 PM a 17:00 PM,
	  * adem�s no se van a tener en cuenta los d�as festivos y no laborables, como 
	  * el d�a s�bado. 
	  * Cuando alguna hora este por fuera del rango de atenci�n, se acercar� al 
	  * n�mero m�s cercano, es decir, si la hora es 07:10 AM, se aproximar� a 
	  * 08:00 AM. Si la hora es 12:25M, se aproximar� a la 13:00PM. Si la hora es 
	  * 20:01, se aproximar� a 17:00PM
	  * @param $fecha_inicio
	  * @param $fecha_fin
	  */
	 function horas_entre_fechas($fecha_inicio, $fecha_fin) {
	 	#Inicializamos las variables que van a tener las horas y los minutos
	 	#de la atenci�n a la incidencia.
	 	$tiempo_hora = 0;
		$tiempo_minuto = 0;
		#Si la fecha fin esta vac�a.
	 	if ($fecha_fin == '') {
	 		$tiempo_total = array();
	 		#Indicamos que el tiempo total es de 0. 
	 		$tiempo_total['hora'] = $tiempo_hora;
	 		$tiempo_total['minuto'] = $tiempo_minuto;
	 		#retornamos el resultado.
	 		return $tiempo_total;
	 	}
	 	#Vamos a calcular el n�mero de d�as entre las dos fechas.
	 	$dias_diferencia = dias_diferencia_fechas_resolvio_asignacion(substr($fecha_inicio,-16, 10), 
	 		substr($fecha_fin, -16, 10));
	 		
		#Verificamos que la hora y los minutos de inicio esten en el horario laboral.
		$tiempos_laborables_inicio =
			horas_en_horario_laboral(substr($fecha_inicio, -5, 2), substr($fecha_inicio, -2, 2));
		#Obtenemos la hora y los minutos corrrectos, seg�n el horario laboral.
		$hora_inicio = $tiempos_laborables_inicio['hora'];
		$minuto_inicio = $tiempos_laborables_inicio['minutos'];

		#Verificamos que la hora y los minutos fin esten en el horario laboral.
		$tiempos_laborables_fin =
			horas_en_horario_laboral(substr($fecha_fin,-5, 2),substr($fecha_fin, -2, 2));
		#Obtenemos la hora y los minutos corrrectos, seg�n el horario laboral.
		$hora_fin = $tiempos_laborables_fin['hora'];
		$minuto_fin = $tiempos_laborables_fin['minutos'];

		#For para recorrer cada uno de los d�as entre las dos fechas.
		for ($dias_transcurridos = 0;  $dias_transcurridos <= $dias_diferencia; $dias_transcurridos ++) {			
			#Esta fecha quedar� con formato AAAA-MM-DD
			$fecha_actual = substr($fecha_inicio,-16, 10);
			#Preguntamos si la fecha actual m�s los d�as transcurridos es una fecha laborable.
			$laborable = dia_laborable(substr($fecha_actual, 0,4),
				substr($fecha_actual, 5,2),substr($fecha_actual, 8,2), $dias_transcurridos);
				#Si no es un d�a laborable
			if ($laborable == false) {
				#volvemos a ejecutar el for, porque los d�as no laborables
				#no se tendr�n en cuenta para el calculo.
				continue;
			}
			#Si los d�as que ha transcurrido es igual a los d�as de diferencia
			#entre las fechas de inicio y fin, es decir
			#estamos calculando en el �ltimo d�a de diferencia entre la fecha.
			#Para este caso tendremos en cuenta la hora fin.
			if ($dias_transcurridos == $dias_diferencia) {
				#Si hay d�as transcurridos, entonces contamos desde el incio
				#del d�a hasta la hora fin, es decir, la solicitud no inicio
				#este d�a, por lo cual podemos empezar desde el inicio de la
				#jornada.
				if ($dias_transcurridos > 0) {
					#Si la hora fin es en la ma�ana
					if ($hora_fin >= config_get('hora_8') && $hora_fin <= config_get('hora_12')) {
						#Restamos al tiempo fin la hora de inicio laboral.
						$tiempo_hora += $hora_fin - config_get('hora_8');
						#Si hay minutos transcurridos, los sumamos al tiempo.
						if ($minuto_fin > 0) {
							$tiempo_minuto += $minuto_fin;
						}
					} else {
						#Si la hora fin es en la tarde.
						#Sumamos el tiempo laboral de la ma�ana m�s el
						#tiempo entre la hora fin en que se resolvio y la
						#hora inicio de la jornada en la tarde.
						$tiempo_hora += (config_get('hora_12')- config_get('hora_8')) + ($hora_fin - config_get('hora_13'));
						#Registro de actividades
						if ($minuto_fin > 0) {
							$tiempo_minuto += $minuto_fin;
						}
					}
				} else {
					#En caso de no haber d�as transcurridos y los d�as transcurridos
					#sean iguales a los d�as de diferencia, es decir el tiempo de
					#inicio esta en el mismo d�a de del tiempo fin.

					#Si la hora de inicio es en la ma�ana.
					if ($hora_inicio >= config_get('hora_8') && $hora_inicio <= config_get('hora_12')) {
						#Si la hora fin es en la ma�ana.
						if ($hora_fin >= config_get('hora_8') && $hora_fin <= config_get('hora_12')) {
							#Si la hora inicio no tiene minutos, haces la resta
							#entre la hora fin y la hora inicio.
							if ($minuto_inicio == 0) {
								$tiempo_hora += $hora_fin - $hora_inicio;
								#Si la hora fin tiene minutos, entonces sumamos esos
								#minutos.
								if($minuto_fin > 0) {
									$tiempo_minuto += $minuto_fin;
								}
							} else {
								#Si la hora inicio tiene minutos, primero sumamos
								#los minutos que hay hasta la proxima hora.
								#Defecto: 49909
								#Al generar tener una hora inicio y fin en la misma hora reloj, hay 
								#que restar los minutos entre la hora.
								if ($hora_inicio == $hora_fin) {
									$tiempo_minuto += $minuto_fin - $minuto_inicio;										
								} else {
									$tiempo_minuto += (config_get('minuto_60') - $minuto_inicio);
									#Aumentamos la hora inicio en una unidad.
									$hora_inicio ++;
									#Si la hora inicio no a superado el medio d�a,
									#restamos a la hora fin la hora inicio.
									if ($hora_inicio < config_get('hora_12')) {
										$tiempo_hora += $hora_fin - $hora_inicio;
										#Si la hora fin tiene minutos, entonces sumamos esos
										#minutos.
										if($minuto_fin > 0) {
											$tiempo_minuto += $minuto_fin;
										}
									}
								}
							}
						} else {
							#Si la hora inicio es en la ma�ana y la hora
							#fin en la tarde, entonces:
							#Primero vamos a tomar el tiempo hasta medio d�a.
							#Si la hora inicio que esta en la ma�ana no tiene
							#minutos, entonces hacemos la resta de la hora fin
							#de la jornada en la ma�ana menos la hora de inicio.
							if ($minuto_inicio == 0) {
								$tiempo_hora += config_get('hora_12') - $hora_inicio;
							} else {
								#Si la hora de inicio tien minutos, entonces
								#vamos a tomar en tiempo de los minutos hasta la
								#pr�xima hora.
								$tiempo_minuto += (config_get('minuto_60') - $minuto_inicio);
								#Indicamos que ya llegamos a la siguiente hora.
								$hora_inicio ++;
								#Si la hora de inicio es menor a la hora fin de
								#la jornada en la ma�ana, restamos el tiempo entre
								#dicha hora y la hora inicio.
								if ($hora_inicio < config_get('hora_12')) {
									$tiempo_hora += config_get('hora_12') - $hora_inicio;
								}
							}
							#Una vez tengamos el tiempo transcurrido entre en la
							#ma�ana, ahora vamos a calcular el tiempo que ha
							#transcurrido en la tarde, hasta la hora fin.
							$tiempo_hora += $hora_fin - config_get('hora_13');
							#Si la hora fin tiene minutos, entonces sumamos los
							#minutos al tiempo.
							if ($minuto_fin > 0) {
								$tiempo_minuto += $minuto_fin;
							}
						}
					} else {
						#Si la hora de inicio es en la tarde, vamos a restar
						#el tiempo entre la hora fin y la hora inicio.
						#Si la hora inicio no tiene minutos, hacemos la resta
						#directa en entre la hora fin y la hora inicio.
						if ($minuto_inicio == 0) {
							$tiempo_hora += $hora_fin - $hora_inicio;
							#Si la hora fin tiene minutos, entonces sumamos
							#los minutos de la hora fin.
							if ($minuto_fin > 0) {
								$tiempo_minuto += $minuto_fin;
							}
						} else {
							#Si la hora de inicio si tiene minutos, entonces
							#haremos la resta entre la hora fin y la hora inicio
							#teniendo en cuenta los minutos iniciales.
							#Defecto: 49909.
							#Al generar tener una hora inicio y fin en la misma hora reloj, hay 
							#que restar los minutos entre la hora.
							if ($hora_inicio == $hora_fin) {
								$tiempo_minuto += $minuto_fin - $minuto_inicio;										
							} else {
								$tiempo_minuto += (config_get('minuto_60') - $minuto_inicio);
								#Indicamos que ya llegamos a la siguiente hora.
								$hora_inicio ++;
								#Si la hora de inicio es menor a la hora fin de
								#la jornada en la ma�ana, restamos el tiempo entre
								#dicha hora y la hora inicio.
								if ($hora_inicio < config_get('hora_17')) {
									$tiempo_hora += $hora_fin - $hora_inicio;
									#Si la hora fin tiene minutos, entonces sumamos esos
									#minutos.
									if($minuto_fin > 0) {
										$tiempo_minuto += $minuto_fin;
									}
								}
							}
						}
					}
				}
			} else {
				#Vamos a realizar los calculos hasta el fin del d�a, sin tener
				#en cuenta la hora de inicio
				#Si no han transcurrido d�as, vamos a tomar la hora de incio
				#hasta el fin del d�a, es decir, que no hemos tenido en cuenta
				#la hora inicio hasta este momento.
				if($dias_transcurridos == 0) {
					#Si la hora inicio es en la ma�ana.
					if ($hora_inicio >= config_get('hora_8') && $hora_inicio <= config_get('hora_12')) {
						#Si la hora inicio no tiene minutos, no se tendr�n
						#en cuenta, y haremos la resta entre la hora fin
						#y lahora inicio.
						if ($minuto_inicio == 0) {
							#tomaremos la resta entre la hora fin de la jornada
							#en la ma�ana y la hora inicio, m�s el tiempo total de la tarde.
							$tiempo_hora += (config_get('hora_12') - $hora_inicio) + (config_get('hora_17') - config_get('hora_13'));
						} else {
							#Si hay minutos en la hora inicio, sumaremos esos minutos
							$tiempo_minuto += (config_get('minuto_60') - $minuto_inicio);
							#aumentaremos la hora inicio en uno.
							$hora_inicio ++;
							#Si la hora inicio no super� el medio d�a, restamos
							#a la hora fin de la jornada en la ma�ana, la hora
							#de inicio.
							if ($hora_inicio < config_get('hora_12')) {
								$tiempo_hora += (config_get('hora_12') - $hora_inicio);
							}
							#Finalmente sumamos el tiempo entre la hora inicio
							#y la hora fin de la jornada en la tarde.
							$tiempo_hora += (config_get('hora_17') - config_get('hora_13'));
						}
					} else {
						#Si la hora de inicio es en la tarde, sumaremos el tiempo
						#hasta el final de la jornada.
						#Si la hora inicio no tiene minutos, restaremos la hora
						#fin de la jornada y la hora inicio.
						if ($minuto_inicio == 0) {
							$tiempo_hora += config_get('hora_17') - $hora_inicio;
						} else {
							#Si hay minutos en la hora inicio, sumaremos esos minutos.
							$tiempo_minuto += (config_get('minuto_60') - $minuto_inicio);
							#Aumentaremos la hora inicio en uno
							$hora_inicio ++;
							#Si la hora inicio no super� el fin de la tarde,
							#restaremos a la hora fin de la jornada en la tarde,
							#la hora de inicio.
							if ($hora_inicio < config_get('hora_17')) {
								$tiempo_hora += config_get('hora_17') - $hora_inicio;
							}
						}
					}
				} else {
					#Si hay d�as transcurridos y a�n no llegamos al d�a fin,
					#entonces sumaremos todas las horas del d�a.
					$tiempo_hora += (config_get('hora_12') - config_get('hora_8')) + (config_get('hora_17')- config_get('hora_13'));
				}
			}
		} 
		#Ahora vamos a guardar los valores en un arreglo.
		$tiempo_total = array();
		$tiempo_total['hora'] = $tiempo_hora;
		$tiempo_total['minuto'] = $tiempo_minuto;
		#Retornamos los tiempos.
	 	return $tiempo_total;
	 }
	 
	 
	 /**
	  * Requerimiento 804.
	  * M�todo que calcula el n�mero de d�as entre la fecha de asiganaci�n y la fecha
	  * en que finalmente se resuelve la incidencia.
	  * @param $incidencia
	  */
	 function dias_diferencia_fechas_resolvio_asignacion ($fecha_inicio, $fecha_fin){ 
	 	#Obtenemos el d�a, mes y a�o de la fecha inicio.
		$dia_inicio = substr($fecha_inicio,-2, 2);
		$mes_inicio = substr($fecha_inicio,-5, 2);
		$anio_inicio = substr($fecha_inicio,-10, 4);
		#convertimos los datos anteriores a un timestamp
		$timestamp_inicio = mktime(0,0,0,$mes_inicio,$dia_inicio,$anio_inicio);
		 
		#Obtenemos el d�a, mes y a�o de la fecha inicio.
		$dia_fin = substr($fecha_fin,-2, 2);
		$mes_fin = substr($fecha_fin,-5, 2);
		$anio_fin = substr($fecha_fin,-10, 4);
		#convertimos los datos anteriores a un timestamp
		$timestamp_fin = mktime(0,0,0,$mes_fin,$dia_fin,$anio_fin); 
		
		#Realizamos la resta entre las dos fecha timestamp, obteniendo los
		#segundos de diferencia entre ambas fechas.
		$segundos_diferencia = $timestamp_fin - $timestamp_inicio; 
		
		#Convertiremos los segundos en d�as, diviendiendo en 60 segundos de un minuto, 
		#por los 60 minutos de una hora, por las 24 horas de un d�a
		$dias_diferencia = $segundos_diferencia / (60 * 60 * 24);		
		//obtengo el valor absoulto de los d�as (quito el posible signo negativo)
		$dias_diferencia = abs($dias_diferencia);
		//quito los decimales a los d�as de diferencia
		$dias_diferencia = floor($dias_diferencia);
		return $dias_diferencia;
	 }
	 
	
	 /**
	  * Requerimiento 804.
	  * M�todo que permite aproximar la hora y los minutos cuando
	  * se pasan del horario laboral, de 08:00 AM a 12:00 M y de 13:00 PM a 17:00 PM.
	  * @param $hora
	  * @param $minutos
	  */
	 function horas_en_horario_laboral($hora, $minutos) {
	 	$tiempos = array();	 	
	 	#Si la hora es menos a 08:00 AM, se igualar� la hora a las 08:00 AM.
	 	if ($hora < 8) {
	 		#Si los minutos son mayores a cero se igualar�n a cero.
	 		if ($minutos > 0) {
	 			$minutos = 0;
	 		}
	 		#Indicamos que la hora son las 08:00 AM
	 		$hora = 8;
	 		$tiempos['minutos'] = $minutos;
	 		$tiempos['hora'] = $hora;
	 	} else {
	 		#Si la hora esta entre las 12:00 M y 13:00 PM, se igualar� la 
	 		#hora a las 13:00 PM.
	 		if ($hora >= 12 && $hora < 13) {
	 			#Si los minutos son mayores a cero se igualar�n a cero.
	 			if ($minutos > 0) {
	 				$minutos = 0;
	 			}
	 			#Indicamos que la hora son la 13:00 PM
	 			$hora = 13;
	 			$tiempos['minutos'] = $minutos;
	 			$tiempos['hora'] = $hora;
	 		} else {
	 			#Si la hora es mayor a 17:00 PM, se igualar� la hora a 
	 			#las 17:00 PM
	 			if ($hora >= 17) {
	 				#Si los minutos son mayores a cero se igualar�n a cero.
	 				if ($minutos > 0) {
	 					$minutos = 0;
	 				}
	 				#Indicamos que la hora son la 17:00 PM
	 				$hora = 17;
	 				$tiempos['minutos'] = $minutos;
	 				$tiempos['hora'] = $hora;
	 			} else {
	 				#Si la hora no sobrepasa el horario permitido, entonces
	 				#almacenmos la hora y los minutos tal y como llegaron al
	 				#m�todo
	 				$tiempos['hora'] = $hora;
	 				$tiempos['minutos'] = $minutos;
	 			}
	 		}
	 	}
	 	return $tiempos;
	 }
	 
	 
	 /**
	  * Requerimiento 804
	  * M�todo que valida si una fecha dada en a�o-mes-dia corresponde
	  * a una fecha que no es laborable.
	  * @param $year a�o de la fecha
	  * @param $mounth mes de la fecha
	  * @param $day d�a de la fecha
	  */
	 function dia_laborable ($anio, $mes, $dia, $aumento){
	 	#Tabla en la que se almacenan los d�as festivos de todos los a�os.
	 	$tabla_holiday = 'mantis_holiday_table';
	 	$fecha = $anio . ''. $mes . ''.  $dia;
	 	#En esta consulta determinamos si la fecha que llega al m�todo, corresponde
	 	#a un d�a no laborable
	 	$query = "SELECT holiday_desc FROM mantis_holiday_table
		WHERE holiday_date = (SELECT DATE_FORMAT(CAST(" . db_param() . " AS DATE),'%Y-%m-%d') + INTERVAL " . db_param() . " DAY)";
	 	#Ejectuamos la consulta y env�amos los valores.
	 	$result = db_query( $query, Array($fecha, $aumento));
	 	#Contamos cuantos registros arrojo la consulta
	 	$count = db_num_rows( $result );
	 	#Si encontramos que hay un registro que conincide con nuestra fecha
	 	#mostramos error por tratarse de un d�a festivo.
	 	if ($count > 0) {
	 		return false;
	 	}
	 	#Ahora obtenemos el d�a fin del mes en el que estamo trabajando, para saber
	 	#si se registro un d�a mayor al maximo del mes.
	 	$fin = string_display_line( get_enum_element('fin_mes_791',$mes ));
	 	#Si el mes en el cual estamos trabajando es Febrero (2) se va a
	 	#determinar si estamos en un a�o bisiesto o no (de 28 o 29 d�as).
	 	if ($mes == 2) {
	 		#Son bisiestos todos los a�os divisibles por 4, excluyendo los que
	 		#sean divisibles por 100, pero no los que sean divisibles por 400.
	 		if (($anio % 4 == 0) && (($anio % 100 != 0) || ($anio % 400 == 0))) {
	 			#A los 28 d�as del mes de Febrero aumentamos un d�a para el a�o
	 			#bisiesto
	 			$fin ++;
	 		}
	 	}
	 	#Si el d�a que se registro es mayor al m�ximo del mes mostraremos un
	 	#error indicando cual es el d�a m�ximo del mes de registro.
	 	if ($dia > $fin) {
	 		return false;
	 	}
	 	return true;
	 }
	
	
	/**
	 * Requerimiento 804.
	 * M�todo que retorna el valor que tiene el campo personalizado en una 
	 * incidencia en particular.	
	 * @param $id_bug id de la incidencia.
	 * @param $id_custom id del campo personalizado.
	 */
	function get_valor_campo_personalizado ($id_bug, $id_custom ) {
		#Tabla en la que se almacenan los valores de un campo personalizado
		#en cada una de las incidencias.
		$custom_string = db_get_table('custom_field_string');
		#buscamos el valor que tiene el campo personalizado en la incidencia
		#que llega al m�todo.
		$query = "SELECT value FROM $custom_string 
			WHERE field_id = " . db_param() . " AND bug_id = " . db_param();
		#Ejecutamos la consulta y enviamos los parametros de id del campo
		#personalizado y el id de la incidencia.
		$result = db_query($query, Array($id_custom, $id_bug));
		#En caso de no obtener un resultado, retornaremos vacio.
		if ($result->fields == false ) {
			return '';
		} else {
			#De lo contrario retornaremos el valor consultado.
			return $result->fields[value];
		}		
	}
	
	/**
	 * Requerimiento 808
	 * M�todo que permite obtener y filtrar las incidencias que se puden 
	 * visualizar en el informe de niveles de servicio.
	 * @param  $project_id
	 * @param  $dia_inicio
	 * @param  $mes_inicio
	 * @param  $anio_inicio
	 * @param  $dia_fin
	 * @param  $mes_fin
	 * @param  $anio_fin
	 * @param  $entrega
	 */
	function get_informe_niveles_de_servicio($project_id, $dia_inicio, 
		$mes_inicio, $anio_inicio, $dia_fin, $mes_fin, $anio_fin, $entrega ) {
			
		#Obtenemos las incidencias en el rago de fecha establecido.
		$incidencias = get_incidencias_entre_fechas_niveles_de_servicio($project_id, $dia_inicio, 
			$mes_inicio, $anio_inicio, $dia_fin, $mes_fin, $anio_fin, $entrega );
			
		#Obtenemos las incidencias con los campos personalizados de cada una.
		$incidencias = incidencias_con_campos_personalizados($incidencias);
		
		$incidencias = get_historial_incidencias($incidencias);
		
		#Obtenemos la fecha en que las incidencias fueron resueltas.
		$incidencias = fechas_resolvio_niveles_de_servicio($incidencias);
		
		return $incidencias;
	}
	
	/**
	 * Requerimiento 808.
	 * Este m�todo permite obtener las incidencias que son de tipo error, cuya fuente
	 * es pruebas,que estan en un rago de fechas determinada y todas pertencenen
	 * a una misma entrega, para un proyecto especifico.
	 * @param $project_id
	 * @param $dia_inicio
	 * @param $mes_inicio
	 * @param $anio_inicio
	 * @param $dia_fin
	 * @param $mes_fin
	 * @param $anio_fin
	 * @param $entrega
	 */
	function get_incidencias_entre_fechas_niveles_de_servicio($project_id, $dia_inicio, 
		$mes_inicio, $anio_inicio, $dia_fin, $mes_fin, $anio_fin, $entrega ) {
		#Tabla en la que se almacenan las incidencias.
		$table_bug = db_get_table('bug');
		#Tabla en la que se almacenan los valores de cada campo personalizado de
		#cada incidencia.
		$table_custom_field = db_get_table('custom_field_string');
		
		#Consulta que obtiene el id, la severidad, el estado, la resoluci�n y la fecha 
		#de las incidencias para el proyecto que llega al m�todo en un rango
		#de fechas determida, el tipo de incidencias es error, la fueten es 
		#pruebas y la entrega es la que llega al m�todo.
		$query = "SELECT id, 
					severity,
					status,
					resolution,
					DATE_FORMAT(FROM_UNIXTIME(date_submitted),'%Y-%m-%d') as fecha
				FROM (($table_bug mbt 
					join $table_custom_field mcfstTipo on mbt.id = mcfstTipo.bug_id)
					join $table_custom_field mcfstFuente on mbt.id = mcfstFuente.bug_id)
					join mantis_custom_field_string_table mcfstEntrega on mbt.id = mcfstEntrega.bug_id
				WHERE 	project_id = " . db_param() . "
					AND DATE_FORMAT(FROM_UNIXTIME(date_submitted),'%Y-%m-%d') 
						BETWEEN 
							DATE_FORMAT(CAST( " . db_param() . " AS DATE),'%Y-%m-%d') 
							AND 
							DATE_FORMAT(CAST( " . db_param() . " AS DATE),'%Y-%m-%d')
					AND (mcfstTipo.field_id = " . db_param() . " AND mcfstTipo.value = " . db_param() . ")
					AND (mcfstFuente.field_id = " . db_param() . " AND mcfstFuente.value = " . db_param() . ")
					AND (mcfstEntrega.field_id = " . db_param() . " AND mcfstEntrega.value = " . db_param() . ")";
		#Organizamos la fecha de inicio, concatenando el a�o el mes y el d�a de inicio.
		$fecha_inicio = string_display_line( get_enum_element('date_year_791',$anio_inicio )). 
			string_display_line( get_enum_element('date_mounth_791',$mes_inicio )). 
			string_display_line( get_enum_element('date_day_791',$dia_inicio ));
		
		#Organizamos la fecha fin, concatenando el a�o el mes y el d�a fin.	
		$fecha_fin = string_display_line( get_enum_element('date_year_791',$anio_fin )). 
			string_display_line( get_enum_element('date_mounth_791',$mes_fin )). 
			string_display_line( get_enum_element('date_day_791',$dia_fin ));
		
		#Obtenemos los valores por defecto para las incognitas de la consulta
		$codigo_tipo_incidencia = ''.config_get('informe_tipo_incidencia');
		$valor_tipo_incidencia = ''.config_get('tipo_incidencia_informe');
		$codigo_fuente = ''.config_get('informe_fuente');
		$valor_fuente = ''.config_get('informe_fuente_pruebas');
		$codigo_entrega = ''.config_get('informe_entrega');
		
		#Ejecutamos la consulta y pasamos los parametros.
		$result = db_query($query, Array($project_id, $fecha_inicio, $fecha_fin, 
			$codigo_tipo_incidencia, $valor_tipo_incidencia, 
			$codigo_fuente, $valor_fuente, 
			$codigo_entrega, trim($entrega)));
		#contamos cuantos registros se obtuvieron.
		$count = db_num_rows( $result );
		#Si la consulta no tiene datos, salimos del m�todo.
		if ($count == 0) {
			return null;
		}
		#Array donde vamos a almacenar la informaci�n de las incidencias.
		$bug = array();
		# Recorremos los resultados de la consulta.
		for( $i = 0; $i < $count; $i++ ) {
			# Obtenemos linea por lina los resultados arrojados de la consulta
			$t_row = db_fetch_array( $result );
			# Obtenemos los valores de las columnas.
			$bug[$i]['id'] = $t_row['id'];
			$bug[$i]['severity'] = $t_row['severity'];
			$bug[$i]['status'] = $t_row['status'];
			$bug[$i]['resolution'] = $t_row['resolution'];
			$bug[$i]['fecha_envio'] = $t_row['fecha'];
			$bug[$i]['resolvio'] = false;
		}
		#Retornamos las incidencias en el rango de fechas determinado.
		return $bug;
	}
	
	
	/**
	 * Requerimiento 808.
	 * M�todo que obtiene la fecha en que se resolvieron las incidencias.
	 * Para obtener esta fecha tomamos la �ltima cuando:
	 * 1. La incidencia es de tipo error y la resoluci�n es correg�da
	 * se paso a un estado resuelta.
	 * 2. La incidencia es de tipo error y la resoluci�n es cualquiera que
	 * paso a estado resuelta o se necesitan m�s datos.
	 * @param unknown_type $incidencias
	 */
	function fechas_resolvio_niveles_de_servicio($incidencias) {
		#Contamos la cantidad de incidencias que llegan al m�todo.
		$count = count( $incidencias );		
		#recorremos las incidencias.
		for( $i = 0; $i < $count; $i++ ) {
			#Obtenemos la incidencia en la posici�n i
			$incidencia = $incidencias[$i];
			#Para obtener la fecha en que se resolvi�, vamos a tener en cuenta 2 casos:
			# 1. La incidencia es de tipo error y la resoluci�n es correg�da
			# 2. La incidencia es de tipo error y la resoluci�n es cualquiera.
			#Preguntamos si al incidencia es de tipo error.
			if ($incidencia['informe_tipo_incidencia'] == config_get('tipo_incidencia_informe')) {
				#Preguntamos si al incidencia tiene una resoluci�n corregida.
				if ($incidencia['resolution'] == config_get('resolucion_informe')) {
					#La fecha resolvi� es la �ltima fecha en que se paso a estado resulto.
					$incidencias[$i]['FechaRsolv'] = 
						get_ultima_fecha_estado_resuelto($incidencia['historial']);
				} else {
					#La fecha resolvi� es la �ltima fecha en que se paso a estado 
					#resuelta o se necesitan m�s datos.
					$incidencias[$i]['FechaRsolv'] =
						get_ultima_fecha_estado_resuelto_o_se_necesitan_mas_datos($incidencia['historial']);
				}
			}		
		}
		#Retornamos nuevamente las incidencias con el nuevo campo.
		return $incidencias;
	}
	
	/**
	 * Requerimiento 808.
	 * M�todo que permite obtener el historial de cada incidencia que llega
	 * al me�todo
	 * @param $incidencias
	 */
	function get_historial_incidencias($incidencias) {
		#Recorremos las incidencias y buscamos el historial de cada una.
		for ($i = 0; $i < count($incidencias); $i++) {
			$incidencias[$i]['historial'] = get_historial_incidencia($incidencias[$i]);
		}
		return $incidencias;
	}
	
	/**
	 * Requerimiento 808.
	 * M�todo que nos permite consultar en la base de datos el historial de los cambios
	 * por los que se a sometido la incidencia.
	 * @param $incidencia
	 */
	function get_historial_incidencia ($incidencia) {
		#tabla en del historial de las incidencias.
		$history = db_get_table('bug_history');
		#consulta para obtener el historial de las incidencias.
		$query = "SELECT his.date_modified
					AS fecha, his.user_id, his.field_name, his.old_value, his.new_value, 
					his.bug_id
				FROM mantis_bug_history_table his
				WHERE his.bug_id = " . db_param() . " 
					AND (	
						(his.field_name =  'handler_id')
						OR
						(his.field_name =  'status' AND 
							(his.new_value = 20 OR his.new_value = 30 
							OR his.new_value = 50 OR his.new_value = 80
							OR his.new_value = 90))		
					)	
				ORDER BY (DATE_FORMAT(FROM_UNIXTIME(his.date_modified),'%Y-%m-%d %H:%i')) ASC";
		#Ejecutamos la consulta y enviamos el id de la incidencia.
		$result = db_query($query, Array($incidencia['id']));
		#Contamos la cantidad de filas que tiene la consulta.
		$count = db_num_rows( $result );
		#Declaramos el array donde se almacenar�n los logs que conforman 
		#el historial de la incidencia.
		$history_bug = array();
		#Recorremos el historial obtenidoi por la consulta.
		for ( $i = 0; $i < $count; $i++ ) {
			#Obtenemos linea por lina los resultados arrojados de la consulta
			$t_row = db_fetch_array( $result );
			#Primero pasamos el timestamp a un formato date.			
			$fecha =  date( config_get( 'normal_date_format' ), $t_row['fecha'] );
			$history_bug[$i]['fecha'] = $fecha;
			$history_bug[$i]['usuario'] = $t_row['user_id'];
			$history_bug[$i]['nombre_campo'] = $t_row['field_name'];
			$history_bug[$i]['old_value'] = $t_row['old_value'];
			$history_bug[$i]['new_value'] = $t_row['new_value'];
			$history_bug[$i]['bug_id'] = $t_row['bug_id'];			
		}
		return $history_bug;
	}
	
	/**
	 * Requerimiento 808.
	 * Modificado por incidencia 52367 (Rqto 808).
	 * M�todo que permite obtener los datos que se van a mostrar en la hoja de 
	 * resuemen
	 * Se recibe el parametro $fecha_con_semanas_adicionales que contiene la suma
	 * entre la fecha fin actual m�s cinco d�as h�biles.
	 * @param $incidencias Incidecias para las cuales se va a hacer el resumen.
	 * @param $numero_semana Semanas trasncurridas.
	 * @param $fecha_final Fecha hasta donde se va a hacer el resumen.
	 * @param $fecha_con_semanas_adicionales
	 */
	function get_informe_resume ($incidencias, $numero_semana, $fecha_final, $fecha_con_semanas_adicionales){
		$columnas_informe = array();
		#Almacenamos todas las incidencias.
		$columnas_informe['incidencias'] = $incidencias;
		#Ordenamos las incidencias por severidad.
		$incidencias = ordenar_incidencias_severidad($incidencias);
		#Recorremos cada una de las incidencias por severidad.
		for ($i = 0; $i < count($incidencias); $i ++ ) {
			#Analizamos $i, donde 0 es critico, 1 es mayor, 2 es promedio y 3 es menor.
			switch ($i) {
				case 0: #Severidad critica
					#Almacenamos el c�digo de severidad critica.
					$columnas_informe[$i]['severity'] = config_get('informe_severity_critica');
					#Almacenamos el total de incidencias criticas.
					$columnas_informe[$i]['totalIncidenciasPeriodo'] =
						count($incidencias['critica']);
					#Obtenemos el cumplimiento de las incidencias.
					$cumplimiento = cumplimiento_incidencias_por_semana($incidencias['critica'],
						$numero_semana, $columnas_informe['incidencias'], $fecha_final, $fecha_con_semanas_adicionales);
					#Asignamos el total de incidencias solucionadas y de las no solucionadas.
					$columnas_informe[$i]['totalIncidenciasSolucionadas']  = $cumplimiento['cumplimiento'];
					$columnas_informe[$i]['totalIncidenciasNoSolucionadas']  = $cumplimiento['incumplimiento'];
					#Almacenamos todas las incidencias actualizadas, obtenidas del
					#m�tdodo cumplimiento_incidencias_por_semana
					$columnas_informe['incidencias'] = $cumplimiento['incidencias'];
					#Ahora vamos a calcular el porcentaje de cumplimiento por cada serveridad.
					if (count($incidencias['critica']) == 0) {
						#En caso no haber incidencias en esta severidad, el porcentaje ser� de 100.
						$columnas_informe[$i]['porcentajeCumplimiento'] = 100;
					} else {
						#de lo contrario se dividir� el n�mero de incidencias resueltas de esta severidad
						#entre el n�mero de incidencias por esta severidad, por 100.
						$porcentaje = (numero_incidencias_resueltas($columnas_informe['incidencias'],
							$columnas_informe[$i]['severity'] ) / count($incidencias['critica'])) * 100;
						#redondeamos a dos decimales.
						$porcentaje = round($porcentaje, 2);
						#Almacenamos el valor.
						$columnas_informe[$i]['porcentajeCumplimiento'] = $porcentaje;
					}
					#Determinamos si se cumplen todas las incidencias y marcamos S
					if ($columnas_informe[$i]['porcentajeCumplimiento'] >= 100) {
						$columnas_informe[$i]['cumple']  = 'S';
					} else {
						$columnas_informe[$i]['cumple']  = 'N';
					}
					break;
				case 1: #Severidad mayor
					#Almacenamos el c�digo de severidad mayor.
					$columnas_informe[$i]['severity'] = config_get('informe_severity_mayor');
					#Almacenamos el total de incidencias mayores.
					$columnas_informe[$i]['totalIncidenciasPeriodo'] =
						count($incidencias['mayor']);
					#Obtenemos el cumplimiento de las incidencias.
					$cumplimiento = cumplimiento_incidencias_por_semana($incidencias['mayor'],
						$numero_semana, $columnas_informe['incidencias'], $fecha_final, $fecha_con_semanas_adicionales);
					#Asignamos el total de incidencias solucionadas y de las no solucionadas.
					$columnas_informe[$i]['totalIncidenciasSolucionadas']  = $cumplimiento['cumplimiento'];
					$columnas_informe[$i]['totalIncidenciasNoSolucionadas']  = $cumplimiento['incumplimiento'];
					#Almacenamos todas las incidencias actualizadas, obtenidas del
					#m�tdodo cumplimiento_incidencias_por_semana
					$columnas_informe['incidencias'] = $cumplimiento['incidencias'];
					#Ahora vamos a calcular el porcentaje de cumplimiento por cada serveridad.
					if (count($incidencias['mayor']) == 0) {
						#En caso no haber incidencias en esta severidad, el porcentaje ser� de 100.
						$columnas_informe[$i]['porcentajeCumplimiento'] = 100;
					} else {
						#de lo contrario se dividir� el n�mero de incidencias resueltas de esta severidad
						#entre el n�mero de incidencias por esta severidad, por 100.
						$porcentaje = (numero_incidencias_resueltas($columnas_informe['incidencias'],
							$columnas_informe[$i]['severity'] ) /count($incidencias['mayor'])) * 100;
						#redondeamos a dos decimales.
						$porcentaje = round($porcentaje, 2);
						#Almacenamos el valor.
						$columnas_informe[$i]['porcentajeCumplimiento'] = $porcentaje;
					}
					#Determinamos si se cumplen todas las incidencias y marcamos S
					if ($columnas_informe[$i]['porcentajeCumplimiento'] >= 100) {
						$columnas_informe[$i]['cumple']  = 'S';
					} else {
						$columnas_informe[$i]['cumple']  = 'N';
					}
					break;
				case 2: #Severidad promedio
					#Almacenamos el c�digo de severidad promedio.
					$columnas_informe[$i]['severity'] = config_get('informe_severity_promedio');
					#Almacenamos el total de incidencias promedio.
					$columnas_informe[$i]['totalIncidenciasPeriodo'] =
						count($incidencias['promedio']);
					#Obtenemos el cumplimiento de las incidencias.
					$cumplimiento = cumplimiento_incidencias_por_semana($incidencias['promedio'],
						$numero_semana, $columnas_informe['incidencias'], $fecha_final, $fecha_con_semanas_adicionales);
					#Asignamos el total de incidencias solucionadas y de las no solucionadas.
					$columnas_informe[$i]['totalIncidenciasSolucionadas']  = $cumplimiento['cumplimiento'];
					$columnas_informe[$i]['totalIncidenciasNoSolucionadas']  = $cumplimiento['incumplimiento'];
					#Almacenamos todas las incidencias actualizadas, obtenidas del
					#m�tdodo cumplimiento_incidencias_por_semana
					$columnas_informe['incidencias'] = $cumplimiento['incidencias'];
					#Ahora vamos a calcular el porcentaje de cumplimiento por cada serveridad.
					if (count($incidencias['promedio']) == 0) {
						#En caso no haber incidencias en esta severidad, el porcentaje ser� de 100.
						$columnas_informe[$i]['porcentajeCumplimiento'] = 100;
					} else {
						#de lo contrario se dividir� el n�mero de incidencias resueltas de esta severidad
						#entre el n�mero de incidencias por esta severidad, por 100.
						$porcentaje = (numero_incidencias_resueltas($columnas_informe['incidencias'],
							$columnas_informe[$i]['severity'] ) / count($incidencias['promedio'])) * 100;
						#redondeamos a dos decimales.
						$porcentaje = round($porcentaje, 2);
						#Almacenamos el valor.
						$columnas_informe[$i]['porcentajeCumplimiento'] = $porcentaje;
					}
					#Determinamos si se cumplen el 90% las incidencias y marcamos S
					if ($columnas_informe[$i]['porcentajeCumplimiento'] >= 90) {
						$columnas_informe[$i]['cumple']  = 'S';
					} else {
						$columnas_informe[$i]['cumple']  = 'N';
					}
					break;
				case 3: #Severidad menor
					#Almacenamos el c�digo de severidad menor.
					$columnas_informe[$i]['severity'] = config_get('informe_severity_menor');
					#Almacenamos el total de incidencias menor.
					$columnas_informe[$i]['totalIncidenciasPeriodo'] =
					count($incidencias['menor']);
					#Obtenemos el cumplimiento de las incidencias.
					$cumplimiento = cumplimiento_incidencias_por_semana($incidencias['menor'], 
						$numero_semana, $columnas_informe['incidencias'], $fecha_final, $fecha_con_semanas_adicionales);
					#Asignamos el total de incidencias solucionadas y de las no solucionadas.
					$columnas_informe[$i]['totalIncidenciasSolucionadas']  = $cumplimiento['cumplimiento'];
					$columnas_informe[$i]['totalIncidenciasNoSolucionadas']  = $cumplimiento['incumplimiento'];
					#Almacenamos todas las incidencias actualizadas, obtenidas del
					#m�tdodo cumplimiento_incidencias_por_semana
					$columnas_informe['incidencias'] = $cumplimiento['incidencias'];
					#Ahora vamos a calcular el porcentaje de cumplimiento por cada serveridad.
					if (count($incidencias['menor']) == 0) {
						#En caso no haber incidencias en esta severidad, el porcentaje ser� de 100.
						$columnas_informe[$i]['porcentajeCumplimiento'] = 100;
					} else {
						#de lo contrario se dividir� el n�mero de incidencias resueltas de esta severidad
						#entre el n�mero de incidencias por esta severidad, por 100.
						$porcentaje = (numero_incidencias_resueltas($columnas_informe['incidencias'],
							$columnas_informe[$i]['severity'] ) / count($incidencias['menor'])) * 100;
						#redondeamos a dos decimales.
						$porcentaje = round($porcentaje, 2);
						#Almacenamos el valor.
						$columnas_informe[$i]['porcentajeCumplimiento'] = $porcentaje;
					}
					#Determinamos si se cumplen el 90% las incidencias y marcamos S
					if ($columnas_informe[$i]['porcentajeCumplimiento'] >= 60) {
						$columnas_informe[$i]['cumple']  = 'S';
					} else {
						$columnas_informe[$i]['cumple']  = 'N';
					}
					break;
			}
			
		}
		return $columnas_informe;
	}	
	
	
	/**
	 * Requerimiento 808.
	 * M�todo que permite ordenar las incidencias por severidad 
	 * (critica, mayor, promedio y menor).
	 * @param $incidencias
	 */
	function ordenar_incidencias_severidad($incidencias) {
		#Array donde vamos a almacernar las incidencias por cada tipo de severida
		$incidencias_criticas = array();
		$incidencias_mayor = array();
		$incidencias_promedio = array();
		$incidencias_menor = array();
		#Array donde almacenaremos todas las incidencias.
		$incidencias_por_severidad = array();
		
		#Recorremos las incidencias que llegan al m�todo para ingresarlas
		#a alg�n array de severidad. 
		for ($i = 0; $i < count($incidencias); $i ++) {
			#Preguntamos si la severidad de la incidencia en la posici�n i
			#es igual a critica
			if ($incidencias[$i]['severity'] == config_get('informe_severity_critica')) {
				#Almacenamos la incidencia en el array de criticas
				$incidencias_criticas[$i] = $incidencias[$i];
				continue;
			}
			
			#Preguntamos si la severidad de la incidencia en la posici�n i
			#es igual a mayor
			if ($incidencias[$i]['severity'] == config_get('informe_severity_mayor')) {
				#Almacenamos la incidencia en el array de mayores
				$incidencias_mayor[$i] = $incidencias[$i];
				continue;
			}
			
			#Preguntamos si la severidad de la incidencia en la posici�n i
			#es igual a promedio
			if ($incidencias[$i]['severity'] == config_get('informe_severity_promedio')) {
				#Almacenamos la incidencia en el array de promedio
				$incidencias_promedio[$i] = $incidencias[$i];
				continue;
			}
			
			#Preguntamos si la severidad de la incidencia en la posici�n i
			#es igual a menor
			if ($incidencias[$i]['severity'] == config_get('informe_severity_menor')) {
				#Almacenamos la incidencia en el array de menores
				$incidencias_menor[$i] = $incidencias[$i];
				continue;
			}
		}
		#Almacenamos las incidencias por severidad
		$incidencias_por_severidad['critica'] = $incidencias_criticas;
		$incidencias_por_severidad['mayor'] = $incidencias_mayor;
		$incidencias_por_severidad['promedio'] = $incidencias_promedio;
		$incidencias_por_severidad['menor'] = $incidencias_menor;
		#Retornamos las incidencias ordenadas por severidad.
		return $incidencias_por_severidad;
	}
	
	/**
	 * Requerimiento 808.
	 * Modificado por incidencia 0052367 (Rqto 808)
	 * M�todo que nos permite determinar si una incidencia es resuelta en un n�mero
	 * determinado  de semanas.
	 * Se recibe en este m�todo la fecha fin m�s cinco d�as h�biles.
	 * @param $incidencias_severidad
	 * @param $numero_semana
	 * @param $todas_las_incidencias
	 * @param $fecha_final
	 * @param $fecha_con_semanas_adicionales
	 */
	function cumplimiento_incidencias_por_semana($incidencias_severidad, $numero_semana, 
		$todas_las_incidencias, $fecha_final, $fecha_con_semanas_adicionales) {
		#Contadores para indicar las incidencias cumplidas y no cumplidas.
		$cumplidas = 0;
		$incumplidas = 0;
		#Reordenamos el array.
		$incidencias_severidad = array_values($incidencias_severidad);
		#Vamos a recorrer cada una de las incidencias.
		for ($i = 0; $i < count($incidencias_severidad); $i ++) {
			#Obtenemos la incidencia en la posici�n $i
			$incidencia = $incidencias_severidad[$i];
			#Si el no han transcurrido semanas, trabajaremos con la fecha fin 
			#como la final, para que al sumar cero semanas a la fecha, nos 
			#de como resultado el mismo d�a.
			if ($numero_semana == 0) {
				$fecha_fin = $fecha_final;
			} else {
				#incidencia 0052367 (Rqto 808)
				#De lo contrario se coloca la fecha fin como la fecha sin que 
				#ten�amos antes m�s 5 d�as h�biles.
				$fecha_fin = $fecha_con_semanas_adicionales;
			}
			#preguntamos si la incidencia se cumplio.
			$cumplimiento_SLA = cumplio_SLA($incidencia, $fecha_fin);
			#si la incidencia fue cumplida, aumentamos el n�mero de incidencias
			#cumplidas, de lo contrario aumentamos el n�mero de incidencias
			#incoumplidas.
			if ($cumplimiento_SLA['resuelta'] == true) {
				$cumplidas ++;
			}  else  {
				$incumplidas ++ ;
			}
			#Almacenamos la fecha fin en la posici�n de fecha env�o, para 
			#que se siga realizando el calculo despu�s de esta fecha, y no
			#se repita el c�lculo de fechas anteriores. 
			for ($o = 0; $o < count($todas_las_incidencias); $o ++) {
				#Vamos a buscar la incidencia que modificamos en el grupo de incidencias,
				#para ir guardando las actualizaciones.
				if ($todas_las_incidencias[$o]['id'] == $incidencia['id']) {
					#obtenemos la fecha fin y el estado final que tuvo la incidencia.
					$todas_las_incidencias[$o]['fecha_envio'] = $cumplimiento_SLA['fecha_fin'];
					$todas_las_incidencias[$o]['ultimo_estado'] = $cumplimiento_SLA['ultimo_estado'];
					#Si la incidencia fue resuelta, marcamos la incidencia como resuelta.
					if ($cumplimiento_SLA['resuelta'] == true) {
						$todas_las_incidencias[$o]['resolvio'] = true;
					}					
					break;
				}
			}
			
		}
		$cumplimiento =array();
		#Agrupamos las respuestas en un array y retornamos.
		$cumplimiento['incidencias'] = $todas_las_incidencias;
		$cumplimiento['cumplimiento'] = $cumplidas;
		$cumplimiento['incumplimiento'] = $incumplidas;
		return $cumplimiento;
		
	}
	
	/**
	 * Requeirmiento 808.
	 * M�todo que permite saber si una incidencia es resuelta o no hasta
	 * la fecha fin que llega al m�todo.
	 * @param $incidencia
	 * @param $fecha_inicio
	 */
	function cumplio_SLA ($incidencia, $fecha_fin) {
		#obtenemos todo el historial de la incidencia.
		$historias = $incidencia['historial'];
		$resuelta = false;
		$respuesta = array();
		$ultimo_estado = null;
		#recorremos el historial de la incidencia para buscar los cambios de estados
		#y almacenar el �ltimo estado de la incidencia hasta la fecha fin.
		for ($i = 0; $i < count($historias); $i ++) {
			$historia = $historias[$i];
			#Incidencia 0052367 (Rqto 808)
			#Esta fecha quedar� con formato AAAA-MM-DD		
			$fecha_historial = substr($historia['fecha'], 0, 10);
			#solo buscamos desde la fecha de env�o de la incidencia
			#hasta la fecha fin que llega el m�todo.
			if ($fecha_historial >= $incidencia['fecha_envio'] && 
				$fecha_historial <= $fecha_fin) {
					#Si el campo modificaod fue el estado... continuamos preguntado.
				if ($historia['nombre_campo'] == config_get('estado')) {
					$tipo_usuario = get_tipo_usuario($historia['usuario']);
					#el cambio de estado debe ser hecho por una persona de HBT.
					if ($tipo_usuario['acceso'] == 1) {
						$ultimo_estado = $historia['new_value'];
					}
				}
			}
		}
		#si el �ltimo estado es null y la incidencia ya ha sido resuelta, entonces
		#dejamos la incidencia como resuelta.
		if ($ultimo_estado == null && $incidencia['resolvio'] == true) {
			$resuelta =  true;
		} else {
			#Si el �ltimo estado ha sido resuelto, cerrado o se necesitan m�s datos,
			#entonces indicamos que la incidencia ya fue resuelta.
			if($ultimo_estado == config_get('estado_resuelto') ||
				$ultimo_estado == config_get('estado_cerrada') ||
				$ultimo_estado == config_get('estado_se_necesitan_mas_datos')){
				$resuelta =  true;
			}
		}
		#Si el �ltimo estado es null, dejamos como �ltimo estado el �ltimo estado
		#que haya ten�do la incidencia.
		if ($ultimo_estado == null) {
			$ultimo_estado = $incidencia['ultimo_estado'];
		}
		#agrupamos las respuestas y retornamos.
		$respuesta['ultimo_estado'] = $ultimo_estado;
		$respuesta['fecha_fin'] = $fecha_fin;
		$respuesta['resuelta'] = $resuelta;
		return $respuesta;
			
	}
	
	/**
	 * Requerimiento 808.
	 * M�todo que permite aumentar a una fecha una semana en d�as habiles
	 * @param $fecha_inicio
	 * @param $adicion n�mero de semanas que se va a aumentar.
	 */
	function aumentar_semanas_a_fecha ($fecha_inicio, $adicion) {
		#si el n�mero de semanas a aumentar es 0, entonces se aumenta 0.
		if ($adicion == 0) {
			$total = 0;
		} else {
			# de lo contario se multiplica el n�emero de semanas a adicionar
			#por 5 (d�as h�biles de una semana.)
			$total = $adicion * 5;
		}
		#Se recorre el n�mero de d�as habiles y se pregunta si cada uno de los 
		#d�as a adicionar son laborables o no. De ser no laborable un d�a se aumentar�
		#los d�as a aumentar a la fecha de inicio.		
		for ($i = 0; $i < $total; $i ++) {			
			#Esta fecha quedar� con formato AAAA-MM-DD			
			$anio = substr($fecha_inicio, 0, 4);
			$mes = substr($fecha_inicio, 5, 2);
			$dia = substr($fecha_inicio, 8, 2);
			#Preguntamos si el d�a es no laborable
			if (dia_laborable ($anio, $mes, $dia, ($i + 1)) == false) {
				#de ser no laborable aumentamos un d�a m�s para aumentar
				#a la fecha inicio.
				$total ++;
			}
		}
		#consulta que nos permite adicionar un d�a m�s a una fecha en particular.
		$consulta = "SELECT DATE_FORMAT(CAST(" . db_param() . " AS DATE),'%Y-%m-%d') + 
			INTERVAL " . db_param() . " DAY as fecha_fin";
		#enviamos la fecha inicio y el n�mero de d�as a adicionar.
		$result = db_query($consulta, Array($fecha_inicio, $total));
		#retornamos la nueva fecha.
		return $result->fields['fecha_fin'];
	}
	
	
	/**
	 * Requerimiento 808.
	 * M�todo que nos permite determinar si un grupo de incidencias ya esta
	 * cerrado y cumplido al 100 %
	 * @param $datos_incidencias
	 */
	function cumplimiento_al_100_y_todas_cerradas ($datos_incidencias) {
		#Obtenemos las incidencias.
		$incidencias = $datos_incidencias['incidencias'];
		#Preguntamos si hay alguna incidnecia grupo de incidecias por severidad que no
		#este en cumplimiento 100, para indicar que no estan todas cumplidas. 
		for ($o = 0; $o < (count($datos_incidencias)-1); $o ++) {
			if ($datos_incidencias[$o]['porcentajeCumplimiento'] != 100) {
				return false;
			}
		}
		$tamano_incidencias = count($incidencias) - 1;
		#Ahora recorremos cada incidencia para determinar si hay alguna incidencia
		#que en su �ltimo estado no haya sido cerrado, para retornar un falso e
		#indicar que no todas estan cerradas.
		for ($i = 0; $i < $tamano_incidencias; $i ++) {
			if ($incidencias[$i]['ultimo_estado'] != config_get('estado_cerrada')) {
				return false;
			}
		}
		#en caso de llegar a este punto, las incidencias fueron todas cerradas 
		#y cumplidas.
		return true;
	}

	/**
	 * Requerimiento 808.
	 * M�todo que permite contar el n�mero de incidencias resueltas por severidad.
	 * @param  $incidencias
	 * @param  $severidad
	 */
	function numero_incidencias_resueltas ($incidencias, $severidad) {
		$cantidad_incidencias_resueltas = 0;
		#re-indexamos las incidencias.
		$incidencias = array_values($incidencias);
		#Recorremos cada una de las incidencias.
		for ($i = 0; $i < count($incidencias); $i ++) {
			#Si la incidencia tiene la misma severidad y fue resuelta, 
			#aumentamos el contador de incidencias resueltas.
			if ($incidencias[$i]['severity'] == $severidad && 
				$incidencias[$i]['resolvio'] == true) {
				$cantidad_incidencias_resueltas ++;
			}
		}
		#retornamos el n�mero de incidencias resueltas.
		return $cantidad_incidencias_resueltas;
	}
	/**
	 * Reqto 838
	 * M�todo que trae el historial de una incidencia.
	 * @param $row
	 */
	function get_historial_incidencias_pit_cliente ($t_row) {
		#Se asigna la tabla en la cual se realizar� la consulta.
		$tabla_usuario = db_get_table('bug_history');
		#Se genera la consulta a la base de datos.
	 	$query = "SELECT bug_id, field_name, old_value, new_value, FROM_UNIXTIME(date_modified) AS fecha
	 				 FROM $tabla_usuario 
	 				 	WHERE bug_id = " . db_param();
	  	#Se asigna el resultado de la consulta enviando el parametro.
	 	$result = db_query($query, Array($t_row));
		#Se cuenta el numero de historiales del resultado.
	 	$count = db_num_rows( $result );
		#Declaramos el array donde se almacenar�n los logs que conforman 
		#el historial de la incidencia.
		$history_bug = array();
		#Recorremos el historial obtenido por la consulta.
		for ( $i = 0; $i < $count; $i++ ) {
			#Obtenemos linea por linea los resultados arrojados de la consulta
			$t_rows = db_fetch_array( $result );
			#Guardamos cada valor obtenido de la consulta en el array 
			#del historial.
			$history_bug[$i]['bug_id'] = $t_rows['bug_id'];	
			$history_bug[$i]['nombre_campo'] = $t_rows['field_name'];
			$history_bug[$i]['old_value'] = $t_rows['old_value'];
			$history_bug[$i]['new_value'] = $t_rows['new_value'];
			$t_normal_date_format = config_get( 'normal_date_format' );	
			$fecha= substr($t_rows['fecha'], -19,16);
			$history_bug[$i]['fecha'] =  $fecha;
		}
		#retornamos el array del historial
		return $history_bug;
	}
	/**
	 * Reqto 838
	 * Metodo que permite filtrar la fecha de la incidencia resuelta 
	 * y asignarla a la variable que retorna el valor.
	 * @param $t_row
	 */
	function fecha_incidencia_resuelta ($t_row){
			#Traemos el historial de la incidencia y la almacenamos 
			#en una variable
			$historial_incidencia= get_historial_incidencias_pit_cliente($t_row);
			#Traemos el ultimo historial de la incidencia cuando paso a resuelta.
			$historial_fecha= historial_fecha_resuelta($historial_incidencia);
			#asignamos la ultima fecha de la incidencia cuando paso a resuelta.
			$fecha_resuelta= $historial_fecha['fecha'];
			#retornamos la ultima fecha en que se paso la incidencia a resuelta.
			return $fecha_resuelta;
		}
		
/**
 * Reqto 838
 * M�todo que permite realizar la iteraci�n de las incidencias que se encuentran 
 * en estado resuelta.
 * @param $historial_incidencia
 */	
	function historial_fecha_resuelta ($historial_incidencia){
	 #se declara variable donde se almacenar� el �ltimo historial 
	 #cuando la incidencia paso a resuelta.
		$incidencia_resuelta=null;
		#iteramos mediante un for los campos del historial obtenido para
		#consultar la ultima fecha en que la incidencia paso a resuelta.
		for( $k = 0; $k < count($historial_incidencia);$k++ ) {
			#asignamos a la variable history el historial en la posici�n k
			$history = $historial_incidencia[$k];
			#validamos que el campo del historial sea el mismo que el campo status.
			if ($history['nombre_campo'] == config_get('nombre_campo')) {
			#validamos que el nuevo valor sea el del estado resuelto.
				if ($history['new_value'] == config_get('estado_resuelto')) {
			#asignamos a la variable incidencia resuelta el valor del history
			#en que se paso la incidencia a resuelta.
					$incidencia_resuelta=$history;
				}
			}
		}
		#retornamos el �ltimo historial en que se paso la incidencia a resuelta.
		return $incidencia_resuelta;
	}	
	/**
	 * Reqto 838
	 * M�todo que trae el historial de la incidencia y los tiempos totales 
	 * de una incidencia cuando se encuentre en estados diferentes a nueva,
	 * se necesitan mas datos, resuelta y cerrada.
	 * @param $t_row
	 */
	function tiempo_incidencia_pit ($t_row){
		#Variable que guarda los historiales de la incidencia 
		$historial_incidencia= get_historial_incidencias_pit_cliente($t_row);
		#Variable que guarda los tiempos totales de la incidencia cuando esta se encuentra 
		#en estados diferentes a nueva, se necesitan mas datos, resuelta y cerrada.
		$totales_incidencia= tiempos_totales_incidencias($historial_incidencia);
		#retorna un array con los tiempos en horas y minutos.
		return $totales_incidencia;
		
	}
	/**
	 * Reqto 838
	 * M�todo que obtiene los tiempos totales en que una incidencia 
	 * se encuentra en estados diferentes a nueva, se necesitan mas datos, resuelta
	 * y cerrada.
	 * @param $historial_incidencia
	 */
	function tiempos_totales_incidencias ($historial_incidencia){
		#Variable que guarda el tiempo en horas de cada historial.
		$tiempo_hora=0;
		#Variable que guarda el tiempo en minutos de cada historial
		$tiempo_minuto=0;
		#Variable que guarda la fecha en que la incidencia pasa a un estado diferente
		#de nueva, se necesitan mas datos, resuelta y cerrada.
		$fecha_inicio='';
		#Variable que guarda la fecha en que la incidencia pasa a un estado
		#de nueva, se necesitan mas datos, resuelta y cerrada.
		$fecha_fin='';
		#recorremos el historial para ir realizando la sumatoria de los tiempos
		#de la incidencia en los estados especificados.
		for($i=0; $i<count($historial_incidencia); $i++){
			#Guardamos el historial de la posici�n i en la variable $history.
			$history=$historial_incidencia[$i];
			#preguntamos si la fecha de inicio esta vacia para asignar la fecha de inicio
			if($fecha_inicio==''){
				#preguntamos si el campo modificado en el historial es el estado
				if($history['nombre_campo']== config_get('nombre_campo')){
					#preguntamos si el nuevo valor del campo estado fue a asignada, aceptada o confirmada.
					if(($history['new_value']== config_get('estado_asignada'))
					||($history['new_value']== config_get('estado_aceptada'))
					||($history['new_value']== config_get('estado_confirmada'))){
						#si el nuevo valor del campo esta en alguna de las opciones asignamos
						#la fecha del historial a la fecha de inicio.
						$fecha_inicio= $history['fecha'];
					}
				}
			}
			#preguntamos si ya se asigno la fecha de inicio y si la fecha fin se encuentra vacia.
			if($fecha_inicio!='' && $fecha_fin==''){
				#preguntamos si el campo modificado es el campo estado
				if($history['nombre_campo']== config_get('nombre_campo')){
					#preguntamos si el nuevo valor del campo estado fue a nueva, se necesitan mas datos
					#resuelto o cerrada
					if(($history['new_value']== config_get('estado_nueva'))
					|| ($history['new_value']== config_get('estado_se_necesitan_mas_datos'))
					|| ($history['new_value']== config_get('estado_resuelto'))
					|| ($history['new_value']== config_get('estado_cerrada'))){
						#si el nuevo valor del campo se encuentra en alguna de las opciones se asigna
						#la fecha del historial a la $fecha_fin.
						$fecha_fin=$history['fecha'];
						#traemos el tiempo total en que la incidencia se encontro en un estado diferente.
						$tiempo_total= tiempos_incidencias($fecha_inicio, $fecha_fin);
						#asignamos el valor retornado a la variables $tiempo_hora y $tiempo_minuto.
						$tiempo_hora += $tiempo_total['hora'];
						$tiempo_minuto += $tiempo_total['minuto'];
						#Despues de calculado los tiempos de estos reinicializamos las variables
						#fecha_inicio y fecha_fin.
						$fecha_inicio='';
						$fecha_fin='';
					}
				}
			}
		}
		#Preguntamos si la fecha de inicio es diferente a vacia
		#y la fecha fin aun esta vacia
		if ($fecha_inicio!=null && $fecha_fin==''){
			#consultamos la fecha actual
			$query="select now()";
			#Guardamos el resultado de la consulta.
			$result= db_query($query);
			#Capturamos el resultado de la consulta.
			$fecha=$result->fields['now()'];
			#Obtenemos solo una parte de la fecha para que quede con el
			#formato AAAA MM DD 00:00
			$fechas= substr($fecha, -19,16);
			#asignamos a la variable $fecha_fin la fecha actual
			$fecha_fin=$fechas;
			#traemos el tiempo total de la incidencia desde que se asigno, acepto o
			#confirmo hasta la fecha actual.
			$tiempo_total= tiempos_incidencias($fecha_inicio, $fecha_fin);
			#Asignamos el valor obtenido a las variables $tiempo_hora y $tiempo minuto.
			$tiempo_hora += $tiempo_total['hora'];
			$tiempo_minuto += $tiempo_total['minuto'];
		}
		#Verificamos si el valor obtenido en $tiempo_minuto
		#es mayor o igual a 60
		while ($tiempo_minuto >= 60) {
			#Si $tiempo_minuto es mayor o igual a 60 entonces
			#vamos restandole 60 hasta que quede menor.
			$tiempo_minuto = $tiempo_minuto - 60;
			#Cada vez que resten minutos, se aumentar� una hora.
			$tiempo_hora ++;
		}
		#Si los minutos estan entre 0 y 9 se concatena un cero antes del valor del tiempo_minuto.
		if($tiempo_minuto<10){
			#se concatena a la variable tiempo_minuto el valor 0
			$tiempo_minuto='0'.$tiempo_minuto;
		}
		#Declaramos la variable tipo Array
		#en la que se almacenar� el resultado obtenido en horas y minutos.
		$tiempos= array();
		#Se almacena en la variable $tiempos el valor de las horas y los minutos.
		$tiempos['hora']=$tiempo_hora;
		$tiempos['minuto']=$tiempo_minuto;
		#Retornamos el array con los valores obtenidos.
		return $tiempos;

	}
	/**
	 * Reqto 838
	 * M�todo que calcula los tiempos en que una incidencia se encuentra
	 * en estados diferentes a nueva, se necesitan mas datos, resuelta y 
	 * cerrada.
	 * @param $fecha_inicio
	 * @param $fecha_fin
	 */
	function tiempos_incidencias ($fecha_inicio, $fecha_fin){
		#Inicializamos las variables $tiempo_hora y $tiempo minuto
		#en 0; variables donde se almacenar� el tiempo en horas y minutos
		#entre la fecha inicio y fecha fin.
		$tiempo_hora = 0;
		$tiempo_minuto = 0;
		#Variable que almacena los dias de diferencia entre la fecha inicio y la fecha fin.
		$dias_diferencia = dias_diferencia_fechas_resolvio_asignacion(substr($fecha_inicio,-16, 10),
		substr($fecha_fin, -16, 10));
		#Requerimiento 847
		#Verificamos que la hora y los minutos de inicio esten en el horario laboral.
		#Formatod e fecha recibido: 2012-10-09 10:59:35
		$tiempos_laborables_inicio =
			horas_reales_incidencias(substr($fecha_inicio, -5, 2), substr($fecha_inicio, -2, 2));
		#Obtenemos la hora y los minutos corrrectos, seg�n el horario laboral.
		$hora_inicio = $tiempos_laborables_inicio['hora'];
		$minuto_inicio = $tiempos_laborables_inicio['minutos'];

		#Verificamos que la hora y los minutos fin esten en el horario laboral.
		$tiempos_laborables_fin =
			horas_reales_incidencias(substr($fecha_fin,-5, 2),substr($fecha_fin, -2, 2));
		#Obtenemos la hora y los minutos corrrectos, seg�n el horario laboral.
		$hora_fin = $tiempos_laborables_fin['hora'];
		$minuto_fin = $tiempos_laborables_fin['minutos'];
		
		#Recorremos los dias de diferencia para realizar las operaciones necesarias para calcular
		#el tiempo en que una incidencia permanece en estados diferentes a nueva, se necesitan mas
		#datos, resuelta y cerrada.
		#Requerimiento 847 
		#se crea variable para guarda los dias no laborables que han transcurrido.
		$laborables=0;
		for ($dias_transcurridos = 0;  $dias_transcurridos <= $dias_diferencia; $dias_transcurridos ++){
		#Requerimiento 847
			#Se modifica para que se tome en cuenta los dias festivos del a�o.
			#Esta fecha quedar� con formato AAAA-MM-DD
			$fecha_actual = substr($fecha_inicio,-16, 10);
			#Preguntamos si la fecha actual m�s los d�as transcurridos es una fecha laborable.
			$laborable = dia_laborable(substr($fecha_actual, 0,4),
			substr($fecha_actual, 5,2),substr($fecha_actual, 8,2), $dias_transcurridos);
			#Si no es un d�a laborable
			if ($laborable == false) {
				#volvemos a ejecutar el for, porque los d�as no laborables
				#no se tendr�n en cuenta para el calculo.
				$laborables++;
				continue;
			}
				
			if($dias_transcurridos == $dias_diferencia){
				#Requerimiento 847
				#Se modifica para que se tome en cuenta los dias festivos del a�o.
				#Preguntamos si los dias de diferencia son 0
				if ($dias_transcurridos == 0){
					#Si la hora inicio es en la ma�ana.
					if ($hora_inicio >= config_get('hora_8') && $hora_inicio <= config_get('hora_12')) {
						#Si la hora inicio no tiene minutos, no se tendr�n
						#en cuenta, y haremos la resta entre la hora fin
						#y lahora inicio.
						if ($minuto_inicio == 0) {
							#tomaremos la resta entre la hora fin de la jornada
							#en la ma�ana y la hora inicio, m�s el tiempo total de la tarde.
							$tiempo_hora += (config_get('hora_12') - $hora_inicio) + (config_get('hora_18') - config_get('hora_13'));
							#se tomara el minuto de inicio menos el minuto fin de la jornada.
							$tiempo_minuto += $minuto_inicio + $minuto_fin;
						} else {
							#Si la hora de inicio es igual a la hora fin se realizar� la resta dentro
							#de los minutos.
							if ($hora_inicio== $hora_fin){
								#Se restan la hora fin con la hora de inicio
								$tiempo_hora += $hora_fin-$hora_inicio;
								#Se resta los minutos fin y minutos de inicio.
								$tiempo_minuto += $minuto_fin-$minuto_inicio;
							}else{
								#Si los dias de diferencia son iguales a 0 entonces a la variable
								#$tiempo_hora le asignamos el valor de la hora_fin-hora_inicio
								if ($minuto_inicio>0){
									#Si el minuto de inicio es mayor a 0 aumentamos la variable $hora_inicio.
									$hora_inicio++;
								}
								#Si la hora inicio es igual a la hora fin el tiempo de la hora es cero y se restan los minutos
								if($hora_inicio==$hora_fin){
									#se asigna cero a la variable tiempo hora
									$tiempo_hora +=0;
									#se calcula el tiempo en minutos.
									$tiempo_minuto +=config_get('minuto_60')-$minuto_inicio;
								
								}else{
								#tomaremos la resta entre la hora inicio de la jornada
								#en la ma�ana , m�s el tiempo total de la tarde.
								$tiempo_hora += (config_get('hora_12')-$hora_inicio)+ ($hora_fin - config_get('hora_13'));
								#se restan los minutos de la hora menos el minuto inicio mas el minuto fin.
								$tiempo_minuto += config_get('minuto_60')-$minuto_inicio + $minuto_fin;
								}
							}
						}
					}else {
						#Si la hora de inicio es mayor a las 12:30 pm
						if ($hora_inicio == config_get('hora_12') && $minuto_inicio >= config_get('minuto_30')){
							#Si la hora fin es menor a la 1:30 pm
							if ($hora_fin == config_get('hora_13')&& $minuto_fin <= 30 ){
								#Se igualan las horas y minutos a 0
								$hora_inicio=0;
								$hora_fin=0;
								$minuto_inicio=0;
								$minuto_fin=0;
								#Se le agrega a el tiempo hora la resta entre la hora inicio y la hora fin.
								$tiempo_hora += $hora_fin-$hora_inicio;
								#Se agrega al tiempo hora el minuto fin menos el minuto inicio.
								$tiempo_minuto +=$minuto_fin-$minuto_inicio;
							}else{
								#De lo contrario se igualara la hora a la 13:30.
								$hora_inicio=config_get('hora_13');
								$minuto_inicio=config_get('minuto_30');
								#Se le agrega a el tiempo hora la resta entre la hora inicio y la hora fin.
								$tiempo_hora += $hora_fin-$hora_inicio;
								#Se agrega al tiempo hora el minuto fin menos el minuto inicio.
								$tiempo_minuto += $minuto_fin-$minuto_inicio;
							}
						}else{
							#si la hora inicio esta entre la 1:00 pm y la 6:00 pm
							if($hora_inicio>=config_get('hora_13')&& $hora_fin <= config_get('hora_18')){
								#si la hora de inicio es menor a la 1:30 pm
								if($hora_inicio == config_get('hora_13')&& $minuto_inicio <= 30){
									#se establece la hora de inicio
									$hora_inicio=config_get('hora_13');
									#se establece el minuto_inicio
									$minuto_inicio=config_get('minuto_30');
									#si la hora de inicio es igual a la hora fin
									if($hora_inicio== $hora_fin){
										#se calcula el tiempo en horas
										$tiempo_hora += $hora_fin-$hora_inicio;
										#Se agrega al tiempo hora el minuto fin menos el minuto inicio.
										$tiempo_minuto += $minuto_fin - $minuto_inicio;
									}
									#si el minuto inicio es mayor o igual a 30 se suma una hora mas.
									if($minuto_inicio>=30){
										#se aumenta la hora inicio.
										$hora_inicio++;
									}
									#si la hora inicio es igual a la hora fin
									if($hora_inicio== $hora_fin){
										##se realizan los calculos para verificar el tiempo transcurrido en el dia.
										$tiempo_hora += $hora_fin- $hora_inicio;
										$tiempo_minuto += config_get('minuto_60')-$minuto_inicio+ $minuto_fin;
									}else{
										##se realizan los calculos para verificar el tiempo transcurrido en el dia.
										$tiempo_hora += $hora_fin-$hora_inicio;
										$tiempo_minuto += config_get('minuto_60')-$minuto_inicio+ $minuto_fin;
									}

								}else{
									#si la hora inicio es mayor a la 1:30 pm
									if ($hora_inicio== config_get('hora_13')&& $minuto_inicio > 30){
										#se aumenta la hora de inicio
										$hora_inicio++;
										#si la hora inicio es igual a la hora fin
										if($hora_inicio== $hora_fin){
											##se realizan los calculos para verificar el tiempo transcurrido en el dia.
											$tiempo_hora += $hora_fin- $hora_inicio;
											$tiempo_minuto += config_get('minuto_60')-$minuto_inicio+ $minuto_fin;
										}else{
											#se realizan los calculos para verificar el tiempo transcurrido en el dia.
											$tiempo_hora += $hora_fin- config_get('hora_13');
											$tiempo_minuto += config_get('minuto_60')-$minuto_inicio+ $minuto_fin;
										}

									}else{
										##se realizan los calculos para verificar el tiempo transcurrido en el dia.
										$tiempo_hora += $hora_fin- config_get('hora_13');
										$tiempo_minuto += config_get('minuto_60')-$minuto_inicio+ $minuto_fin;
											
									}
										
								}
							}

						}
							
					}
				}else {
					#Requerimiento 847
					#Se modifica para que se tome en cuenta los dias festivos del a�o.
					#Preguntamos si los dias de diferencia son mayores a cero y menores o iguales a 1
					if($dias_transcurridos > 0 && $dias_transcurridos <=1){
						#Si estas condiciones se cumplen, preguntamos si el minuto de inicio es mayor a 0
						if ($minuto_inicio>0){
							#Si el minuto de inicio es mayor a 0 aumentamos la variable $hora_inicio.
							$hora_inicio++;
						}
						#Si la hora de inicio se encuentra entre las 8 a las 12
						if ($hora_inicio >= config_get('hora_8') && $hora_inicio <= config_get('hora_12')){
							#si la hora de inicio es igual a las 12 y el minuto de inicio es mayor a 30
							if ($hora_inicio == config_get('hora_12') && minuto_inicio > config_get('minuto_30')){
								#se iguala la hora a la 13:30 pm
								$hora_inicio= 13;
								$minuto_inicio=30;
								#se le agrega al tiempo hora la resta entre la hora fin del dia y la hora de inicio.
								$tiempo_hora +=  config_get('hora_18')-$hora_inicio;
								#se le agrega al tiempo minuto la restra entre el minuto fin de la hora y el minuto inicio.
								$tiempo_minuto += config_get('minuto_60')-$minuto_inicio;
							}else{
								#se realizan los calculos para verificar el tiempo transcurrido en el dia.
								$tiempo_hora += (config_get('hora_12')-$hora_inicio)+ (config_get('hora_18')-config_get('hora_13'));
								$tiempo_minuto += config_get('minuto_60')-$minuto_inicio;
							}
							#Si la hora de inicio se encuentra en horas de la tarde
						}else if ($hora_inicio >= config_get('hora_13') && $hora_inicio <= config_get('hora_18')){
							#si la hora de inicio se encuentra antes de las 13:30
							if ($hora_inicio == config_get('hora_13') && $minuto_inicio < config_get('minuto_30')){
								#se iguala el minuto inicio al minuto 30
								$minuto_inicio=config_get('minuto_30');
								#se realizan los calculos para verificar el tiempo transcurrido en el dia.
								$tiempo_hora += config_get('hora_18')-$hora_inicio;
								$tiempo_minuto += config_get('minuto_60')-$minuto_inicio;
							}else{
								##se realizan los calculos para verificar el tiempo transcurrido en el dia.
								$tiempo_hora += config_get('hora_18')-$hora_inicio;
								$tiempo_minuto += config_get('minuto_60')-$minuto_inicio;
							}
						}
						#si la hora fin se encuentra en el horario de la ma�ana
						if ($hora_fin>= config_get('hora_8') && $hora_fin <= config_get('hora_12')){
							#si la hora fin se encuentra entre las 12:30
							if ($hora_fin== 12 && $minuto_fin <=30){
								#se calculan los tiempos para verificar el tiempo transcurrido.
								$tiempo_hora += $hora_fin;
								$tiempo_minuto += $minuto_fin;
								#si la hora fin se enuentra en un horario mayor a las 12:30.
							}else if ($hora_fin==12 && $minuto_fin>=30){
								#se establece la hora fin  a las 12
								$hora_fin=config_get('hora_12');
								#se establece el minuto 30 como minuto fin.
								$minuto_fin=config_get('minuto_30');
								#se calculan los tiempos para verificar el tiempo transcurrido.
								$tiempo_hora += config_get('hora_12')-config_get('hora_8');
								$tiempo_minuto += $minuto_fin-$minuto_inicio;
							}else {
								#se calculan los tiempos para verificar el tiempo transcurrido.
								$tiempo_hora += $hora_fin-config_get('hora_8');
								$tiempo_minuto += $minuto_fin;
							}
						}
						#si la hora fin se encuentra entre el horario de la tarde
						if ($hora_fin>= config_get('hora_13')&& $hora_fin<= config_get('hora_18')){
							#si la hora fin se encuentra en un horario menor a las  13:30
							if($hora_fin== config_get('hora_13')&& $minuto_fin<= config_get('minuto_30')){
								#se establece la hora fin a las 12:30
								$hora_fin= config_get('hora_12');
								$minuto_fin= config_get('minuto_30');
								#se calculan los tiempos para verificar el tiempo transcurrido.
								$tiempo_hora+= $hora_fin;
								$tiempo_minuto += $minuto_fin;
							}else {
								#se calculan los tiempos para verificar el tiempo transcurrido.
								$tiempo_hora += (config_get('hora_12')- config_get('hora_8'))+ ($hora_fin-config_get('hora_13'));
								$tiempo_minuto += $minuto_fin;
							}
						}
					}else {
						#Requerimiento 847
						#Se modifica para que se tome en cuenta los dias festivos del a�o.
						#Preguntamos si los dias de diferencia son mayores a 1
						if ($dias_transcurridos>1){
							#Si esta condici�n se cumple, preguntamos si el minuto de inicio es mayor a 0
							if ($minuto_inicio>0){
								#Si el minuto de inicio es mayor a 0 aumentamos la variable $hora_inicio.
								$hora_inicio++;
							}
							#Si la hora inicio es en la ma�ana
							if ($hora_inicio >= config_get('hora_8') && $hora_inicio <= config_get('hora_12')){
								#si la hora inicio es mayor a las 12:30
								if ($hora_inicio == config_get('hora_12') && minuto_inicio > config_get('minuto_30')){
									#se establece la hora inicio.
									$hora_inicio= 13;
									$minuto_inicio=30;
									#se calculan los tiempos para verificar el tiempo transcurrido.
									$tiempo_hora +=  config_get('hora_18')-$hora_inicio;
									$tiempo_minuto += config_get('minuto_60')-$minuto_inicio;
								}else{
									#se calculan los tiempos para verificar el tiempo transcurrido.
									$tiempo_hora += (config_get('hora_12')-$hora_inicio)+ (config_get('hora_18')-config_get('hora_13'));
									$tiempo_minuto += config_get('minuto_60')-$minuto_inicio;
								}
								#si la hora inicio se encuentra en la tarde
							}else if ($hora_inicio >= config_get('hora_13') && $hora_inicio <= config_get('hora_18')){
								#si la hora inicio es menor a la 13:30
								if ($hora_inicio == config_get('hora_13') && $minuto_inicio < config_get('minuto_30')){
									#se establece el minuto de inicio.
									$minuto_inicio=config_get('minuto_30');
									#se calculan los tiempos para verificar el tiempo transcurrido.
									$tiempo_hora += config_get('hora_18')-$hora_inicio;
									$tiempo_minuto += config_get('minuto_60')-$minuto_inicio;
								}else{
									#se calculan los tiempos para verificar el tiempo transcurrido.
									$tiempo_hora += config_get('hora_18')-$hora_inicio;
									#si el minuto de inicio es igual a cero.
									if ($minuto_inicio==0){
										#se calculan los tiempos para verificar el tiempo transcurrido.
										$tiempo_minuto+= $minuto_inicio;
									}else{
										#se calculan los tiempos para verificar el tiempo transcurrido.
										$tiempo_minuto +=config_get('minuto_60')- $minuto_inicio;
									}
								}
							}
							#si la hora fin se encuentra en el horario de la ma�ana.
							if ($hora_fin>= config_get('hora_8') && $hora_fin <= config_get('hora_12')){
								#si la hora fin esta en un horario menor a las 12:30
								if ($hora_fin== 12 && $minuto_fin <=30){
									#se calculan los tiempos para verificar el tiempo transcurrido.
									$tiempo_hora += $hora_fin;
									$tiempo_minuto += $minuto_fin;
									#si la hora fin se encuentra en un horario mayor a las 12:30
								}else if ($hora_fin==12 && $minuto_fin>=30){
									#se establece la hora fin.
									$hora_fin=config_get('hora_12');
									$minuto_fin= config_get('minuto_30');
									#se calculan los tiempos para verificar el tiempo transcurrido.
									$tiempo_hora += config_get('hora_12')-config_get('hora_8');
									$tiempo_minuto += $minuto_fin;
								}else {
									#se calculan los tiempos para verificar el tiempo transcurrido.
									$tiempo_hora += $hora_fin-config_get('hora_8');
									$tiempo_minuto += $minuto_fin;
								}
							}
							#si la hora fin se encuentra en el horario de la tarde.
							if ($hora_fin>= config_get('hora_13')&& $hora_fin<= config_get('hora_18')){
								#si la hora fin es menor a las 13:30
								if($hora_fin== config_get('hora_13')&& $minuto_fin<= config_get('minuto_30')){
									#se establece la hora fin.
									$hora_fin= config_get('hora_12');
									$minuto_fin= config_get('minuto_30');
									#se calculan los tiempos para verificar el tiempo transcurrido.
									$tiempo_hora+= $hora_fin;
									$tiempo_minuto += $minuto_fin;
								}else {
									#se calculan los tiempos para verificar el tiempo transcurrido.
									$tiempo_hora += (config_get('hora_12')- config_get('hora_8'))+ ($hora_fin-config_get('hora_13'));
									$tiempo_minuto += $minuto_fin;
								}
							}
							#realizamos el calculo entre los dias de diferencia y los dias laborables.
							$diastotal=$dias_diferencia-$laborables;
							#al valor tiempo hora le sumamos los dias de totales laborados - 1 y estos dias de diferencia
							#los multiplicamos por 24.
							$tiempo_hora += ($diastotal-1)* config_get('hora_9');
							#al tiempo hora le sumamos el valor de la hora fin.
						}
					}
				}
			}
		}
		#Declaramos la variable tipo Array
		#en la que se almacenar� el resultado obtenido en horas y minutos.
		$tiempo_total=array();
		#Se almacena en la variable $tiempos el valor de las horas y los minutos.
		$tiempo_total['hora']=$tiempo_hora;
		$tiempo_total['minuto']=abs($tiempo_minuto);
		#Retornamos el array con los valores obtenidos.
		return $tiempo_total;
	}	
	
	/**
	 * Reqto 847
	 * M�todo que sirve para Calcular tiempo teniendo en cuenta los d�as y horarios h�biles (de 8 a 6 de la tarde)
	 * tambien calcula el tiempo desde que se asigna la incidencia hasta que la incidencia se encuentra en un estado diferenta a 
	 * cerrada, se necesitan mas datos, resuelta o nueva
	 * cerrada.
	 * @param $fecha_inicio
	 * @param $fecha_fin
	 */
	function horas_reales_incidencias($hora, $minutos)
	{
		$tiempos = array();	 	
	 	#Si la hora es menos a 08:00 AM, se igualar� la hora a las 08:00 AM.
	 	if ($hora < 8) {
	 		#Si los minutos son mayores a cero se igualar�n a cero.
	 		if ($minutos > 0) {
	 			$minutos = 0;
	 		}
	 		#Indicamos que la hora son las 08:00 AM
	 		$hora = 8;
	 		$tiempos['minutos'] = $minutos;
	 		$tiempos['hora'] = $hora;
	 	} else {
	 		#Si la hora esta entre las 12:00 M y 13:00 PM 
	 		#se preguntara por la media hora inicial habil
	 		if ($hora >= 12 && $hora < 13) {
	 			#Si los minutos son mayores a cero y menores o iguales a 30 se asigna a la variable minutos
	 			if ($minutos > 0 && $minutos <= 30) {
	 				$minutos = $minutos;
	 			}
	 			
	 			#Indicamos que la hora son la 13:00 PM
	 			//$hora = 13;
	 			$tiempos['minutos'] = $minutos;
	 			$tiempos['hora'] = $hora;
	 		} else {
	 			#Preguntamos si la hora esta entre la 1 y la 1:30 para bno tenerla en cuenta.
				if ($hora == 13 && $minutos <= 30)
	 			{
	 				$minutos = 0;
	 			}
	 			#Si la hora es mayor a 18:00 PM, se igualar� la hora a
	 			#las 18:00 PM
	 			if ($hora >= 18) {
	 				#Si los minutos son mayores a cero se igualar�n a cero.
	 				if ($minutos > 0) {
	 					$minutos = 0;
	 				}
	 				#Indicamos que la hora son la 18:00 PM
	 				$hora = 18;
	 				$tiempos['minutos'] = $minutos;
	 				$tiempos['hora'] = $hora;
	 			} else {
	 				#Si la hora no sobrepasa el horario permitido, entonces
	 				#almacenmos la hora y los minutos tal y como llegaron al
	 				#m�todo
	 				$tiempos['hora'] = $hora;
	 				$tiempos['minutos'] = $minutos;
	 			}
	 		}
	 	}
	 	return $tiempos;
	}
	
	#Rqto_929 - ayoung
	#Se reutiliza este m�todo para obtener las notas de cada
	#incidencia para el proyecto Cliente COLPENFAB
	/**
	 * jatellez	rqto 909
	 * M�todo para obtener las notas de cada incidencia
	 * @param $t_row
	 */
	function get_datos_notas ($t_row) {
		#Se asigna la tabla en la cual se realizar� la consulta.
		$tabla_incidencia = db_get_table('bugnote');
		$tabla_nota= db_get_table('bugnote_text');
		#Se genera la consulta a la base de datos.
	 	$query = "SELECT notext.*,bugnot.*
	 				FROM $tabla_nota as notext,$tabla_incidencia as bugnot
					WHERE bugnot.bugnote_text_id=notext.id and bugnot.bug_id=" . db_param()." order by notext.id";
	  	#Se asigna el resultado de la consulta enviando el parametro.
	 	$result = db_query($query, Array($t_row));
		#Se cuenta el numero de historiales del resultado.
	 	$count = db_num_rows( $result );
		#Declaramos el array donde se almacenar�n las notas de cada incidencia
		$notas = array();
		#Recorremos el historial obtenido por la consulta.
		for ( $i = 0; $i < $count; $i++ ) {
			#Obtenemos linea por linea los resultados arrojados de la consulta
			$t_rows = db_fetch_array( $result );
			#Guardamos cada valor obtenido de la consulta en el array 
			#de notas.
			$notas[$i]['note'] = $t_rows['note'];	
			$notas[$i]['id'] = $t_rows['id'];
			$notas[$i]['date_submitted'] = $t_rows['date_submitted'];
			$notas[$i]['last_updated'] = $t_rows['last_updated'];
			$notas[$i]['bugnote_text_id'] = $t_rows['bugnote_text_id'];
			
		}
		#retornamos el array de las notas
		return $notas;
	}
	#Rqto_929 - ayoung
	#Se reutiliza este m�todo para obtener la informaci�n
	#de un usuario para el proyecto Cliente COLPENFAB
	/**
	 * jatellez rqto 909
	 * M�todo que retorna la informaci�n de un usuario
	 * @param unknown_type $usuario
	 */
	function get_usuario ($usuario) {
		#Tabla donde se almacenan los usuarios.
	 	$tabla_usuario = db_get_table('user');
	 	#consulta para obtener el acceso de un usuario.
	 	$query = "SELECT * FROM $tabla_usuario WHERE id = " . db_param();
	 	#Ejecutamos la consulta y pasamos el parametro del id de usuarios.
	 	$result = db_query($query, Array($usuario));
	 	#retornamos el nivel de acceso del usuario.
	 	return $result->fields;
	 }
	#Rqto_929 - ayoung
	#Se reutiliza este m�todo para obtener las 
	#incidencia para el proyecto Cliente COLPENFAB
	 /**
	  * jatellez rqto 909
	  * M�todo que obtiene las incidencias de un proyecto
	  * @param $t_row
	  */
	 function get_incidencias($t_row) {
		#tabla que guarda las incidencias.
	 	$tabla_incidencia = db_get_table('bug');
		#se crea el array de incidencias
		$t_incidencias = array();
		#se genera la consulta para obtener las incidencias		
		$query="SELECT *
			    FROM $tabla_incidencia WHERE project_id=". db_param();
		$result = db_query($query, Array($t_row));
		#Se cuenta el numero de incidencias del resultado.
		$count = db_num_rows( $result );
		#Recorremos las incidencias obtenidas por la consulta.
		for ( $i = 0; $i < $count; $i++ ) {
			#Obtenemos linea por linea los resultados arrojados de la consulta
			$t_rows = db_fetch_array( $result );
			#Guardamos cada valor obtenido de la consulta en el array
			#de incidencias.
			$t_incidencias[$i]['id'] = $t_rows['id'];
			$t_incidencias[$i]['bugnote_text_id'] = $t_rows['bugnote_text_id'];
			$t_incidencias[$i]['project_id'] = $t_rows['project_id'];	
			$t_incidencias[$i]['reporter_id'] = $t_rows['reporter_id'];
			$t_incidencias[$i]['handler_id'] = $t_rows['handler_id'];
			$t_incidencias[$i]['duplicate_id'] = $t_rows['duplicate_id'];		
		}
			#retornamos el array de las incidencias
			return $t_incidencias;
	}
	#Rqto_929 - ayoung
	#Se reutiliza este m�todo para obtener los proyectos
	/**
	 * jatellez rqto 909
	 * M�todo que retorna todos los proyectos
	 */
	function get_proyectos () {
		#Tabla donde se almacenan los proyectos.
		$tabla_proyecto = db_get_table('project');
		#array para almacenar los proyectos
		$t_projects=array();
		#consulta para obtener todos lso proyectos.
		$query = "SELECT id FROM $tabla_proyecto " ;
		$result = db_query($query);
		#obtenemos el n�mero de filas de la consulta
		$t_row_count = db_num_rows( $result );
		#recorremos los proyectos
		for( $i = 0;$i < $t_row_count;$i++ ) {
			#obtenemos la informaci�n de cada proyecto
			$row = db_fetch_array( $result );
			#agregamos el proyecto obtenido al array
			$t_projects[] = $row;
		}
		return $t_projects;
	}
	
	/**
	 * jatellez rqto 909
	 * M�todo que retorna las notas de cada incidencia del proyecto RUNT-2
	 */
	function notas_inc(){
		#variable global que identifica el proyecto RUNT-2
		$t_id_project=config_get('id_proyecto_RUNT_2');
		#array que guarda las incidencias del proyecto RUNT-2
		$array_inc=get_incidencias($t_id_project);
		$mayor=0;
		session_start();
//		$_SESSION['variableTerminal']="0"; 
		#se v�lida si el array es diferente de null
		if($array_inc!=null){
			#se crea array para almacenar las notas de la incidencia
			$array_notas=array();
			
			#recorremos el array de las incidencias
			for( $i = 0;$i <sizeof($array_inc);$i++ ) {
				
				#le enviamos cada incidencia para que traiga sus respectivas notas
				$array_notas= get_datos_notas ($array_inc[$i]['id']);
				#retornamos el array de notas
				$count=count($array_notas);
				if($count>$mayor){
				$mayor=$count;
				}
				
			}
			return $mayor;
		}else{
			return $mayor;
		}

	}
	
	/**
	 * ayoung - Rqto_929
	 * M�todo que retorna las notas de cada incidencia del proyecto 
	 * Cliente COLPENSIONES F�BRICA
	 */
	function notas_inc_colpenfab(){
		#variable global que identifica el proyecto colpenfab
		$t_id_project=config_get('proyecto_colpenfab');
		#array que guarda las incidencias del proyecto colpenfab
		$array_inc=get_incidencias($t_id_project);
		$mayor=0;
		session_start();
//		$_SESSION['variableTerminal']="0"; 
		#se v�lida si el array es diferente de null
		if($array_inc!=null){
			#se crea array para almacenar las notas de la incidencia
			$array_notas=array();
			
			#recorremos el array de las incidencias
			for( $i = 0;$i <sizeof($array_inc);$i++ ) {
				
				#le enviamos cada incidencia para que traiga sus respectivas notas
				$array_notas= get_datos_notas ($array_inc[$i]['id']);
				#retornamos el array de notas
				$count=count($array_notas);
				if($count>$mayor){
				$mayor=$count;
				}
				
			}
			return $mayor;
		}else{
			return $mayor;
		}

	}
	#ayoung - Rqto_929
	#Se reutiliza este m�todo para obtener el mayor n�mero de notas
	#de las incidencias del proyecto actual.
	/**
	 * jatellez rqto 909
	 * m�todo que se encarga de hallar el mayor n�mero de notas
	 * de las incidencias del proyecto actual
	 */
	function mayor_notas(){
		session_start(); 
		$variable_filtro=$_SESSION['variableFiltro'];
		#contamos cuantas filas retorna ese m�todo
		#que equivale a la cantidad de incidencias que estan filtradas
 		$count_res=count($variable_filtro);
 		#inicializamos en 0, la variable que almacenar� el mayor
 		#n�mero de notas de las incidencias del proyecto RUNT-2
 	 	$mayor=0;
 	 	#v�lidamos que hayan al menos 1 nota para seguir
 	    if($count_res>0){
 	 	#recorremos las notas obtenidas
 		   for ($i = 0; $i < $count_res; $i++) {
 			 $t=$variable_filtro[$i];
 			 #guardamos en una variable las notas
 			 $array_notas= get_datos_notas ($t->id);
			 #contamos las notas que se obtiene de cada incidencia	
			 $count=count($array_notas);
			 #validamos, si la cantidad de notas obtenida es mayor
			 #a la variable mayor
			 if($count>$mayor){
			 	#asignamos el valor de las notas obtenidas a la 
			 	#variable mayor
				$mayor=$count;
			 }
 		}
 		return $mayor;
 	 }else 
 		return $mayor;
	}
		
	/**
	 * dbetancourt
	 * Reqto 890
	 * M�todo que obtiene el nivel de acceso del usuario al aplicativo.
	 * @param $reporter_id
	 */
	function consulta_usuario($reporter_id){

		#Se asigna la tabla en la cual se realizar� la consulta.
		$tabla_usuario = db_get_table('user');
		#Se genera la consulta a la base de datos.
	 	$query = "SELECT acceso
	 				 FROM $tabla_usuario 
	 				 	WHERE username = " . db_param();
	  	#Se asigna el resultado de la consulta enviando el parametro.
	 	$result = db_query($query, Array($reporter_id));
		$t_rows = db_fetch_array( $result );
		return $t_rows;
	}
	
	/**
	 * Rqto_970 - ayoung.
	 * M�todo que permite obtener la �ltima fecha en que una incidencia paso a 
	 * estado cerrado por una persona de HBT.
	 * @param $historial historial de la incidencia.
	 */
	function get_ultima_fecha_estado_cerrada($historial) {
		#obtenemos el tama�o del array
		$count_his = count($historial);
		$fecha_resuleta = '';
		#recorremos el arreglo de historias de la incidencia
		for( $j = 0; $j < $count_his; $j++ ) {
			#Obtenemos la historia en la posici�n i
			$history = $historial[$j];
			#Verificamos que el campo modificado sea estado.
			if ($history['nombre_campo'] == config_get('estado')) {
				#verificamos que el nuevo valor sea cerrad.
				if ($history['new_value'] == config_get('estado_cerrado')) {
					#Ahora verificamos que el cambio lo haya echo una persona 
					#externa a HBT, usuario tipo cliente (MD5)
					$tipo_usuario = get_tipo_usuario($history['usuario']);
					if ($tipo_usuario['acceso'] == config_get('usuario_MD5')) {
						#Obtenemos la fecha.
						$fecha_resuleta = $history['fecha'];
					}
				}
			}
		}
		#Retornamos la fecha obtenida del historial.
		return $fecha_resuleta;
	}
	
	/**
	 * Rqto_977 - ayoung
	 * Funci�n con la cual se registrar� la(s) incidencia(s)
	 * cerradas/corregidas asociadas en una incidencia con la parametrizaci�n de
	 * Reapertura Error = SI
	 * @param $bug_id
	 * @param $incidences
	 */
	function associate_reopened_bug_to_bug($bug_id, $incidences){ 
		$t_mantis_associated_bug_reopening_table = 'mantis_associated_bug_reopening_table';
		$query = "INSERT INTO $t_mantis_associated_bug_reopening_table
						 ( created_bug_id, reopening_id )
							 VALUES (" . db_param() . ', ' . db_param() . ')';
		db_query( $query, Array( $bug_id, $incidences ) );
	}
	
	/**
	 * Rqto_977 - ayoung
	 * Funci�n con la cual se actualizar� la(s) incidencia(s)
	 * cerradas/corregidas asociadas en una incidencia con la parametrizaci�n de
	 * Reapertura Error = SI
	 * @param $bug_id
	 * @param $incidences
	 */
	function update_reopened_bug_to_bug($bug_id, $incidences){
		$t_mantis_associated_bug_reopening_table = 'mantis_associated_bug_reopening_table';
		$query = "UPDATE $t_mantis_associated_bug_reopening_table
							SET reopening_id=" . db_param() . "
							WHERE created_bug_id=" . db_param();
		db_query( $query, Array( $incidences, $bug_id ) );
	}
	
	/**
	 * Rqto_977 - ayoung
	 * Funci�n con la cual se Eliminar� la(s) incidencia(s) asociadas como reapertura error
	 * @param $bug_id
	 * @param $incidences
	 */
	function delete_reopened_bug_to_bug($bug_id){
		$t_mantis_associated_bug_reopening_table = 'mantis_associated_bug_reopening_table' ;
		$query = "DELETE FROM $t_mantis_associated_bug_reopening_table							
							WHERE created_bug_id=" . db_param();
		db_query( $query, Array( $bug_id ) );
	}
	
	/**
	 * Rqto_977 - ayoung
	 * Funci�n con la cual se obtendr� la(s) incidencia(s)
	 * cerradas/corregidas asociadas en una incidencia con la parametrizaci�n de
	 * Reapertura Error = SI
	 * @param $bug_id
	 * @param $incidences
	 */
	function get_reopened_bug_to_bug($bug_id){
		$t_mantis_associated_bug_reopening_table = 'mantis_associated_bug_reopening_table';
		$query = "SELECT reopening_id FROM $t_mantis_associated_bug_reopening_table
							WHERE created_bug_id=" . db_param();
		$result = db_query( $query, Array( $bug_id ) );
		return db_result( $result );
	}
	
	
	function consultar_project($project_id){
		
		$t_mantis_project = db_get_table('project');
		$query= "SELECT name FROM $t_mantis_project
					WHERE id=" .db_param();
		
		$result = db_query($query, Array ($project_id));
		return db_result($result);
		
	}

	function validar_fechas_entregas_crear ($bug, $update = false) {
	
		// Verificamos que la fecha planeada tenga una estructura correcta.
		validar_fecha_estructura($bug->date_year_planned_791, $bug->date_mounth_planned_791, 
			$bug->date_day_planned_791, lang_get('planned_date_791') );
			
		// Verificamos que la fecha real tenga una estructura correcta.
		validar_fecha_estructura($bug->date_year_real_791, $bug->date_mounth_real_791, 
			$bug->date_day_real_791, lang_get('real_date_791') );
			
		// Verificamos si la fecha planeada es laborable.
		validar_fecha_no_laborable($bug->date_year_planned_791, $bug->date_mounth_planned_791, 
			$bug->date_day_planned_791, lang_get('planned_date_791') );
		
		// Verificamos si la fecha real es laborable.
		validar_fecha_no_laborable($bug->date_year_real_791, $bug->date_mounth_real_791, 
			$bug->date_day_real_791, lang_get('real_date_791') );
			/*
			 * Requerimiento 795
			 * Se comento este bloque de codigo por el requerimiento 795, que especifica
			 * que no es necesario hacer la validaci�n de la fecha planeada, donde
			 * se evitaba anteriormente que se ingresaran fechas planeadas menores
			 * a la fecha m�s alta del sistema
			 */
	//	// si la fecha esta vacia, osea sus campos son 0 no se ejecutar� la consulta de saber 
	//	// si la fecha planeada es menor a la fecha planeada mayor del sistema.	

		/*
		  * Fin requerimiento 795.
		  * Bloque comentado. 
		 */
	
		/*
		 * En caso de que se llame este m�todo desde la validaci�n de las fechas 
		 * al momento de editar una entrega, har� falta validar las fechas de 
		 * devoluci�n y causa de la devoluci�n.
		 */
		if ($update) {
			//Validamos que la fecha de devoluci�n tenga la estructura correcta.
			validar_fecha_estructura($bug->date_year_return_791, $bug->date_mounth_return_791,
			$bug->date_day_return_791, lang_get('return_date_791'));
			
			//Validamos que la fecha real tenga la estructura correcta.
			validar_fecha_estructura($bug->date_year_real_791, $bug->date_mounth_real_791,
			$bug->date_day_real_791, lang_get('real_date_791'));
	
			//Validamos que la fecha real sea un d�a laborable.
			validar_fecha_no_laborable($bug->date_year_real_791, $bug->date_mounth_real_791,
			$bug->date_day_real_791, lang_get('real_date_791'));
			
	
			//Validamos que la fecha de devoluci�n sea un d�a laborable.
			validar_fecha_no_laborable($bug->date_year_return_791, $bug->date_mounth_return_791,
			$bug->date_day_return_791, lang_get('return_date_791'));
	
			/*
			 * Si la fecha planeada no esta vacia, osea sus campos son mayores a cero (0),
			 * se va a verificar que no se tenga fecha ni causa de devoluci�n en caso de
			 * no tener una fecha real.
			 */
			if ($bug->date_year_planned_791 > 0 && $bug->date_mounth_planned_791 > 0
			&& $bug->date_day_planned_791 > 0) {			
				/*
				 * Si la fecha real no esta vacia, osea sus campos son mayores a cero (0),
				 * se va a verificar que no se tenga fecha ni causa de devoluci�n en caso de
				  * no tener una fecha real.
				 */
				if ($bug->date_year_real_791 > 0 && $bug->date_mounth_real_791 > 0
				&& $bug->date_day_real_791 > 0) {				
					/*
					 * Si la fecha de devoluci�n no esta vacia, osea sus campos son mayores a cero (0),
					 * se van a comparar que la fecha de devoluci�n sea mayor o igual a la fecha real
					 * de la entrega actual
					 */
					if ($bug->date_year_return_791 > 0 && $bug->date_mounth_return_791 > 0
					&& $bug->date_day_return_791 > 0) {
						/*
						 * Coparamos que la fecha de de devoluci�n de la nueva entrega sea mayor o
						 * igual a la fecha real de la entrega.
						 */
						comprar_fechas($bug->date_year_real_791, $bug->date_mounth_real_791,
						$bug->date_day_real_791, $bug->date_year_return_791, $bug->date_mounth_return_791,
						$bug->date_day_return_791 , lang_get('error_real_mayor_devolucion'));
						/*
						 * Si hay una fecha de devoluci�n, necesariomente debe haber una causa
						 * de devoluci�n, de lo contario habr� un errror.
						 */
						if (is_blank($bug->cause_return_791)) {
							trigger_error((lang_get('error_devolucion_sin_causa')),ERROR);
						}
					} else {
						/*
						 * No se puede tener una causa de devoluci�n si no se tiene
						 * una fecha de devoluci�n.
						 */
						if (!is_blank($bug->cause_return_791)) {
							trigger_error((lang_get('error_causa_sin_devolucion')),ERROR);
						}
					}
				} else {
					/*
					 * No se podr� ingresar una fecha de devoluci�n sin tener una fecha real.
					 */
					if ($bug->date_year_return_791 > 0 && $bug->date_mounth_return_791 > 0
					&& $bug->date_day_return_791 > 0) {
						trigger_error(lang_get('error_devolucion_sin_planeada'),ERROR);
					}
					/*
					 * No se puede tener una causa de devoluci�n si no se tiene
					 * una fecha real.
					 */
					if (!is_blank($bug->cause_return_791)) {
						trigger_error((lang_get('error_causa_sin_real')),ERROR);
					}
				}
			} else {
				/*
				 * No se podr� ingresar una una fecha real sin tener una fecha planeada.
				 */
				if ($bug->date_year_real_791 > 0 && $bug->date_mounth_real_791 > 0
				&& $bug->date_day_real_791 > 0) {
					trigger_error(lang_get('error_real_sin_planeada'),ERROR);
				}
				/*
				 * No se podr� ingresar una fecha de devoluci�n sin tener una fecha planeadaa.
				 */
				if ($bug->date_year_return_791 > 0 && $bug->date_mounth_return_791 > 0
				&& $bug->date_day_return_791 > 0) {
					trigger_error(lang_get('error_devolucion_sin_planeada'),ERROR);
				}
				/*
				 * No se puede tener una causa de devoluci�n si no se tiene una
				 * fecha planeada
				 */
				if (!is_blank($bug->cause_return_791)) {
					trigger_error((lang_get('error_causa_sin_planeada')),ERROR);
				}				
			}
		}
		
	}

/**
 * Requerimiento 791.
 * 
 * Este m�todo se encarga de mostrar el error al momento de crear una entrega
 * con una fecha planeada por debajo de la maxima del sistema.
 * @param $dia
 * @param $mes
 * @param $anio
 */
function error_fecha_planeada_menor_a_posible($dia, $mes, $anio){
	$dia_maximo = string_display_line( get_enum_element('date_day_791',$dia ));
	$mes_maximo = string_display_line( get_enum_element('date_mounth_791',$mes ));
	$anio_maximo = string_display_line( get_enum_element('date_year_791',$anio ));
	trigger_error('La fecha planeada del entregable es menor a la fecha maxima planeada del 
	sistema: '.$dia_maximo.'/'.$mes_maximo.'/'.$anio_maximo, ERROR );
}


/**
 * Requerimiento 791.
 * 
 * M�todo que valida si una fecha dada en a�o-mes-dia corresponde
 * a una fecha que no es laborable.
 * 
 * De encontrarse que es una fecha no laborable se mostrar� un mensaje 
 * donde se indica que la fecha $campo_fecha es un d�a no laborable.
 * @param $year a�o de la fecha
 * @param $mounth mes de la fecha
 * @param $day d�a de la fecha
 * @param $campo_fecha fecha que se esta 
 * 		analizando (planned_date_791, real_date_791, return_date_791)
 */
function validar_fecha_no_laborable ($year, $mounth, $day, $campo_fecha){
	// la tabla en la que se almacenan los d�as festivos de 
	// todos los a�os.
	$tabla_holiday = 'mantis_holiday_table';
	// obtenemos los valores reales de los datos que llegan al m�todo
	$anio = string_display_line( get_enum_element('date_year_791',$year ));
	$mes = string_display_line( get_enum_element('date_mounth_791',$mounth ));
	$dia = string_display_line( get_enum_element('date_day_791',$day ));
	//En esta consulta determinamos si la fecha que llega al m�todo, corresponde 
	// a un d�a no laborable
	$query = "select holiday_desc from $tabla_holiday 
		where year(holiday_date) = " . db_param() . " and 
		month(holiday_date) = " . db_param() ." and 
		day(holiday_date) = " . db_param();
	// ejectuamos la consulta y env�amos los valores.
	$result = db_query( $query, Array($anio, $mes, $dia));
	// Contamos cuantos registros arrojo la consulta
	$count = db_num_rows( $result );
	// Si encontramos que hay un registro que conincide con nuestra fecha
	// mostramos error por tratarse de un d�a festivo.
	if ($count > 0) {
		config_get( 'handle_bug_threshold' );
		trigger_error('La ' . $campo_fecha . ' corresponde a un d&iacute;a no laborable', ERROR ); 
	}
	// Obtenemos el d�a fin del mes en el que estamo trabajando, para saber
	// si se registro un d�a mayor al maximo del mes.
	$fin = string_display_line( get_enum_element('fin_mes_791',$mounth ));	
	/*
	* Si el mes en el cual estamos trabajando es Febrero (2) se va a 
	* determinar si estamos en un a�o bisiesto o no (de 28 o 29 d�as).
	*/
	if ($mes == 2) {
		/*
		 * Son bisiestos todos los a�os divisibles por 4, excluyendo los que 
		 * sean divisibles por 100, pero no los que sean divisibles por 400.
		 */
		if (($anio % 4 == 0) && (($anio % 100 != 0) || ($anio % 400 == 0))) {
			/*
			 *  A los 28 d�as del mes de Febrero aumentamos un d�a para el a�o
			 *  bisiesto
			 */ 			
			 $fin ++;
		}
	}
	/* 
	 * Si el d�a que se registro es mayor al m�ximo del mes mostraremos un
	 * error indicando cual es el d�a m�ximo del mes de registro.
	 */
	if ($dia > $fin) {
		config_get( 'handle_bug_threshold' );
		trigger_error('La ' . $campo_fecha . ' corresponde a un d&iacute;a no 
			valido para el mes. El mes ' . $mes . ' s&oacute;lo llega hasta el d&iacute;a ' .  
			$fin . '', ERROR );
	}
	
	
	
}

/* Requerimiento 791
* M�todo que busca los datos adicionales de la entrega en la base de 
* datos 
* @param $p_bug_id id del la entrega
*/
function bug_entrega( $p_bug_id) {
   // Tabla a la que vamos a realizar la consulta de los datos de la entrega
   $t_mantis_bug_entrega = 'mantis_bug_entrega_table';
   // Consulta para obtener los datos de la entrega.
   $query = "SELECT *
			   FROM $t_mantis_bug_entrega
			   WHERE id_bug=" . db_param() ."";
   // Damos los parametros y ejecutamos la consulta.
   $result = db_query( $query, Array( $p_bug_id ) );
   return $result;
}

/**
* Requerimiento 791
* M�todo que busca las entregas de un entregable
* @param $p_bug_id id del la entrega
*/
function bug_entregas( $p_bug_id) {
   // Tabla a la que vamos a realizar la consulta de los datos de la entrega
   $t_mantis_bug_entrega = 'mantis_bug_entregas_table';
   // Consulta para obtener los datos de las entregas de un entregable.
   $query = " select fecha_planeada_dia, fecha_planeada_mes, fecha_planeada_anio,
   fecha_real_dia, fecha_real_mes, fecha_real_anio,  
   fecha_devolucion_dia, fecha_devolucion_mes, fecha_devolucion_anio, causa
   from $t_mantis_bug_entrega where id_bug = ". db_param() ."";
   // Damos los parametros y ejecutamos la consulta.
   $result = db_query( $query, Array( $p_bug_id ) );
   //N�mero de entregas que tiene un entregable.
   $entrega_count = db_num_rows( $result );
	// array donde guardaremos las entregas.
   $entrega = array();
   // Recorremos los resultados de la consulta.
   for( $i = 0, $j = 0;$i < $entrega_count;++$i ) {
	   // Obtenemos linea por lina los resultados arrojados de la consulta
	   $t_row = db_fetch_array( $result );
	   // Sacamos los valores de las columnas.
	   $v_dia_planeado = $t_row['fecha_planeada_dia'];
	   $v_mes_planeado = $t_row['fecha_planeada_mes'];
	   $v_anio_planeado = $t_row['fecha_planeada_anio'];
	   $v_dia_real = $t_row['fecha_real_dia'];
	   $v_mes_real = $t_row['fecha_real_mes'];
	   $v_anio_real = $t_row['fecha_real_anio'];
	   $v_dia_devolucion = $t_row['fecha_devolucion_dia'];
	   $v_mes_devolucion = $t_row['fecha_devolucion_mes'];
	   $v_anio_devolucion = $t_row['fecha_devolucion_anio'];
	   $v_causa = $t_row['causa'];
	   // Guardamos en el arreglo los datos de cada entrega
	   $entrega[$j]['fecha_planeada_dia'] = $v_dia_planeado;
	   $entrega[$j]['fecha_planeada_mes'] = $v_mes_planeado;
	   $entrega[$j]['fecha_planeada_anio'] = $v_anio_planeado;
	   $entrega[$j]['fecha_real_dia'] = $v_dia_real;
	   $entrega[$j]['fecha_real_mes'] = $v_mes_real;
	   $entrega[$j]['fecha_real_anio'] = $v_anio_real;
	   $entrega[$j]['fecha_devolucion_dia'] = $v_dia_devolucion;
	   $entrega[$j]['fecha_devolucion_mes'] = $v_mes_devolucion;
	   $entrega[$j]['fecha_devolucion_anio'] = $v_anio_devolucion;
	   $entrega[$j]['causa'] = $v_causa;		
	   $j++;
   }
   // Retornamos el arreglo con las entregas del entregable.
   return $entrega;
}

/**
* 
* Requerimiento 791.
* Se pasa el n�mero de horas registradas como duraci�n a cantidad de d�as,
* seg�n el n�mero de horas laborables diarias en la variable global "global_horas_trabajo".
* Se tomara una (1) hora como 1 d�a entero, por lo que 9 horas har�n 2 d�as.
* @param $duration_hours
*/
function bug_horas_dias_entregable ($duration_hours) {
   $duration_days = $duration_hours / (config_get('global_horas_trabajo'));
   
   $var= $duration_days;
   $partes = explode(".",$var);
   if ($partes[1] != 0) {
	   $var = $partes[0] + 1;
   }
   return $var;
} 
// FIN ADD HBT 