<#1>
<?php
/** @var ilDBInterface $ilDB */
global $ilDB;
$db = $ilDB;
require_once 'Customizing/global/plugins/Services/UIComponent/UserInterfaceHook/ShortLink/classes/class.ilShortLinkPlugin.php';

if (! $db->tableExists(ilShortLinkPlugin::TABLE_NAME)) {
    $fields = [
        'id' => [
            'type' => 'integer',
            'length' => 4,
            'notnull' => TRUE
        ],
        'short_link' => [
            'type' => 'text',
            'length' => 32,
            'notnull' => FALSE
        ],
        'full_url' => [
            'type' => 'text',
            'length' => 400,
            'notnull' => FALSE
        ],
        'contact_user_login' => [
            'type' => 'text',
            'length' => 40,
            'notnull' => FALSE
        ]
    ];
    $db->createTable(ilShortLinkPlugin::TABLE_NAME, $fields);
    $db->addPrimaryKey(ilShortLinkPlugin::TABLE_NAME, ['id']);
    $db->createSequence(ilShortLinkPlugin::TABLE_NAME);
}
?>

<#2>
<?php
/** @var ilDBInterface $ilDB */
global $ilDB;
$db = $ilDB;

if(! $db->tableColumnExists(ilShortLinkPlugin::TABLE_NAME, 'customer'))
{
    $query = 'ALTER TABLE ' . ilShortLinkPlugin::TABLE_NAME . ' ADD COLUMN customer VARCHAR(40) AFTER full_url';
    $res = $ilDB->query($query);
}

?>