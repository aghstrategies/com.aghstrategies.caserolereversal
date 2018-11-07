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
        if (!empty($relationshipsOfType)) {
          $relationshipType['count'] = $relationshipsOfType;
        }
        // TODO get Case Types that use this relationship type if any exist
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
        // TODO add icon for shuffle
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
    /*TODO make this function figure out which relationship types are used by cases*/
    $options = array(
      '' => E::ts('- select -'),
      '#f00' => E::ts('Red'),
      '#0f0' => E::ts('Green'),
      '#00f' => E::ts('Blue'),
      '#f0f' => E::ts('Purple'),
    );
    foreach (array('1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e') as $f) {
      $options["#{$f}{$f}{$f}"] = E::ts('Grey (%1)', array(1 => $f));
    }
    return $options;
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
