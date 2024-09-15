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

$plugin = new stdClass();
$plugin->version = 2024091503; // YYYYMMDDXX - Plugin version.
$plugin->requires = 2022041900; // YYYYMMDDXX - Minimum Moodle version required.
$plugin->supported = [2022041900, 2024090000]; // Supported Moodle versions.
$plugin->component = 'block_olympiads'; // Full name of the plugin (used for diagnostics).
$plugin->maturity = MATURITY_ALPHA; // Plugin maturity level (ALPHA, BETA, RC, STABLE).
$plugin->release = '0.1.0'; // Human-readable release number.

$plugin->dependencies = [
    'mod_forum' => 2022041900, // Example dependency.
];
