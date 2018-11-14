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
      $relTypeId = $_GET['id'];
      $relationshipType = self::getRelationshipDetails($_GET['id']);
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
    // Set Relationship Type
    $this->addElement('hidden', 'rel_type', ts($relTypeId), array('id' => 'rel_type'));

    $this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => E::ts('Switch'),
        'isDefault' => TRUE,
        // Change the icon for the button
        'icon' => 'fa-random',
      ),
    ));

    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }

  public function postProcess() {
    $values = $this->controller->exportValues();
    $relationshipType = self::getRelationshipDetails($values['rel_type']);
    $relTypesUsedByCases = self::getRelTypesUsedByCases();

    // Switch relationship types (labels names and contacttype a/b) using the API
    try {
      $relTypeInfo = civicrm_api3('relationshipType', 'update', array(
        'id' => $relationshipType['id'],
        'name_a_b' => $relationshipType['name_b_a'],
        'label_a_b' => $relationshipType['label_b_a'],
        'name_b_a' => $relationshipType['name_a_b'],
        'label_b_a' => $relationshipType['label_a_b'],
        'contact_type_a' => $relationshipType['contact_type_b'],
        'contact_type_b' => $relationshipType['contact_type_a'],
      ));
    }
    catch (CiviCRM_API3_Exception $e) {
      CRM_Core_Error::debug_log_message("com.aghstrategies.caserolereversal API error \n" . $e->getMessage());
    }
    if (!empty($relTypeInfo['id'])) {
      CRM_Core_Session::setStatus(E::ts('the relationship type with id %1 has been updated', array(
        1 => $relTypeInfo['id'],
      )));
    }

    // switch contact ids in the database for all relationships of this type using a db query
    $query = "UPDATE civicrm_relationship
    SET contact_id_b=(@temp:=contact_id_b), contact_id_b = contact_id_a, contact_id_a = @temp
    WHERE relationship_type_id = {$values['rel_type']}";
    $updateRelationships = CRM_Core_DAO::executeQuery($query);

    // TODO update case roles
    foreach ($relTypesUsedByCases[$values['rel_type']] as $caseTypeId => $caseTypeName) {
      try {
        $caseType = civicrm_api3('CaseType', 'getSingle', [
          'id' => $caseTypeId,
        ]);
      }
      catch (CiviCRM_API3_Exception $e) {
        CRM_Core_Error::debug_log_message("com.aghstrategies.caserolereversal API error \n" . $e->getMessage());
      }
      $updatedDef = $caseType['definition'];
      if (!empty($caseType['definition']['caseRoles'])) {
        foreach ($caseType['definition']['caseRoles'] as $key => $details) {
          if ($details['name'] == $relationshipType['label_b_a']) {
            $updatedDef['caseRoles'][$key]['name'] = $relationshipType['label_a_b'];
            try {
              $updateCase = civicrm_api3('caseType', 'create', array(
                'id' => $caseTypeId,
                'definition' => $updatedDef,
              ));
            }
            catch (CiviCRM_API3_Exception $e) {
              CRM_Core_Error::debug_log_message("com.aghstrategies.caserolereversal API error \n" . $e->getMessage());
            }
          }
        }
      }
    }
    parent::postProcess();

    // redirect back to the relationships page
    CRM_Utils_System::redirect(CRM_Utils_System::url('civicrm/admin/reltype'));
  }

  /**
   * Looks up all the relationship types used by cases
   * @return array an array where the key is the relationship type id and the value is an array of the casetypes that use that relationship type
   */
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
        $caseRelationships[$relationship['name']][$caseType['id']] = $caseType['title'];
      }
    }
    foreach ($caseRelationships as $relName => $caseTypes) {
      try {
        $relationshipType = civicrm_api3('RelationshipType', 'getsingle', [
          'return' => ["id"],
          'label_b_a' => $relName,
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
   * Gets Relationship Details (names, labels etc.)
   * @param int $relTypeid relationship type id
   * @return array           relationship details
   */
  public function getRelationshipDetails($relTypeid) {
    // Get Relationship Details
    try {
      $relationshipType = civicrm_api3('RelationshipType', 'getsingle', [
        'id' => $relTypeid,
      ]);
    }
    catch (CiviCRM_API3_Exception $e) {
      CRM_Core_Error::debug_log_message("com.aghstrategies.caserolereversal API error \n" . $e->getMessage());
    }
    return $relationshipType;
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
