<?php

namespace App\Repositories\testdata;
/**
 * Description of user
 *
 * @author Administrator
 */
class user {
        
    function getuser($usertype){
        switch ($usertype){
            case 'admin':
                return $this->user_admin();
                break;
            
        }
    }
    
    function user_admin(){
        $u = [];
        
        $u['uname'] = 'admin';
        $u['gic'] = 'admin';
        $u['nickname'] = '系统管理员';
        $u['realname'] = '管理员';
        $u['mycode'] = 'admin';
        $u['dname'] = '管理';
        $u['rolename'] = '系统管理员';
        $u['role'] = '';
        $u['dic'] = '';
        $u['ic'] = 'admin';
   
        //session(['user' => $u]);
        
        return $u;
    }
}
