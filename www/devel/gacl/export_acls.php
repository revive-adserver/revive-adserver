<?php

require_once('gacl_admin.inc.php');

echo "<pre>";

// -------------------------------  GENERATE LIST OF AROS ------------------------------ //

$oGacl =& $gacl_api;

$group_type = 'aro';
$group_table = $oGacl->_db_table_prefix . 'aro_groups';
$group_map_table = $oGacl->_db_table_prefix . 'groups_aro_map';

$formatted_groups = $oGacl->format_groups($oGacl->sort_groups($group_type), HTML);

$query = '
	SELECT		a.id, a.name, a.value, count(b.'. $group_type .'_id)
	FROM		'. $group_table .' a
	LEFT JOIN	'. $group_map_table .' b ON b.group_id=a.id
	GROUP BY	a.id,a.name,a.value';
$rs = $db->Execute($query);

$group_data = array();

if(is_object($rs)) {
	while($row = $rs->FetchRow()) {
		$group_data[$row[0]] = array(
			'name' => $row[1],
			'value' => $row[2],
			'count' => $row[3]
		);
	}
}

$groups = array();

foreach($formatted_groups as $id => $name) {
	$groups[] = array(
		'id' => $id,
		'name' => $name,
		'raw_name' => $group_data[$id]['name'],
		'value' => $group_data[$id]['value'],
		'object_count' => $group_data[$id]['count']
	);
}

// ARO groups
foreach ($groups as $groupId => $group) {
    $id = 0;
    if ($groupId == 0) {
        echo '$id = $oGacl->add_group(\''.trim($group['value']).'\', \''.trim($group['raw_name']).'\', 0, \'ARO\');</br>';
    } else {
        echo '$oGacl->add_group(\''.trim($group['value']).'\', \''.trim($group['raw_name']).'\', $id, \'ARO\');</br>';
    }
}
echo "\n";

//echo '<pre>';
//print_r($groups);
//echo '</pre>';

// -------------------------------  GENERATE LIST OF AROS SECTIONS --------------------- //

echo "\$oGacl->add_object_section('Users', 'USERS', 1, 0, 'ARO');\n";
echo "\n";

// -------------------------------  GENERATE LIST OF ACLS SECTIONS --------------------- //

echo "\$oGacl->add_object_section('System', 'system', 1, 0, 'ACL');\n";
echo "\$oGacl->add_object_section('User', 'user', 2, 0, 'ACL');\n";
echo "\n";


// -------------------------------  GENERATE LIST OF ACOS SECTIONS --------------------- //

$query = '
	SELECT		value,
	            name
	FROM		'. $oGacl->_db_table_prefix .'aco_sections a
	ORDER BY	order_value';

$rs = $db->Execute($query);

while ($row = $rs->fetchRow()) {
    list($value, $name) = $row;

	$aAcoSections[$value] = array(
	   'name'     => $name,
	   'children' => array()
	);
}

// -------------------------------  GENERATE LIST OF ACOS ------------------------------ //


$query = '
	SELECT		b.section_value AS a_value,
				b.value AS b_value,
				b.name AS b_name
	FROM		'. $oGacl->_db_table_prefix .'aco_sections a
	LEFT JOIN	'. $oGacl->_db_table_prefix .'aco b ON a.value=b.section_value
	ORDER BY	a.value, b.value';

$rs = $db->Execute($query);

while ($row = $rs->fetchRow()) {
    list($aco_section_value, $aco_value, $aco_name) = $row;

    $aAdmin      = $gacl->acl_query($aco_section_value, $aco_value, 'USERS', 1);
    $aManager    = $gacl->acl_query($aco_section_value, $aco_value, 'USERS', 2);
    $aAdvertiser = $gacl->acl_query($aco_section_value, $aco_value, 'USERS', 4);
    $aTrafficker = $gacl->acl_query($aco_section_value, $aco_value, 'USERS', 3);

    $aGroups = array();
    if ($aAdmin['allow']) { $aGroups[] = OA_ACCOUNT_ADMIN; }
    if ($aManager['allow']) { $aGroups[] = OA_ACCOUNT_MANAGER; }
    if ($aAdvertiser['allow']) { $aGroups[] = OA_ACCOUNT_ADVERTISER; }
    if ($aTrafficker['allow']) { $aGroups[] = OA_ACCOUNT_TRAFFICKER; }

    $aAcoSections[$aco_section_value]['children'][$aco_value] = array(
        'name'   => $aco_name,
        'groups' => $aGroups
    );

}

echo "\$aAcoSections = ".var_export($aAcoSections, true).";\n";
echo "\n";
echo "\$this->createAcls(\$oGacl, \$aAcoSections);\n";
echo "\n";
echo "return true;\n";

echo "</pre>";

?>