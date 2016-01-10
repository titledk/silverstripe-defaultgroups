<?php

/**
 * Default Groups Helper
 *
 * Read more here:
 * http://doc.silverstripe.org/framework/en/topics/access-control
 * http://doc.silverstripe.org/framework/en/reference/permission
 * http://doc.silverstripe.org/framework/en/reference/member
 *
 *
 * @author Anselm Christophersen <ac@anselm.dk>
 * @date   July 2015
 */
class DefaultGroupsHelper
{

    /**
     * Check for default group, and if it doesn't exist, create it
     * Should be run under "requireDefaultRecords"
     * @param string $code
     * @param string $title
     * @param string $parent
     * @param array $permissions
     */
    public static function default_group($code, $title, $parentCode = null, $permissions = array())
    {
        $group = null;
        $action = null;
        if (!DataObject::get_one('Group', "Code = '" . $code . "'")) {
            $action = 'create';
            $group = new Group();
        } else {
            $action = 'update';
            $group = DataObject::get_one('Group', "Code = '" . $code . "'");
        }

        $group->Title = $title;
        $group->Code = $code;
        if ($parentCode) {
            $parentObj = DataObject::get_one("Group", "Code = '" . $parentCode . "'");
            $group->ParentID = $parentObj->ID;
        }
        $group->write();

        if (!empty($permissions)) {
            foreach ($permissions as $p) {
                Permission::grant($group->ID, $p);
            }
        }
        if ($action == 'create') {
            DB::alteration_message('Group ' . $title . ' (' . $code . ') has been created.', "created");
        }
        if ($action == 'update') {
            DB::alteration_message('Group ' . $title . ' (' . $code . ') has been updated.', "updated");
        }
        return $group;
    }
}
