<?php

require_once 'caserolereversal.civix.php';
use CRM_Caserolereversal_ExtensionUtil as E;

/**
 * Implements hook_civicrm_links().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_links
 */
function caserolereversal_civicrm_links($op, $objectName, $objectId, &$links, &$mask, &$values) {
  $links[] = array(
    'name' => ts('Reverse Case Roles'),
    'url' => 'civicrm/caserolereversal',
    'title' => 'Reverse Relationship Labels',
    'qs' => 'reset=1&id=%%id%%',
    'class' => 'no-popup',
  );

  if (1) {
    $links[] = array(
      'name' => ts('Reverse Case Roles') . $op,
      'url' => 'civicrm/caserolereversal',
      'title' => 'Reverse Relationship Labels',
      'qs' => 'reset=1&id=%%id%%',
      'class' => 'no-popup',
    );
  }
}


/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function caserolereversal_civicrm_config(&$config) {
  _caserolereversal_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function caserolereversal_civicrm_xmlMenu(&$files) {
  _caserolereversal_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function caserolereversal_civicrm_install() {
  _caserolereversal_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function caserolereversal_civicrm_postInstall() {
  _caserolereversal_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function caserolereversal_civicrm_uninstall() {
  _caserolereversal_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function caserolereversal_civicrm_enable() {
  _caserolereversal_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function caserolereversal_civicrm_disable() {
  _caserolereversal_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function caserolereversal_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _caserolereversal_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function caserolereversal_civicrm_managed(&$entities) {
  _caserolereversal_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function caserolereversal_civicrm_caseTypes(&$caseTypes) {
  _caserolereversal_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function caserolereversal_civicrm_angularModules(&$angularModules) {
  _caserolereversal_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function caserolereversal_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _caserolereversal_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_entityTypes
 */
function caserolereversal_civicrm_entityTypes(&$entityTypes) {
  _caserolereversal_civix_civicrm_entityTypes($entityTypes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function caserolereversal_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
function caserolereversal_civicrm_navigationMenu(&$menu) {
  _caserolereversal_civix_insert_navigation_menu($menu, 'Mailings', array(
    'label' => E::ts('New subliminal message'),
    'name' => 'mailing_subliminal_message',
    'url' => 'civicrm/mailing/subliminal',
    'permission' => 'access CiviMail',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _caserolereversal_civix_navigationMenu($menu);
} // */
