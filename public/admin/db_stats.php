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
 * @package MantisBT
 * @copyright Copyright (C) 2000 - 2002  Kenzaburo Ito - kenito@300baud.org
 * @copyright Copyright (C) 2002 - 2012  MantisBT Team - mantisbt-dev@lists.sourceforge.net
 * @link http://www.mantisbt.org
 */
/**
 * MantisBT Core API's
 */
require_once( dirname( dirname( __FILE__ ) ) . '/core.php' );

access_ensure_global_level( config_get_global( 'admin_site_threshold' ) );

html_page_top();

function print_info_row( $p_description, $p_value ) {
	echo '<tr ' . helper_alternate_class() . '>';
	echo '<th class="category">' . $p_description . '</th>';
	echo '<td>' . $p_value . '</td>';
	echo '</tr>';
}

# --------------------
function helper_table_row_count( $p_table ) {
	$t_table = $p_table;
	$query = "SELECT COUNT(*) FROM $t_table";
	$result = db_query_bound( $query );
	$t_count = db_result( $result );

	return $t_count;
}
?>
<table class="width75" cellspacing="1">
<tr>
<td class="form-title" width="30%" colspan="2"><?php echo lang_get( 'database_statistics' ) ?></td>
</tr>
<?php
	foreach( db_get_table_list() as $t_table ) {
		if( db_table_exists( $t_table ) ) {
			print_info_row( $t_table, helper_table_row_count($t_table) . ' records' );
		}
	}
?>
</table>
<?php

html_page_bottom();
