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
                die();
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

//Menambahkan User Profile - Group
function tambah_group($groupname,$session,$download,$upload,$url){
        $groupname = cek_string($groupname);
        $session = cek_string($session);
        $download = cek_string($download);
        $upload = cek_string($upload);
        $url= cek_string($url);

        $MenitSession = $session * 60;

        $biteDownload = $download * 1024;
        $biteUpdaload = $upload * 1024;

        $sql1 = "INSERT INTO `radgroupreply` (`id`, `groupname`, `attribute`, `op`, `value`) VALUES (NULL, '$groupname', 'Session-Timeout', ':=', '$MenitSession');";
        if(run($sql1)){
            $sql2 = "INSERT INTO `radgroupreply` (`id`, `groupname`, `attribute`, `op`, `value`) VALUES (NULL, '$groupname', 'WISPr-Bandwidth-Max-Up', ':=', '$biteUpdaload');";
            if(run($sql2)){
                $sql3 = "INSERT INTO `radgroupreply` (`id`, `groupname`, `attribute`, `op`, `value`) VALUES (NULL, '$groupname', 'WISPr-Bandwidth-Max-Down', ':=', '$biteDownload');";
                if(run($sql3)){
                    $sql4 = "INSERT INTO `radgroupreply` (`id`, `groupname`, `attribute`, `op`, `value`) VALUES (NULL, '$groupname', 'WISPr-Redirection-URL', ':=', '$url');";
                    if(run($sql4)){
                        return true;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
       
}

//Menampilkan Group dan attribute berdasarkan nama
function tampil_groupprofile_by($groupname){
    $groupname = cek_string($groupname);
    $sql = "SELECT id,groupname,attribute,op,value FROM `radgroupreply` WHERE groupname = '$groupname'";
    $result = result($sql);
    foreach($result as $res){
        $data[] = $res['value'];
    }
    //die(print_r($data));
    $data[0] = $data[0] / 60;
    $data[1] = $data[1] / 1024;
    $data[2] = $data[2] / 1024;
    return $data;
}

//Menambahkan User Profile - Group
function ubah_group($groupname,$session,$download,$upload,$url,$oldName){
        $groupname = cek_string($groupname);
        $session = cek_string($session);
        $download = cek_string($download);
        $upload = cek_string($upload);
        $url= cek_string($url);
        $oldName = cek_string($oldName);

        $MenitSession = $session * 60;

        $biteDownload = $download * 1024;
        $biteUpdaload = $upload * 1024;
        $sql1 = "UPDATE `radgroupreply` SET `groupname` = '$groupname',`value` = '$MenitSession' WHERE `radgroupreply`.`groupname` = '$oldName' AND `radgroupreply`.`attribute` = 'Session-Timeout' ";
        if(run($sql1)){
            $sql2 = "UPDATE `radgroupreply` SET `groupname` = '$groupname',`value` = '$biteUpdaload' WHERE `radgroupreply`.`groupname` = '$oldName' AND `radgroupreply`.`attribute` = 'WISPr-Bandwidth-Max-Up' ";
            if(run($sql2)){
                $sql3 = "UPDATE `radgroupreply` SET `groupname` = '$groupname',`value` = '$biteDownload' WHERE `radgroupreply`.`groupname` = '$oldName' AND `radgroupreply`.`attribute` = 'WISPr-Bandwidth-Max-Down' ";
                if(run($sql3)){
                    $sql4 = "UPDATE `radgroupreply` SET `groupname` = '$groupname',`value` = '$url' WHERE `radgroupreply`.`groupname` = '$oldName' AND `radgroupreply`.`attribute` = 'WISPr-Redirection-URL' ";
                    if(run($sql4)){
                        return true;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
       
}

//hapus group
function hapus_group($groupname){
    $sql = "DELETE FROM `radgroupreply` WHERE `radgroupreply`.`groupname` = '$groupname'";
    $result1 = run($sql);
    $sql2 = "DELETE FROM `radusergroup` WHERE `radusergroup`.`groupname` = '$groupname'";
    $result2 = run($sql2);
    if($result1 && $result2){
        return true;
    }else{
        return false;
    }
}
//cek group
function cek_group($groupname,$attr){
    $sql = "SELECT groupname,attribute FROM radgroupreply WHERE groupname = '$groupname' AND attribute='$attr'";
    $result = result($sql);
    if(mysqli_num_rows($result) == 0){
        return true;
    }else{
        return false;
    }
}

//import user
function upload_user($file){
    $namaFile = $file['name'];
    $tmpFile = $file['tmp_name'];
    $simpan = 'asset/'.$namaFile;
    $errorFile = $file['error'];
    if($errorFile == 0){
        move_uploaded_file($tmpFile,$simpan);
        $csvFile = fopen($simpan, 'r');
        //fgetcsv($csvFile);
        while(($line = fgetcsv($csvFile)) != FALSE){

            $user = cek_string($line[0]);//username
            $password = cek_string($line[1]);//password
            $groupname = cek_string($line[2]);//groupname
            $upload = cek_string($line[3] * 1024);//attr up
            $download = cek_string($line[4] * 1024);//attr down
            $session = cek_string($line[5] * 60);//attr session
            $url = cek_string($line[6]);//attr url

            tambah_user($user,$password,$groupname);
            if(cek_group($groupname,'Session-Timeout')){
                $sqlSession = "INSERT INTO `radgroupreply` (`id`, `groupname`, `attribute`, `op`, `value`) VALUES (NULL, '$groupname', 'Session-Timeout', ':=', '$session');";
                run($sqlSession);
            }
            if(cek_group($groupname,'WISPr-Bandwidth-Max-Up')){
                $sqlUp = "INSERT INTO `radgroupreply` (`id`, `groupname`, `attribute`, `op`, `value`) VALUES (NULL, '$groupname', 'WISPr-Bandwidth-Max-Up', ':=', '$upload');";
                run($sqlUp);
            }
            if(cek_group($groupname,'WISPr-Bandwidth-Max-Down')){
                $sqlDown = "INSERT INTO `radgroupreply` (`id`, `groupname`, `attribute`, `op`, `value`) VALUES (NULL, '$groupname', 'WISPr-Bandwidth-Max-Down', ':=', '$download');";
                run($sqlDown);
            }
            if(cek_group($groupname,'WISPr-Redirection-URL')){
                $sqlUrl = "INSERT INTO `radgroupreply` (`id`, `groupname`, `attribute`, `op`, `value`) VALUES (NULL, '$groupname', 'WISPr-Redirection-URL', ':=', '$url');";
                run($sqlUrl);
            }

        }
        return true;
    }else{
        return false;
    } 
}

//cek jumlah pengguna
function cek_jumlah_pengguna(){
    $sql = "SELECT username FROM radcheck";
    $result = result($sql);
    return mysqli_num_rows($result);
}

//cek jumlah group
function cek_jumlah_group(){
    $sql = " SELECT groupname FROM `radgroupreply` GROUP BY groupname";
    $result = result($sql);
    return mysqli_num_rows($result);
}

//cek jumlah login
function cek_jumlah_login(){
    $sql = "SELECT id FROM `radpostauth` ";
    $result = result($sql);
    return mysqli_num_rows($result);
}

//menampilkan log login pengguna
function tampil_login_log(){
    $sql = "SELECT username, reply, authdate FROM `radpostauth`  ORDER BY `radpostauth`.`authdate` DESC";
    $result = result($sql);
    return $result; 
}
?>