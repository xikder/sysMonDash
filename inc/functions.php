<?php
/**
 * sysMonDash
 *
 * @author    nuxsmin
 * @link      http://cygnux.org
 * @copyright 2014-2016 Rubén Domínguez nuxsmin@cygnux.org
 *
 * This file is part of sysMonDash.
 *
 * sysMonDash is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * sysMonDash is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with sysMonDash.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

use SMD\Core\sysMonDash;
use SMD\Util\Util;

define('APP_ROOT', '.');

require APP_ROOT . DIRECTORY_SEPARATOR . 'Base.php';

$raw = \SMD\Http\Request::analyze('raw', 0);
$allHeaders = \SMD\Http\Request::analyze('allheaders', false, false, true);

echo '<pre>';

if ($raw) {
    $SMD = new sysMonDash();

    foreach ($SMD->getBackends() as $Backend) {
        /** @var \SMD\Backend\BackendInterface $Backend */
        $Backend->setAllHeaders($allHeaders);

        echo 'Backend: ', $Backend->getBackend()->getAlias(), PHP_EOL;
        echo 'Hosts', PHP_EOL;
        print_r(Util::arraySortByProperty($Backend->getHostsProblems(), 'start_time'));
        echo 'Services', PHP_EOL;
        print_r(Util::arraySortByProperty($Backend->getServicesProblems(), 'start_time'));
        echo 'Downtimes', PHP_EOL;
        print_r(Util::arraySortByProperty($Backend->getScheduledDowntimesGroupped(), 'start_time', false));
    }
}

echo '</pre>';
