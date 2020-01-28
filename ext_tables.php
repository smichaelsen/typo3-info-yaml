<?php
defined('TYPO3_MODE') or die();

if (TYPO3_MODE === 'BE') {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::insertModuleFunction(
        'web_info',
        \Smic\InfoYaml\Controller\YamlnfoController::class,
        null,
        'Yaml Info'
    );
}
