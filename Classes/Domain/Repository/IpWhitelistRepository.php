<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2020 Sjoerd Zonneveld  <typo3@bitpatroon.nl>
 *  Date: 7-4-2020 22:26
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

namespace BPN\BpnWhitelist\Domain\Repository;


use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\SingletonInterface;

class IpWhitelistRepository implements SingletonInterface
{

    const TABLE = 'tx_bpnwhitelist_ipwhitelist';

    /**
     * Gets all whitelist record
     * @param string $extensionKey
     * @return array|bool False if no records found or the collection of ips
     */
    public function getWhitelistIPS($extensionKey = '')
    {
        $table = self::TABLE;
        $queryBuilder = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable($table);


        $queryBuilder
            ->select('*')
            ->from($table);
        if (!empty($extensionKey)) {
            $queryBuilder->where(
                $queryBuilder->expr()->orX(
                    $queryBuilder->expr()->eq('extension_key', $queryBuilder->createNamedParameter($extensionKey)),
                    $queryBuilder->expr()->eq('extension_key', $queryBuilder->createNamedParameter(''))
                )
            );
        }

        // retrieve all
        $data = $queryBuilder->execute()->fetchAll();
        if (empty($data)) {
            return false;
        }

        $keys = [];
        foreach ($data as $record) {
            $keys[] = $record['ip_mask'];
        }
        return $keys;
    }
}