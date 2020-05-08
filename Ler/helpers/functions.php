<?php
class Utils{
//TODO update this according to new bootstrap/autoloader layout
//4-14-20 Updated to boostrap style
    public static function isLoggedIn($redirect = false){
        if (isset($_SESSION['user'])) {
            return true;
        }
        if($redirect){
            die(header("Location: index.php?login"));
        }
        return false;
    }

    public static function isAdmin($redirect=false){
        if (isset($_SESSION['user'])){
            $user = $_SESSION['user'];
            if($user->hasRoleByName("admin")){
                return true;
            }
        }
        if($redirect){
            header("Location: login.php");
        }
        return false;
    }
    public static function getLoggedInUser($redirect=false){
        if(Utils::isLoggedIn($redirect)){
            return $_SESSION['user'];
        }
        return false;
    }
    public static function login($user){
        unset($_SESSION['user']);
        $_SESSION['user'] = $user;
    }
    public static function logout(){
        session_unset();
        session_destroy();
        header("Location: logout.php");
    }

    /*** Used to echo out a key of an array where it doesn't matter if it exists or not
     * @param $ar
     * @param $key
     * @param string $default
     * @param null $limit
     */
    public static function show($ar, $key, $default = "", $limit = NULL){
        $v = $default;
        if (isset($ar) && isset($ar["$key"])) {
            $v = $ar["$key"];
            if(is_string($v)){
                $v = trim($ar["$key"]);
            }
        }
        if(isset($limit)){
            echo substr($v,0, $limit);
            if(strlen($v) > $limit){
                echo "...";
            }
        }
        else{
            echo $v;
        }
    }
    public static function get($ar, $key, $default = ""){
        if (isset($ar) && isset($ar["$key"])) {
            $v = $ar["$key"];
            if(is_string($v)){
               $v = trim($ar["$key"]);
            }
            return $v;
        }
        else {
            return $default;
        }
    }
    public static function flash($msg){
        if(isset($_SESSION['flash'])){
            array_push($_SESSION['flash'], $msg);
        }
        else{
            $_SESSION['flash'] = array();
            array_push($_SESSION['flash'], $msg);
        }

    }
    public static function getMessages(){
        if(isset($_SESSION['flash'])){
            $flashes = $_SESSION['flash'];
            $_SESSION['flash'] = array();
            return $flashes;
        }
        return array();
    }
}
abstract class Visibility{
    const draft = 0;
    const private = 1;
    const public = 2;
}