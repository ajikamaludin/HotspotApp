<?php

//Menampilkan Hasil Query
function result($query){
    global $link;
    $result = mysqli_query($link,$query);
    return $result;
}

//Check Query
function run($query){
    global $link;
    $result = mysqli_query($link,$query);
    if($result){
        return true;
    }else{
        return false;
    }
}

//Melihat Session
function session_cek(){
    if(!$_SESSION['user']){
    header('Location: login.php');
    }
}

//Melihat String
function cek_string($data){
    global $link;
    $data = mysqli_real_escape_string($link, $data);
    $data = trim($data);
    return $data;
}

//Menampilkan Nama Pengguna
function tampil_nama($username){
    $sql = " SELECT Nama FROM AppUsers WHERE username='$username' ";
    $result = result($sql);
    $result = mysqli_fetch_assoc($result);
    $result = $result['Nama'];
    return $result;
}

//Memeriksa Pengguna Login
function cek_pengguna($username,$password){
    $username = cek_string($username);
    $password = cek_string($password);
    $password = md5($password);
    $sql = "SELECT username, password FROM `AppUsers` WHERE username='$username' AND password='$password'";
    $result = result($sql);
    if(mysqli_num_rows($result) != 0){
        return true;
    }else{
        return false;
    }
}


//Memeriksa Username
function cek_user_by($username){
    $username = cek_string($username);
    $sql = "SELECT username FROM `radcheck` WHERE username='$username'";
    $result = result($sql);
    if(mysqli_num_rows($result) != 0){
        return true;
    }else{
        return false;
    }
}

//Mempilkan Semua Pengguna
function tampil_users(){
    $sql = "SELECT id, username, attribute, op, value FROM `radcheck`";
    $result = result($sql);
    if(!$result){
        echo "hasil query salah";
        return;
    }
    return $result; 
}

//Mempilkan Pengguna dengan ID
function tampil_user_by($id){
    $sql = "SELECT id, username, attribute, op, value FROM `radcheck` WHERE id='$id'";
    $result = result($sql);
    if(!$result){
        echo "hasil query salah";
        return;
    }
    $result = mysqli_fetch_assoc($result);
    return $result; 
}

//Memerisa Nama Group Dari Pengguna
function tampil_group_by($username){
    $sql = "SELECT username,groupname FROM `radusergroup` WHERE username='$username'";
    $result = result($sql);
    if(mysqli_num_rows($result) != 0){
        $result = mysqli_fetch_assoc($result);
        $group = $result['groupname'];
        return $group;
    }else{
        return null;
    }  
}

//Memerisa Id Group Dari Pengguna
function tampil_groupId_by($username){
    $sql = "SELECT username,groupname FROM `radusergroup` WHERE username='$username'";
    $result = result($sql);
    if(mysqli_num_rows($result) != 0){
        $result = mysqli_fetch_assoc($result);
        $id = $result['id'];
        return $id;
    }else{
        return null;
    }  
}

//Menampilkan Satu Per Semua Group dari Groupreply
function tampil_group(){
    $sql = " SELECT groupname FROM `radgroupreply` GROUP BY groupname";
    $result = result($sql);
    return $result;
}

//Menampilkan groupreply attribute
function tampil_group_attribute($groupname){
    $sql = " SELECT `id`,`attribute`,`op`,`value` FROM `radgroupreply` WHERE groupname='$groupname'";
    //die(print_r($sql));
    $result = result($sql);
    return $result;
}
//menambahkan pengguna dan merelasikan ke usergroup
function tambah_user($username,$password,$groupname){
        $username = cek_string($username);
        $password = cek_string($password);
        if(cek_user_by($username)){
            return false;
        }else{
            $sql = "INSERT INTO `radcheck` (`id`, `username`, `attribute`, `op`, `value`) VALUES (NULL, '$username', 'User-Password', ':=', '$password')";
            if($groupname == null){
                //group tidak di tambahkan
            }else{
                $groupname = cek_string($groupname);
                $sql2 = "INSERT INTO `radusergroup` (`id`, `username`, `groupname`, `priority`) VALUES (NULL, '$username', '$groupname', '10')";
                run($sql2);
            }
            return run($sql);
        }
}

//mengubah pengguna dan merelasikan ke usergroup
function edit_user($username,$password,$idGroup,$idUser,$oldName){
        $username = cek_string($username);
        $password = cek_string($password);
        $idUser = cek_string($idUser);
        $groupname = cek_string($idGroup);
        $group = gettype($idGroup);
        
            $sql = "UPDATE `radcheck` SET `username` = '$username', `value` = '$password' WHERE `radcheck`.`id` = '$idUser'";

            if($group == 'interger'){
                //group diubah dengan id
                $groupname = cek_string($idGroup);
                $sql2 = "UPDATE `radusergroup` SET `username` = '$username' WHERE `radusergroup`.`id` = '$idGroup'";
                die(print_r($sql2));
                run($sql2);
            }else if($group == 'string'){
                $oldName = cek_string($oldName);
                $sql2 = "DELETE FROM `radusergroup` WHERE `radusergroup`.`username` = '$oldName'";
                run($sql2);
                $sql3 = "INSERT INTO `radusergroup` (`id`, `username`, `groupname`, `priority`) VALUES (NULL, '$username', '$groupname', '10')";
                run($sql3); 
            }else{
                die(print_r($group));
            }
            return run($sql);
}

//hapus pengguna
function hapus_user($username){
    $sql = "DELETE FROM `radcheck` WHERE `radcheck`.`username` = '$username'";
    $result1 = run($sql);
    $sql2 = "DELETE FROM `radusergroup` WHERE `radusergroup`.`username` = '$username'";
    $result2 = run($sql2);
    if($result1 && $result2){
        return true;
    }else{
        return false;
    }
}
?>