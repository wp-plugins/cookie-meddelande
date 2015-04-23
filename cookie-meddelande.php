<?php
/*
Plugin name: Cookie meddelande 
Description: Visar meddelande att sajten använder cookies och att användaren godkänner detta genom att använda sajten. Baserat på cookiechoices.js, utvecklat av Google för att visa meddelandet.
Version: 1.1
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Author: Reine Johansson
Author URI: http://reinejohansson.com

Copyright 2015 Reine Johansson (email: reine@reinejohansson.com)

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License or (at your option) any later version. 

This program is distributed in the hop that it will be useful but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 021101301 USA
*/

register_activation_hook( __FILE__, 'rj_cookie_meddelande_set_up_options' );

function rj_cookie_meddelande_set_up_options(){
  add_option('rj_cm_message', 'Vi använder cookies för att förbättra vår tjänst. Ingen personlig information sparas. Genom att använda tjänsten godkänner du vår användning av cookies.');
  add_option('rj_cm_read_more', 'läs mer');
  add_option('rj_cm_close_message', 'stäng meddelande');
  add_option('rj_cm_link_to_more_info', 'http://www.google.com/intl/en/policies/technologies/cookies/');
}

add_action('wp_footer', 'rj_add_cookie_consent');
function rj_add_cookie_consent() {
	echo "
		<script type='text/javascript' src='".plugins_url()."/cookie-meddelande/js/cookiechoices.js'></script>
		<script>
			  document.addEventListener('DOMContentLoaded', function(event) {
			    cookieChoices.showCookieConsentBar('".get_option("rj_cm_message")."',
			      '".get_option("rj_cm_close_message")."', '".get_option("rj_cm_read_more")."', '".get_option("rj_cm_link_to_more_info")."');
			  });
		</script>";
}

if (is_admin()) {
	add_action("admin_menu", "rj_cookie_meddelande_menu");
	add_action("admin_menu", "rj_cookie_meddelande_register");
}

function rj_cookie_meddelande_register() {
	register_setting("rj_cookie_meddelande_optiongroup", "rj_cm_message");
	register_setting("rj_cookie_meddelande_optiongroup", "rj_cm_read_more");
	register_setting("rj_cookie_meddelande_optiongroup", "rj_cm_close_message");
	register_setting("rj_cookie_meddelande_optiongroup", "rj_cm_link_to_more_info");
}

function rj_cookie_meddelande_menu() {
	add_options_page("Cookie Meddelande Inställningar", "Cookie Meddelande", 8, "rj_cookie_meddelande", "rj_cookie_meddelande_options");
}

function rj_cookie_meddelande_options() {
	?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32"><br /></div>
		<h2>Cookie Meddelande: Inställningar</h2>
		<p>Här kan du ändra meddelanden och länk i cookie-meddelandet. </p>

		<form method="post" action="options.php">
			<?php settings_fields("rj_cookie_meddelande_optiongroup"); ?>

			<table>
				<tr><td>Meddelandetext:</td><td><textarea name="rj_cm_message" style="width: 350px; height: 150px; max-width: 100%"><?php echo get_option("rj_cm_message") ?></textarea></td></tr>
				<tr><td>Läs mer-text:</td><td><input type="text" name="rj_cm_read_more" value="<?php echo get_option("rj_cm_read_more") ?>" /></td></tr>
				<tr><td>Text för att stänga meddelandet:</td><td><input type="text" name="rj_cm_close_message" value="<?php echo get_option("rj_cm_close_message") ?>" /></td></tr>
				<tr><td>Länk till sida med mer info:</td><td><input type="text" name="rj_cm_link_to_more_info" value="<?php echo get_option("rj_cm_link_to_more_info") ?>" /></td></tr>
				<tr><td><input type="submit" class="button-primary" value="Spara" /></td><td></td></tr>
			</table>
	</div>
	<?php
}
?>