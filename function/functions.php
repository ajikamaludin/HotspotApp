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
    $sql = "SELECT username FROM `AppUsers` WHERE username='$username'";
    $result = result($sql);
    if(mysqli_num_rows($result) == 0){
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

//Memerisa Nama Group Dari Pengguna
function tampil_group_by($username){
    $sql = "SELECT username,groupname FROM `radusergroup` WHERE username='$username'";
    $result = result($sql);
    if(mysqli_num_rows($result) != 0){
        $result = mysqli_fetch_assoc($result);
        $group = $result['groupname'];
        return $group;
    }else{
        return 'Tidak Ada';
    }
    
}

//Menampilkan Satu Per Semua Group dari Groupreply
function tampil_group(){
    $sql = " SELECT groupname FROM `radgroupreply` GROUP BY groupname";
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

?>