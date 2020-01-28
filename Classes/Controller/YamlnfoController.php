<?php
declare(strict_types=1);
namespace Smic\InfoYaml\Controller;

use TYPO3\CMS\Backend\Module\AbstractFunctionModule;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Form\Mvc\Configuration\ConfigurationManagerInterface;

class YamlnfoController extends AbstractFunctionModule
{
    public function main(): string
    {
        $settings = GeneralUtility::makeInstance(ObjectManager::class)
            ->get(ConfigurationManagerInterface::class)
            ->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_YAML_SETTINGS, 'form');
        $settings = $this->addTypoScriptStyleDotsToArrays($settings);
        $tmpl = GeneralUtility::makeInstance(\TYPO3\CMS\Core\TypoScript\ExtendedTemplateService::class);
        $tmpl->ext_expandAllNotes = 1;
        $tmpl->ext_noPMicons = 1;
        return $tmpl->ext_getObjTree($settings, '', '');
    }

    protected function addTypoScriptStyleDotsToArrays(array $array): array
    {
        foreach ($array as $key => $value) {
            if (!is_array($value)) {
                continue;
            }
            unset($array[$key]);
            $array[$key . '.'] = $this->addTypoScriptStyleDotsToArrays($value);
        }
        return $array;
    }
}
