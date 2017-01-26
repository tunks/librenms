<?php
/**
 * aos-emu2.inc.php
 *
 * LibreNMS sensors temp discovery module for APC EMU2
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    LibreNMS
 * @link       http://librenms.org
 * @copyright  2016 Neil Lathwood
 * @author     Neil Lathwood <neil@lathwood.co.uk>
 */

if ($device['os'] === 'aos-emu2') {
    foreach ($emu2_temp as $id => $temp) {
        if (isset($temp['emsProbeStatusProbeTemperature']) && $temp['emsProbeStatusProbeTemperature'] > 0) {
            $index           = $temp['emsProbeStatusProbeIndex'];
            $oid             = '.1.3.6.1.4.1.318.1.1.10.3.13.1.1.3.' . $index;
            $descr           = $temp['emsProbeStatusProbeName'];
            $low_limit       = fahrenheit_to_celsius($emu2_temp_scale, $temp['emsProbeStatusProbeMinTempThresh']);
            $low_warn_limit  = fahrenheit_to_celsius($emu2_temp_scale, $temp['emsProbeStatusProbeLowTempThresh']);
            $high_limit      = fahrenheit_to_celsius($emu2_temp_scale, $temp['emsProbeStatusProbeMaxTempThresh']);
            $high_warn_limit = fahrenheit_to_celsius($emu2_temp_scale, $temp['emsProbeStatusProbeHighTempThresh']);
            $current         = fahrenheit_to_celsius($emu2_temp_scale, $temp['emsProbeStatusProbeTemperature']);
            discover_sensor($valid['sensor'], 'temperature', $device, $oid, $index, 'aos-emu2', $descr, '1', '1', $low_limit, $low_warn_limit, $high_warn_limit, $high_limit, $current);
        }
    }
}