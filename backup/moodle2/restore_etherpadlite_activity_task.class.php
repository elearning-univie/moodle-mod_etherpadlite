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

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/etherpadlite/backup/moodle2/restore_etherpadlite_stepslib.php');

/**
 * Etherpadlite restore task that provides all the settings and steps to perform one complete restore of the activity
 *
 * @package    mod_etherpadlite
 * @author     Timo Welde <tjwelde@gmail.com>
 * @copyright  2012 Humboldt-Universität zu Berlin <moodle-support@cms.hu-berlin.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class restore_etherpadlite_activity_task extends restore_activity_task {

    /**
     * Define (add) particular settings this activity can have
     */
    protected function define_my_settings() {
        // No particular settings for this activity.
    }

    /**
     * Define (add) particular steps this activity can have
     */
    protected function define_my_steps() {
        // Etherpadlite only has one structure step.
        $this->add_step(new restore_etherpadlite_activity_structure_step('etherpadlite_structure', 'etherpadlite.xml'));
    }

    /**
     * Define the contents in the activity that must be
     * processed by the link decoder
     */
    public static function define_decode_contents() {
        $contents = array();

        // Nothing to decode.

        return $contents;
    }

    /**
     * Define the decoding rules for links belonging
     * to the activity to be executed by the link decoder
     */
    public static function define_decode_rules() {
        global $DB;
        $rules = array();

        // Nothing to decode.

        return $rules;
    }

    /**
     * Define the restore log rules that will be applied
     * by the {@see restore_logs_processor} when restoring
     * etherpadlite logs. It must return one array
     * of {@see restore_log_rule} objects
     */
    public static function define_restore_log_rules() {
        $rules = array();

        $rules[] = new restore_log_rule('etherpadlite', 'add', 'view.php?id={course_module}', '{etherpadlite}');
        $rules[] = new restore_log_rule('etherpadlite', 'update', 'view.php?id={course_module}', '{etherpadlite}');
        $rules[] = new restore_log_rule('etherpadlite', 'view', 'view.php?id={course_module}', '{etherpadlite}');
        $rules[] = new restore_log_rule('etherpadlite', 'choose', 'view.php?id={course_module}', '{etherpadlite}');
        $rules[] = new restore_log_rule('etherpadlite', 'choose again', 'view.php?id={course_module}', '{etherpadlite}');
        $rules[] = new restore_log_rule('etherpadlite', 'report', 'report.php?id={course_module}', '{etherpadlite}');

        return $rules;
    }

    /**
     * Define the restore log rules that will be applied
     * by the {@see restore_logs_processor} when restoring
     * course logs. It must return one array
     * of {@see restore_log_rule} objects
     *
     * Note this rules are applied when restoring course logs
     * by the restore final task, but are defined here at
     * activity level. All them are rules not linked to any module instance (cmid = 0)
     */
    public static function define_restore_log_rules_for_course() {
        $rules = array();

        // Fix old wrong uses (missing extension).
        $rules[] = new restore_log_rule('etherpadlite', 'view all', 'index?id={course}', null,
                                        null, null, 'index.php?id={course}');
        $rules[] = new restore_log_rule('etherpadlite', 'view all', 'index.php?id={course}', null);

        return $rules;
    }

}
