<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
/**
 * settings mod form
 * @package   local_edwiserbridge
 * @author    Wisdmlabs
 */

defined('MOODLE_INTERNAL') || die();
require_once("$CFG->libdir/formslib.php");

/**
*form shown while adding activity.
*/
class edwiserbridge_form1 extends moodleform
{
    public function definition()
    {
        $defaultvalues = get_connection_settings();
        $mform = $this->_form;
        $repeatarray = array();
        $repeatarray[] = $mform->createElement('text', 'wp_name', get_string('wordpress_site_name', 'local_edwiserbridge'));
        $repeatarray[] = $mform->createElement('text', 'wp_url', get_string('wordpress_url', 'local_edwiserbridge'));
        $repeatarray[] = $mform->createElement('text', 'wp_token', get_string('wp_token', 'local_edwiserbridge'));


        $buttonarray = array();
        $buttonarray[] = $mform->createElement('button', 'eb_test_connection', get_string("wp_test_conn_btn", "local_edwiserbridge"), "", "", "class=test_eb");
        $buttonarray[] = $mform->createElement('button', 'eb_remove_site', get_string("wp_test_remove_site", "local_edwiserbridge"));
        $buttonarray[] = $mform->createElement('html', '<div id="eb_test_conne_response"> </div>');

        $repeatarray[] = $mform->createElement("group", "eb_buttons", "", $buttonarray);

        $repeateloptions = array();
        $repeateloptions['wp_url']['type'] = PARAM_TEXT;
        $repeateloptions['wp_token']['type'] = PARAM_TEXT;
        $repeateloptions['wp_name']['type'] = PARAM_TEXT;

        $repeateloptions['wp_token']['helpbutton'] = array("token", "local_edwiserbridge");
        $repeateloptions['wp_name']['helpbutton'] = array("wordpress_site_name", "local_edwiserbridge");


        $count = 1;
        if (!empty($defaultvalues) && !empty($defaultvalues["eb_connection_settings"])) {
            $count = count($defaultvalues["eb_connection_settings"]);
            $siteNo = 0;
            foreach ($defaultvalues["eb_connection_settings"] as $key => $value) {
                $mform->setDefault("wp_url[".$siteNo."]", $value["wp_url"]);
                $mform->setDefault("wp_token[".$siteNo."]", $value["wp_token"]);
                $mform->setDefault("wp_name[".$siteNo."]", $value["wp_name"]);
                $siteNo++;
            }
        }

        $this->repeat_elements($repeatarray, $count, $repeateloptions, 'option_repeats', 'option_add_fields', 1, get_string("add_more_sites", "local_edwiserbridge"), true);
        //fill form with the existing values
        $this->add_action_buttons(false);
    }

    public function validation($data, $files)
    {
        return array();
    }
}




/**
*form shown while adding activity.
*/
class edwiserbridge_form2 extends moodleform
{
    public function definition()
    {
        $mform = $this->_form;
        $sites = get_site_list();
        $site_keys = array_keys($sites);
        $defaultvalues = get_synch_settings($site_keys[0]);

        $mform->addElement('select', 'wp_site_list', get_string('site-list', 'local_edwiserbridge'), $sites);

        $mform->addElement('advcheckbox', 'course_enrollment', get_string('enrollment_checkbox', 'local_edwiserbridge'), get_string("enrollment_checkbox_desc", "local_edwiserbridge"), array('group' => 1), array(0, 1));
        $mform->addElement('advcheckbox', 'course_un_enrollment', get_string('unenrollment_checkbox', 'local_edwiserbridge'), get_string("unenrollment_checkbox_desc", "local_edwiserbridge"), array('group' => 1), array(0, 1));
        $mform->addElement('advcheckbox', 'user_creation', get_string('user_creation', 'local_edwiserbridge'), get_string("user_creation_desc", "local_edwiserbridge"), array('group' => 1), array(0, 1));
        $mform->addElement('advcheckbox', 'user_deletion', get_string('user_deletion', 'local_edwiserbridge'), get_string("user_deletion_desc", "local_edwiserbridge"), array('group' => 1), array(0, 1));

        //fill form with the existing values
        if (!empty($defaultvalues)) {
            $mform->setDefault("course_enrollment", $defaultvalues["course_enrollment"]);
            $mform->setDefault("course_un_enrollment", $defaultvalues["course_un_enrollment"]);
            $mform->setDefault("user_creation", $defaultvalues["user_creation"]);
            $mform->setDefault("user_deletion", $defaultvalues["user_deletion"]);
        }
        $this->add_action_buttons();
    }

    public function validation($data, $files)
    {
        return array();
    }
}




/**
*form shown while adding activity.
*/
class edwiserbridge_form3 extends moodleform
{
    public function definition()
    {
        global $CFG;
        $mform = $this->_form;

        $connection = "";
        $synch = "";

        if (isset($_GET["tab"]) && $_GET["tab"] == "connection") {
            $connection = "active-tab";
        } elseif (isset($_GET["tab"]) && $_GET["tab"] == "synchronization") {
            $synch = "active-tab";
        }

        $mform->addElement(
            'html',
            '<div class="eb-tabs-cont">
                <div id="eb-conn-tab" class="eb-tabs '.$connection.'">
                    <a href="'.$CFG->wwwroot."/local/edwiserbridge/edwiserbridge.php?tab=connection".'">
                        Connection settings
                    </a>
                </div>
                <div id="eb-synch-tab" class="eb-tabs '.$synch.'">
                    <a href="'.$CFG->wwwroot."/local/edwiserbridge/edwiserbridge.php?tab=synchronization".'">
                        Synchronization settings
                    </a>
                </div>
            </div>'
        );

    }

    public function validation($data, $files)
    {
        return array();
    }
}
