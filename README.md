# com.aghstrategies.caserolereversal

![Screenshot](/images/screenshot.png)

### CiviCRM Relationship Types Naming Convention (lifted from the CiviCRM User Guide [Relationships Page](https://docs.civicrm.org/user/en/latest/organising-your-data/relationships/))
Enter descriptive labels for the relationship type you are creating in the Relationship Label-A to B and Relationship Label-B to A fields. The Relationship Label-A to B field describes the relationship between Contact A and Contact B; the Relationship Label-B to A field describes the relationship between Contact B and Contact A.

+ Some relationships can be described by the same label in both directions; in these cases you can enter the Relationship Label once in the Relationship Label-A to B field. For example, when describing the relationship between two domestic partners named Sylvia and Audre, you can say that Sylvia is the "Partner of" Audre and Audre is the "Partner of" Sylvia. Therefore you would enter the "Partner of" label only in Relationship Label-A to B field, leaving the Relationship Label-B to A field blank.
+ **In other situations one Relationship Label cannot be applied in both directions; in these cases you need to enter different Relationship Labels in each of the Relationship Label fields. For example, you can say that Kiyoshi is the "Grandparent of" Yuki but you cannot say that Yuki is the "Grandparent of" Kiyoshi. Therefore you would enter the "Grandparent of" label in the Relationship Label-A to B field and either "Grandchild of" or "Grandparent is" in the Relationship Label-B to A field.**

Use the Contact Type A and Contact Type B fields to designate which contact types are being linked by your relationship. Remember to check that the contact types you select for Contact A and Contact B make sense when corresponded to your Relationship Labels.

### Where this Extension Comes in
If you got the labels for your relationship types confused, thats where this extension comes in. We will flip them for you.

Log into your site as an admin, install this extension and go to civicrm/caserolereversal to get started.

The extension is licensed under [AGPL-3.0](LICENSE.txt).

## Requirements

* PHP v5.4+
* CiviCRM 5.8

## Installation (Web UI)

This extension has not yet been published for installation via the web UI.

## Installation (CLI, Zip)

Sysadmins and developers may download the `.zip` file for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
cd <extension-dir>
cv dl com.aghstrategies.caserolereversal@https://github.com/aghstrategies/com.aghstrategies.caserolereversal/archive/master.zip
```

## Installation (CLI, Git)

Sysadmins and developers may clone the [Git](https://en.wikipedia.org/wiki/Git) repo for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
git clone https://github.com/aghstrategies/com.aghstrategies.caserolereversal.git
cv en caserolereversal
```

## Usage

If you got the labels for your relationship types confused, thats where this extension comes in. We will flip them for you.

Log into your site as an admin, install this extension and go to civicrm/caserolereversal to get started.

## Known Issues

(* FIXME *)
