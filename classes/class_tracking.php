<?php
class Tracking extends dbBasic{
    function Tracking(){
        $this->pkey = "id";
        $this->tbl = "tracking_order";
    }
    function getTrackingByUser($con = ''){
        $con = "WHERE 1> 0 ".$con;
        $sql = "SELECT users.uid, users.fullname, users.email, users.phone, tracking_order.*
                FROM users INNER JOIN tracking_order
                on users.uid = tracking_order.uid ".$con;
        $arr="";
        if($res = mysql_query($sql)){
            while($_cn= mysql_fetch_assoc($res)){
                $arr[] = $_cn;
            }
            return $arr;
        }else return array();
    }
}
?>