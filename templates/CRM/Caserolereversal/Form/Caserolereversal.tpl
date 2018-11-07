{* HEADER *}

{* TODO make UI More user friendly *}
<p>You have chosen to update</p>
<p><strong>Relationship Type Id:</strong> {$relationshipsDetails.id}</p>
<p><strong>Relationship Description:</strong> {$relationshipsDetails.description}</p>
<p>Currently the Relationship Labels for this type are:</p>
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
<p>Clicking Submit will change the labels to:</p>
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
<p><strong>{$relationshipsDetails.count}</strong> Relationships will be updated.</p>
<p>Case Types this role is used in</p>
<p>For more information on CiviCRM Relationships visit <a href="https://docs.civicrm.org/user/en/latest/organising-your-data/relationships/">the CiviCRM Documentation on Relationships</a></p>
<p>To continue click switch</p>
<div class="crm-submit-buttons">
{include file="CRM/common/formButtons.tpl" location="bottom"}
</div>
