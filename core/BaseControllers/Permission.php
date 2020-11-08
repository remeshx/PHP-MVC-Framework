<?php

namespace Core\BaseControllers;

use Core\Database\ORM\Model;


class Permission extends Model { 
    private $tablePermission = 'ex_permissions';
    private $tableAdmin = 'admin_users';
    private $tableGroup = 'ex_groups';
    private $tableGroupUser = 'ex_group_user';
    private $tableRoutes = 'ex_routes';

    static function checkPermission($currentRouteName, $currentUser) {
        //SELECT `id`, `type`, `name`, `status`, `registrant`, `created_at`, `updated_at` FROM `meshop_ex_groups` WHERE 1
        //SELECT `id`, `group_id`, `user_id`, `status`, `created_at`, `updated_at` FROM `meshop_ex_group_user` WHERE 1
        //SELECT `id`, `group_id`, `route_id`, `permit`, `status`, `registrant`, `created_at`, `updated_at` FROM `meshop_ex_permissions` WHERE 1
        //SELECT `id`, `type`, `name`, `status`, `registrant`, `created_at`, `updated_at` FROM `meshop_ex_groups` WHERE 1
        //SELECT `id`, `title`, `route_name`, `status`, `registrant`, `created_at`, `updated_at` FROM `meshop_ex_routes` WHERE 1
        // $result = array();

        // $tablePermission = DB_TBL_PREFIX . $this->tablePermission;
        // $tableAdmin      = DB_TBL_PREFIX . $this->tableAdmin;
        // $tableRoutes     = DB_TBL_PREFIX . $this->tableRoutes;
        // $tableGroup      = DB_TBL_PREFIX . $this->tableGroup;
        // $tableGroupUser  = DB_TBL_PREFIX . $this->tableGroupUser;
        
        // $sql = "SELECT p.permit 
        // FROM $tablePermission as p, $tableGroup as g, $tableRoutes as r, $tableGroupUser as gu
        // WHERE g.type = 'admin' AND g.status = 1 AND g.id = gu.group_id AND gu.group_id = p.group_id AND p.status = 1 AND gu.status = 1 AND p.route_id = r.id AND r.status = 1 AND r.route_name = '$currentRouteName' AND gu.user_id = $currentUser->id";
        // $stmt = $this->db->query($sql);
        // $result = $this->db->resultset($stmt);
        // $permit = 0;
        // foreach($result as $item) {
        //     if($item->permit > $permit)
        //         $permit = $item->permit;
        // }

        // return $permit;
        return true;
    }
}

?>