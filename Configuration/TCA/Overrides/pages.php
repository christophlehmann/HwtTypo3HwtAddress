<?php

if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}


//$configurationUtility = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extensionmanager\\Utility\\ConfigurationUtility');
//$extensionConfiguration = $configurationUtility->getCurrentConfiguration('hwt_address');

$extensionConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['hwt_address']);

if ( isset($extensionConfiguration['enableRelationsInPages']) && ($extensionConfiguration['enableRelationsInPages']==true) ) {
    // Extension locallang
    $ll = 'LLL:EXT:hwt_address/Resources/Private/Language/locallang_db.xlf:pages.';
    
    /*
     * Extend tca of pages
     */
    $tempColumns = array(
        'tx_hwtaddress_related_address' => array(
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => $ll . 'tx_hwtaddress_related_address',
            'config' => array(
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_hwtaddress_domain_model_address',
                'foreign_table' => 'tx_hwtaddress_domain_model_address',
    //            'MM_opposite_field' => 'related_pages_from',
                'size' => 5,
                'minitems' => 0,
                'maxitems' => 100,
                'MM' => 'tx_hwtaddress_domain_model_pages_address_mm',
                'wizards' => array(
                    'suggest' => array(
                        'type' => 'suggest',
                    ),
                ),
            )
        ),
    );
    
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', $tempColumns, 1);
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'pages',
        'tx_hwtaddress_related_address;;;;1-1-1, tx_hwtaddress_related_address_from'
    );
}