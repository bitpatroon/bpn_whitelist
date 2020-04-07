<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2017 Sjoerd Zonneveld <typo3@bitpatroon.nl>
 *  Date: 4-2-2017 21:53
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

namespace BPN\BpnWhitelist\Controller;

use BPN\BpnWhitelist\Domain\Repository\IpWhitelistRepository;
use TYPO3\CMS\Core\Log\LogRecord;
use TYPO3\CMS\Core\Log\Writer\SyslogWriter;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class RemoteWhitelistController implements SingletonInterface
{

    /**
     * Check if the remote host is allowed to access a specified extension.
     * @param string|null $extensionKey
     * @param string|null $remoteAddr
     * @param string      $requestId
     * @return bool
     */
    public function isHostWhitelisted($extensionKey = null, $remoteAddr = null, $requestId = '')
    {
        if (empty($remoteAddr)) {
            $remoteAddr = GeneralUtility::getIndpEnv('REMOTE_ADDR');
        }

        $fullMask = '';

        /** @var IpWhitelistRepository $ipWhitelistRepository */
        $ipWhitelistRepository = GeneralUtility::makeInstance(IpWhitelistRepository::class);
        $keys = $ipWhitelistRepository->getWhitelistIPS($extensionKey);

        if (!empty($keys)) {

            $fullMask = implode(',', $keys);
            $allowed = GeneralUtility::cmpIP($remoteAddr, $fullMask);

            if ($allowed) {
                return true;
            }
        }


        $message = vsprintf('Client "%s" has no access based on this ip mask "%s" [1583498098144]', [
            $remoteAddr,
            $fullMask
        ]);
        $this->sysLog($message, \Psr\Log\LogLevel::NOTICE, $extensionKey ?? 'bpn_library', [], $requestId);

        return false;
    }

    /**
     * Check if the remote host is allowed to access a specified extension.
     * @param string|null $extensionKey
     * @param string|null $remoteAddr
     * @param string      $requestId
     * @return bool
     */
    public static function isHostAllowed($extensionKey = null, $remoteAddr = null, $requestId = '')
    {
        /** @var RemoteWhitelistController $self */
        $self = GeneralUtility::makeInstance(__CLASS__);
        return $self->isHostWhitelisted($extensionKey, $remoteAddr, $requestId);
    }

    /**
     * Writes to syslog
     * @param string $message
     * @param string $severity Severity level (see \TYPO3\CMS\Core\Log\Level)
     * @param string $component
     * @param array  $data
     * @param string $requestId
     */
    private function sysLog($message, $severity = '', $component='', $data = [], $requestId = '')
    {
        if (empty($severity)){
            $severity = \Psr\Log\LogLevel::INFO;
        }

        $logRecord = GeneralUtility::makeInstance(LogRecord::class, $component, $severity, $message, $data, $requestId);
        $syslogWriter = GeneralUtility::makeInstance(SyslogWriter::class);
        $syslogWriter->writeLog($logRecord);
    }

}