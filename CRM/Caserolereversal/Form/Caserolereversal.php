<?php

use CRM_Caserolereversal_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://wiki.civicrm.org/confluence/display/CRMDOC/QuickForm+Reference
 */
class CRM_Caserolereversal_Form_Caserolereversal extends CRM_Core_Form {
  public function buildQuickForm() {
    if (!empty($_GET['id'])) {

      // Get Relationship Details
      try {
        $relationshipType = civicrm_api3('RelationshipType', 'getsingle', [
          'id' => $_GET['id'],
        ]);
      }
      catch (CiviCRM_API3_Exception $e) {
        CRM_Core_Error::debug_log_message("com.aghstrategies.caserolereversal API error \n" . $e->getMessage());
      }
      if (!empty($relationshipType['id'])) {
        // Get Number of Relationships that will be changed
        try {
          $relationshipsOfType = civicrm_api3('Relationship', 'getcount', array(
            'relationship_type_id' => $_GET['id'],
          ));
        }
        catch (CiviCRM_API3_Exception $e) {
          CRM_Core_Error::debug_log_message("com.aghstrategies.caserolereversal API error \n" . $e->getMessage());
        }

        if ($relationshipsOfType >= 0) {
          $relationshipType['count'] = $relationshipsOfType;
          // get Case Types that use this relationship type if any exist
          $relTypesUsedByCases = self::getRelTypesUsedByCases();
          if (!empty($relTypesUsedByCases[$relationshipType['id']])) {
            $relationshipType['caseTypes'] = implode(', ', $relTypesUsedByCases[$relationshipType['id']]);
          }
        }
        $this->assign('relationshipsDetails', $relationshipType);
      }
    }
    // Select Relationship Type
    $this->addEntityRef('rel_type', ts('Select Relationship Type'), array(
      'entity' => 'relationshipType',
      'placeholder' => ts('- Select Relationship Type -'),
      'select' => array('minimumInputLength' => 0),
    ));

    $this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => E::ts('Switch'),
        'isDefault' => TRUE,
        // Change the icon for the button
        'crm-icon' => 'fa-random',
      ),
    ));

    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }

  public function postProcess() {
    // TODO Switch relationship types (labels names and contacttype a/b) using the API
    // TODO switch contact ids in the database for all relationships of this type using a db query
    // TODO update the success message
    CRM_Core_Session::setStatus(E::ts('You picked color "%1"', array(
      1 => $options[$values['favorite_color']],
    )));
    parent::postProcess();
  }

  public function getRelTypesUsedByCases() {
    $caseRelationships = array();
    try {
      $caseInfo = civicrm_api3('CaseType', 'get', array(
        'return' => array('definition', 'title'),
      ));
    }
    catch (CiviCRM_API3_Exception $e) {
      CRM_Core_Error::debug_log_message("com.aghstrategies.caserolereversal API error \n" . $e->getMessage());
    }
    // Array of relationship name => ids of case types taht use that relationship
    foreach ($caseInfo['values'] as $caseTypeId => $caseType) {
      foreach ($caseType['definition']['caseRoles'] as $key => $relationship) {
        $caseRelationships[$relationship['name']][] = $caseType['title'];
      }
    }
    foreach ($caseRelationships as $relName => $caseTypes) {
      try {
        $relationshipType = civicrm_api3('RelationshipType', 'getsingle', [
          'return' => ["id"],
          'name_b_a' => $relName,
        ]);
      }
      catch (CiviCRM_API3_Exception $e) {
        CRM_Core_Error::debug_log_message("com.aghstrategies.caserolereversal API error \n" . $e->getMessage());
      }
      // Use Relationship Ids instead of names
      $caseRelationships[$relationshipType['id']] = $caseRelationships[$relName];
      unset($caseRelationships[$relName]);
    }
    return $caseRelationships;
  }

  /**
   * Get the fields/elements defined in this form.
   *
   * @return array (string)
   */
  public function getRenderableElementNames() {
    // The _elements list includes some items which should not be
    // auto-rendered in the loop -- such as "qfKey" and "buttons".  These
    // items don't have labels.  We'll identify renderable by filtering on
    // the 'label'.
    $elementNames = array();
    foreach ($this->_elements as $element) {
      /** @var HTML_QuickForm_Element $element */
      $label = $element->getLabel();
      if (!empty($label)) {
        $elementNames[] = $element->getName();
      }
    }
    return $elementNames;
  }

}
