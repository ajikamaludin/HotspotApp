<?php
include 'view/header.php';
session_cek();
$groups = tampil_group();

$id = $_GET['id'];

$user = tampil_user_by($id);

//Error Null
$error = null;

//Menambahkan User
if(isset($_POST['submit'])){
  $username = $_POST['username'];
  $password = $_POST['password'];
  $group = $_POST['group'];
  $oldname = $user['username'];
  $run = edit_user($username,$password,$group,$id,$oldname);
  if($run){
    $error = "User diubah";
    header('Location: user.php');
  }else{
    $error = "Tidak dapat menambahkan user";
  }
  
}
?>
    <div class="row">

    <!--sidenav-->

<?php
include 'view/sidenav.php';
?>

      <!--main content-->
        <div class="col s12 m8">

          <h4 style="margin-bottom: 70px;margin-top:50px;">Ubah Hotspot Users</h4>
          
          <div style="margin:40px;">
              <blockquote> <?= $error ?> </blockquote>
          </div>

          <div class="row">
              <form class="col s12" method="POST">
                  <div class="row">
                      <div class="input-field col s6">
                          <input id="username" placeholder="user01" type="text" class="validate" name="username" required value=<?= $user['username']?>>
                          <label for="username" data-error="wrong" data-success="right">Username</label>
                      </div>
                  </div>

                  <div class="row">
                      <div class="input-field col s6">
                          <input id="password" type="password" class="validate" name="password" required value=<?= $user['value']?>>
                          <label for="password">Password</label>
                      </div>
                  </div>

                  <div class="row">
                    <div class="input-field col s6">
                      <select name="group" required>
                              <option name="group" value="<?=tampil_groupId_by($user['username'])?>" selected> <?=tampil_group_by($user['username'])?> </option>
                              <?php
                                while( $group = mysqli_fetch_assoc($groups)){
                              ?>
                                <option name="group" value=<?= $group['groupname'] ?>><?= $group['groupname'] ?> </option>
                              <?php
                                }
                              ?>
                      </select>
                  <label>Group</label>
                    </div>
                  </div>

                  <button class="btn waves-effect waves-light" type="submit" name="submit"> Simpan </button>

              </form>
          </div>
          </div>

<?php
include 'view/footer.php';
?>