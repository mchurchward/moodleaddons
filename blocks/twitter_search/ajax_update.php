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
 * Used by Ajax to reload the search results.
 *
 * @package    block
 * @subpackage twitter_search
 * @copyright  2011 Remote-Learner.net Inc.
 * @author     2011 Mike Churchward
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 */
require_once '../../config.php';
require_login();
$id = required_param('blockid', PARAM_NUMBER);
$bi = $DB->get_record('block_instances', array('id' => $id));
$block = block_instance('twitter_search', $bi);
$PAGE->set_context($block->context);
echo $block->get_content()->text;