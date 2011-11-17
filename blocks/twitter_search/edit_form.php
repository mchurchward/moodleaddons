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
 * Form for editing Twitter search block options.
 *
 */

class block_twitter_search_edit_form extends block_edit_form {
    protected function specific_definition($mform) {
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        $mform->addElement('text', 'config_search_string', get_string('searchterms', 'block_twitter_search'));
        $mform->setType('config_search_string', PARAM_MULTILANG);

        $mform->addElement('select', 'config_no_tweets', get_string('numoftweets', 'block_twitter_search'), range(0,20));

        $mform->addElement('text', 'config_polltime', get_string('polltime', 'block_twitter_search'));
        $mform->setType('config_polltime', PARAM_MULTILANG);
    }
}