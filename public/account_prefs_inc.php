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
 *
 * @uses authentication_api.php
 * @uses config_api.php
 * @uses constant_inc.php
 * @uses event_api.php
 * @uses form_api.php
 * @uses helper_api.php
 * @uses html_api.php
 * @uses lang_api.php
 * @uses print_api.php
 * @uses user_api.php
 * @uses user_pref_api.php
 * @uses utility_api.php
 */

if ( !defined( 'ACCOUNT_PREFS_INC_ALLOW' ) ) {
	return;
}

use MantisBT\Exception\User\CannotModifyProtectedAccount;

require_api( 'authentication_api.php' );
require_api( 'config_api.php' );
require_api( 'constant_inc.php' );
require_api( 'event_api.php' );
require_api( 'form_api.php' );
require_api( 'helper_api.php' );
require_api( 'html_api.php' );
require_api( 'lang_api.php' );
require_api( 'print_api.php' );
require_api( 'user_api.php' );
require_api( 'user_pref_api.php' );
require_api( 'utility_api.php' );

function edit_account_prefs($p_user_id = null, $p_error_if_protected = true, $p_accounts_menu = true, $p_redirect_url = '') {
	if ( null === $p_user_id ) {
		$p_user_id = auth_get_current_user_id();
	}

	$t_redirect_url = $p_redirect_url;
	if ( is_blank( $t_redirect_url ) ) {
		$t_redirect_url = 'account_prefs_page.php';
	}

	# protected account check
	if ( user_is_protected( $p_user_id ) ) {
		if ( $p_error_if_protected ) {
			throw new CannotModifyProtectedAccount();
		} else {
			return;
		}
	}

	# prefix data with u_
	$t_pref = user_pref_get( $p_user_id );

# Account Preferences Form BEGIN
?>

<div id="account-prefs-update-div" class="form-container">
	<form id="account-prefs-update-form" method="post" action="account_prefs_update.php">
		<fieldset>
			<legend><span><?php echo _('Account Preferences') ?></span></legend>
			<?php echo form_security_field( 'account_prefs_update' ) ?>
			<input type="hidden" name="user_id" value="<?php echo $p_user_id ?>" />
			<input type="hidden" name="redirect_url" value="<?php echo $t_redirect_url ?>" />
		<?php
			if ( $p_accounts_menu ) {
				print_account_menu( 'account_prefs_page.php' );
			}
		?>
			<div class="field-container">
				<label for="default-project-id"><span><?php echo _('Default Project') ?></span></label>
				<span class="select">
					<select id="default-project-id" name="default_project">
						<?php print_project_option_list( (int)$t_pref->default_project ) ?>
					</select>
				</span>
				<span class="label-style"></span>
			</div>
			<div class="field-container">
				<label for="refresh-delay"><span><?php echo _('Refresh Delay') ?></span></label>
				<span class="input"><input id="refresh-delay" type="text" name="refresh_delay" size="4" maxlength="4" value="<?php echo $t_pref->refresh_delay ?>" /> <?php echo _('minutes') ?></span>
				<span class="label-style"></span>
			</div>
			<div class="field-container">
				<label for="redirect-delay"><span><?php echo _('Redirect Delay') ?></span></label>
				<span class="input"><input id="redirect-delay" type="text" name="redirect_delay" size="4" maxlength="3" value="<?php echo $t_pref->redirect_delay ?>" /> <?php echo _('seconds') ?></span>
				<span class="label-style"></span>
			</div>
			<fieldset class="field-container">
				<legend><span><?php echo _('Notes Sort Order') ?></span></legend>
				<span class="radio"><input id="bugnote-order-desc" type="radio" name="bugnote_order" value="DESC" <?php check_checked( $t_pref->bugnote_order, 'DESC' ); ?> /></span>
				<label for="bugnote-order-desc"><span><?php echo _('Descending') ?></span></label>
				<span class="radio"><input id="bugnote-order-asc" type="radio" name="bugnote_order" value="ASC" <?php check_checked( $t_pref->bugnote_order, 'ASC' ); ?> /></span>
				<label for="bugnote-order-asc"><span><?php echo _('Ascending') ?></span></label>
				<span class="label-style"></span>
			</fieldset>
			<?php if ( ON == config_get( 'enable_email_notification' ) ) { ?>
			<fieldset class="field-container">
				<legend><label for="email-on-new"><?php echo _('E-mail on New') ?></label></legend>
				<span class="checkbox"><input id="email-on-new" type="checkbox" name="email_on_new" <?php check_checked( (int)$t_pref->email_on_new, ON ); ?> /></span>
				<label for="email-on-new-min-severity" class="email-on-severity-label"><span><?php echo _('With Minimum Severity of') ?></span></label>
				<span class="select email-on-severity">
					<select id="email-on-new-min-severity" name="email_on_new_min_severity">
						<option value="<?php echo OFF ?>"><?php echo _('any') ?></option>
						<option disabled="disabled">-----</option>
						<?php print_enum_string_option_list( 'severity', (int)$t_pref->email_on_new_min_severity ) ?>
					</select>
				</span>
				<span class="label-style"></span>
			</fieldset>
			<fieldset class="field-container">
				<legend><label for="email-on-assigned"><?php echo _('E-mail on Change of Handler') ?></label></legend>
				<span class="checkbox"><input id="email-on-assigned" type="checkbox" name="email_on_assigned" <?php check_checked( (int)$t_pref->email_on_assigned, ON ); ?> /></span>
				<label for="email-on-assigned-min-severity" class="email-on-severity-label"><span><?php echo _('With Minimum Severity of') ?></span></label>
				<span class="select email-on-severity">
					<select id="email-on-assigned-min-severity" name="email_on_assigned_min_severity">
						<option value="<?php echo OFF ?>"><?php echo _('any') ?></option>
						<option disabled="disabled">-----</option>
						<?php print_enum_string_option_list( 'severity', (int)$t_pref->email_on_assigned_min_severity ) ?>
					</select>
				</span>
				<span class="label-style"></span>
			</fieldset>
			<fieldset class="field-container">
				<legend><label for="email-on-feedback"><?php echo _('E-mail on Feedback') ?></label></legend>
				<span class="checkbox"><input id="email-on-feedback" type="checkbox" name="email_on_feedback" <?php check_checked( (int)$t_pref->email_on_feedback, ON ); ?> /></span>
				<label for="email-on-feedback-min-severity" class="email-on-severity-label"><span><?php echo _('With Minimum Severity of') ?></span></label>
				<span class="select email-on-severity">
					<select id="email-on-feedback-min-severity" name="email_on_feedback_min_severity">
						<option value="<?php echo OFF ?>"><?php echo _('any') ?></option>
						<option disabled="disabled">-----</option>
						<?php print_enum_string_option_list( 'severity', (int)$t_pref->email_on_feedback_min_severity ) ?>
					</select>
				</span>
				<span class="label-style"></span>
			</fieldset>
			<fieldset class="field-container">
				<legend><label for="email-on-resolved"><?php echo _('E-mail on Resolved') ?></label></legend>
				<span class="checkbox"><input id="email-on-resolved" type="checkbox" name="email_on_resolved" <?php check_checked( (int)$t_pref->email_on_resolved, ON ); ?> /></span>
				<label for="email-on-resolved-min-severity" class="email-on-severity-label"><span><?php echo _('With Minimum Severity of') ?></span></label>
				<span class="select email-on-severity">
					<select id="email-on-resolved-min-severity" name="email_on_resolved_min_severity">
						<option value="<?php echo OFF ?>"><?php echo _('any') ?></option>
						<option disabled="disabled">-----</option>
						<?php print_enum_string_option_list( 'severity', (int)$t_pref->email_on_resolved_min_severity ) ?>
					</select>
				</span>
				<span class="label-style"></span>
			</fieldset>
			<fieldset class="field-container">
				<legend><label for="email-on-closed"><?php echo _('E-mail on Closed') ?></label></legend>
				<span class="checkbox"><input id="email-on-closed" type="checkbox" name="email_on_closed" <?php check_checked( (int)$t_pref->email_on_closed, ON ); ?> /></span>
				<label for="email-on-closed-min-severity" class="email-on-severity-label"><span><?php echo _('With Minimum Severity of') ?></span></label>
				<span class="select email-on-severity">
					<select id="email-on-closed-min-severity" name="email_on_closed_min_severity">
						<option value="<?php echo OFF ?>"><?php echo _('any') ?></option>
						<option disabled="disabled">-----</option>
						<?php print_enum_string_option_list( 'severity', (int)$t_pref->email_on_closed_min_severity ) ?>
					</select>
				</span>
				<span class="label-style"></span>
			</fieldset>
			<fieldset class="field-container">
				<legend><label for="email-on-reopened"><?php echo _('E-mail on Reopened') ?></label></legend>
				<span class="checkbox"><input id="email-on-reopened" type="checkbox" name="email_on_reopened" <?php check_checked( (int)$t_pref->email_on_reopened, ON ); ?> /></span>
				<label for="email-on-reopened-min-severity" class="email-on-severity-label"><span><?php echo _('With Minimum Severity of') ?></span></label>
				<span class="select email-on-severity">
					<select id="email-on-reopened-min-severity" name="email_on_reopened_min_severity">
						<option value="<?php echo OFF ?>"><?php echo _('any') ?></option>
						<option disabled="disabled">-----</option>
						<?php print_enum_string_option_list( 'severity', (int)$t_pref->email_on_reopened_min_severity ) ?>
					</select>
				</span>
				<span class="label-style"></span>
			</fieldset>
			<fieldset class="field-container">
				<legend><label for="email-on-bugnote-added"><?php echo _('E-mail on Note Added') ?></label></legend>
				<span class="checkbox"><input id="email-on-bugnote-added" type="checkbox" name="email_on_bugnote" <?php check_checked( (int)$t_pref->email_on_bugnote, ON ); ?> /></span>
				<label for="email-on-bugnote-min-severity" class="email-on-severity-label"><span><?php echo _('With Minimum Severity of') ?></span></label>
				<span class="select email-on-severity">
					<select id="email-on-bugnote-min-severity" name="email_on_bugnote_min_severity">
						<option value="<?php echo OFF ?>"><?php echo _('any') ?></option>
						<option disabled="disabled">-----</option>
						<?php print_enum_string_option_list( 'severity', (int)$t_pref->email_on_bugnote_min_severity ) ?>
					</select>
				</span>
				<span class="label-style"></span>
			</fieldset>
			<fieldset class="field-container">
				<legend><label for="email-on-status"><?php echo _('E-mail on Status Change') ?></label></legend>
				<span class="checkbox"><input id="email-on-status" type="checkbox" name="email_on_status" <?php check_checked( (int)$t_pref->email_on_status, ON ); ?> /></span>
				<label for="email-on-status-min-severity" class="email-on-severity-label"><span><?php echo _('With Minimum Severity of') ?></span></label>
				<span class="select email-on-severity">
					<select id="email-on-status-min-severity" name="email_on_status_min_severity">
						<option value="<?php echo OFF ?>"><?php echo _('any') ?></option>
						<option disabled="disabled">-----</option>
						<?php print_enum_string_option_list( 'severity', (int)$t_pref->email_on_status_min_severity ) ?>
					</select>
				</span>
				<span class="label-style"></span>
			</fieldset>
			<fieldset class="field-container">
				<legend><label for="email-on-priority-change"><?php echo _('E-mail on Priority Change') ?></label></legend>
				<span class="checkbox"><input id="email-on-priority-change" type="checkbox" name="email_on_priority" <?php check_checked( (int)$t_pref->email_on_priority , ON); ?> /></span>
				<label for="email-on-priority-min-severity" class="email-on-severity-label"><span><?php echo _('With Minimum Severity of') ?></span></label>
				<span class="select email-on-severity">
					<select id="email-on-priority-min-severity" name="email_on_priority_min_severity">
						<option value="<?php echo OFF ?>"><?php echo _('any') ?></option>
						<option disabled="disabled">-----</option>
						<?php print_enum_string_option_list( 'severity', (int)$t_pref->email_on_priority_min_severity ) ?>
					</select>
				</span>
				<span class="label-style"></span>
			</fieldset>
			<div class="field-container">
				<label for="email-bugnote-limit"><span><?php echo _('E-mail Notes Limit') ?></span></label>
				<span class="input"><input id="email-bugnote-limit" type="text" name="email_bugnote_limit" maxlength="2" size="2" value="<?php echo $t_pref->email_bugnote_limit ?>" /></span>
				<span class="label-style"></span>
			</div>
<?php } else { ?>
			<input type="hidden" name="email_on_new"      value="<?php echo $t_pref->email_on_new ?>" />
			<input type="hidden" name="email_on_assigned" value="<?php echo $t_pref->email_on_assigned ?>" />
			<input type="hidden" name="email_on_feedback" value="<?php echo $t_pref->email_on_feedback ?>" />
			<input type="hidden" name="email_on_resolved" value="<?php echo $t_pref->email_on_resolved ?>" />
			<input type="hidden" name="email_on_closed"   value="<?php echo $t_pref->email_on_closed ?>" />
			<input type="hidden" name="email_on_reopened" value="<?php echo $t_pref->email_on_reopened ?>" />
			<input type="hidden" name="email_on_bugnote"  value="<?php echo $t_pref->email_on_bugnote ?>" />
			<input type="hidden" name="email_on_status"   value="<?php echo $t_pref->email_on_status ?>" />
			<input type="hidden" name="email_on_priority" value="<?php echo $t_pref->email_on_priority ?>" />
			<input type="hidden" name="email_on_new_min_severity"      value="<?php echo $t_pref->email_on_new_min_severity ?>" />
			<input type="hidden" name="email_on_assigned_min_severity" value="<?php echo $t_pref->email_on_assigned_min_severity ?>" />
			<input type="hidden" name="email_on_feedback_min_severity" value="<?php echo $t_pref->email_on_feedback_min_severity ?>" />
			<input type="hidden" name="email_on_resolved_min_severity" value="<?php echo $t_pref->email_on_resolved_min_severity ?>" />
			<input type="hidden" name="email_on_closed_min_severity"   value="<?php echo $t_pref->email_on_closed_min_severity ?>" />
			<input type="hidden" name="email_on_reopened_min_severity" value="<?php echo $t_pref->email_on_reopened_min_severity ?>" />
			<input type="hidden" name="email_on_bugnote_min_severity"  value="<?php echo $t_pref->email_on_bugnote_min_severity ?>" />
			<input type="hidden" name="email_on_status_min_severity"   value="<?php echo $t_pref->email_on_status_min_severity ?>" />
			<input type="hidden" name="email_on_priority_min_severity" value="<?php echo $t_pref->email_on_priority_min_severity ?>" />
			<input type="hidden" name="email_bugnote_limit" value="<?php echo $t_pref->email_bugnote_limit ?>" />
<?php } ?>
			<div class="field-container">
				<label for="timezone"><span><?php echo _('Time Zone') ?></span></label>
				<span class="select">
					<select id="timezone" name="timezone">
						<?php print_timezone_option_list( $t_pref->timezone ?  $t_pref->timezone  : config_get_global( 'default_timezone' ) ) ?>
					</select>
				</span>
				<span class="label-style"></span>
			</div>
			<div class="field-container">
				<label for="language"><span><?php echo _('Language') ?></span></label>
				<span class="select">
					<select id="language" name="language">
						<?php print_language_option_list( $t_pref->language ) ?>
					</select>
				</span>
				<span class="label-style"></span>
			</div>

			<?php event_signal( 'EVENT_ACCOUNT_PREF_UPDATE_FORM', array( $p_user_id ) ); ?>
			<span class="submit-button"><input type="submit" class="button" value="<?php echo _('Update Prefs') ?>" /></span>
		</fieldset>
	</form>
</div>

<div id="account-prefs-reset-div" class="form-container">
	<form id="account-prefs-reset-form" method="post" action="account_prefs_reset.php">
		<fieldset>
			<?php echo form_security_field( 'account_prefs_reset' ) ?>
			<input type="hidden" name="user_id" value="<?php echo $p_user_id ?>" />
			<input type="hidden" name="redirect_url" value="<?php echo $t_redirect_url ?>" />
			<span class="submit-button"><input type="submit" class="button" value="<?php echo _('Reset Prefs') ?>" /></span>
		</fieldset>
	</form>
</div>

<?php
} # end of edit_account_prefs()
