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
 * Contains utility functions.
 *
 * @package   mod_etherpadlite
 * @copyright 2022 Andreas Grabs <moodle@grabs-edv.de>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_etherpadlite;

/**
 * Class for fetching the important dates in mod_etherpadlite for a given module instance and a user.
 *
 * @copyright 2022 Adrian Czermak <adrian.czermak@univie.ac.at>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class util {
    /**
     * Get an existing activity instance.
     * An array with the following elements will be returned.
     * [
     *     $course,
     *     $cm,
     *     $etherpadlite,
     * ]
     *
     * @param int $id The coursemodule id
     * @param int $a The instance id from table etherpadlite
     * @return array
     */
    public static function get_coursemodule($id, $a) {
        global $DB;

        if ($id) {
            $cm = get_coursemodule_from_id('etherpadlite', $id, 0, false, MUST_EXIST);
            $course = $DB->get_record('course', ['id' => $cm->course], '*', MUST_EXIST);
            $etherpadlite = $DB->get_record('etherpadlite', ['id' => $cm->instance], '*', MUST_EXIST);
        } else if ($a) {
            $etherpadlite = $DB->get_record('etherpadlite', ['id' => $a], '*', MUST_EXIST);
            $course = $DB->get_record('course', ['id' => $etherpadlite->course], '*', MUST_EXIST);
            $cm = get_coursemodule_from_instance('etherpadlite', $etherpadlite->id, $course->id, false, MUST_EXIST);
        } else {
            throw new \moodle_exception('You must specify a course_module ID or an instance ID');
        }

        return array($course, $cm, $etherpadlite);
    }
}
