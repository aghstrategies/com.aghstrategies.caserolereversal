{* HEADER *}

{* TODO make UI More user friendly *}
<p>See Details on the Relationship Type you have choosen to update below:</p>
<div><strong>Relationship Type ID:</strong> {$relationshipsDetails.id}</div>
<div><strong>Relationship Description:</strong> {$relationshipsDetails.description}</div>
<div><strong>Case Type(s) this relationship is used by:</strong> {$relationshipsDetails.caseTypes}</div>
<div><strong>Number of Relationships that will be updated:</strong> {$relationshipsDetails.count}</div>

<p><strong>Currently the Relationship Labels for this type are:</strong></p>
<table>
  <thead>
    <tr>
      <th>
        Label Relationship A to B
      </th>
      <th>
        Label Relationship B to A
      </th>
      <th>
        Contact Type A (Client)
      </th>
      <th>
        Contact Type B
      </th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>
        {$relationshipsDetails.label_a_b}
      </td>
      <td>
        {$relationshipsDetails.label_b_a}
      </td>
      <td>
        {$relationshipsDetails.contact_type_a}
      </td>
      <td>
        {$relationshipsDetails.contact_type_b}
      </td>
    </tr>
  </tbody>
</table>
<p><strong>Clicking Submit will change the labels to:</strong></p>
<table>
  <thead>
    <tr>
      <th>
        Label Relationship A to B
      </th>
      <th>
        Label Relationship B to A
      </th>
      <th>
        Contact Type A (Client)
      </th>
      <th>
        Contact Type B
      </th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>
        {$relationshipsDetails.label_b_a}
      </td>
      <td>
        {$relationshipsDetails.label_a_b}
      </td>
      <td>
        {$relationshipsDetails.contact_type_b}
      </td>
      <td>
        {$relationshipsDetails.contact_type_a}
      </td>
    </tr>
  </tbody>
</table>
<p>For more information on CiviCRM Relationships visit <a href="https://docs.civicrm.org/user/en/latest/organising-your-data/relationships/">the CiviCRM Documentation on Relationships</a></p>
<p>To continue click switch</p>
<div class="crm-submit-buttons">
{include file="CRM/common/formButtons.tpl" location="bottom"}
</div>
