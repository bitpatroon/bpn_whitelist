<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2017 Sjoerd Zonneveld <typo3@bitpatroon.nl>
 *                             <szonneveld@bitpatroon.nl>
 *  Date: 4-2-2017 21:54
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

if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

$_EXTKEY = 'bpn_whitelist';
$_TXEXTKEY = 'tx_bpnwhitelist';
$_TABLENAME = 'tx_bpnwhitelist_ipwhitelist';

return [
    'ctrl'     => [
        'title'           => 'LLL:EXT:bpn_whitelist/Resources/Private/Language/locallang_db.xml:tx_bpnwhitelist_ipwhitelist',
        'label'           => 'extension_key',
        'label_alt'       => 'title',
        'label_alt_force' => true,
        'tstamp'          => 'tstamp',
        'crdate'          => 'crdate',
        'delete'          => 'deleted',
        'searchFields'    => 'title,ip_mask,extension_key',
        'enablecolumns'   => [
            'disabled' => 'hidden'
        ],
        'default_sortby'  => 'extension_key,title',
        'dividers2tabs'   => true,
        'canNotCollapse'  => true,
        'rootLevel'       => -1,
        'iconfile'        => 'EXT:bpn_whitelist/ext_icon.png'
    ],
    'columns'  => [
        'hidden'        => [
            'exclude' => 1,
            'label'   => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config'  => [
                'type'     => 'check',
                'readOnly' => 1
            ]
        ],
        'title'         => [
            'exclude' => 1,
            'label'   => 'LLL:EXT:bpn_whitelist/Resources/Private/Language/locallang_tca.xml:tx_bpnwhitelist_ipwhitelist.title',
            'config'  => [
                'type' => 'input',
                'eval' => 'trim,required'
            ]
        ],
        'ip_mask'       => [
            'exclude' => 1,
            'label'   => 'LLL:EXT:bpn_whitelist/Resources/Private/Language/locallang_tca.xml:tx_bpnwhitelist_ipwhitelist.ip_mask',
            'config'  => [
                'type' => 'input',
                'size' => 60,
                'eval' => 'trim,required'
            ]
        ],
        'extension_key' => [
            'exclude' => 1,
            'label'   => 'LLL:EXT:bpn_whitelist/Resources/Private/Language/locallang_tca.xml:tx_bpnwhitelist_ipwhitelist.extension_key',
            'config'  => [
                'type'       => 'select',
                'renderType' => 'selectSingle',
                'items'      => [
                    ['Global (alle)', '']
                ],
                'itemsProcFunc' => \BPN\BpnWhitelist\BackEnd\ItemsProcFunc\IPWhiteListItems::class . '->addExtensionKeys'
            ]
        ]
    ],
    'types'    => [
        '1' => ['showitem' => 'hidden, title, ip_mask, extension_key']
    ],
    'palettes' => [
        '1' => ['showitem' => '']
    ]
];
