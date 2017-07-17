<?php
include 'view/header.php';
session_cek();

$name = $_GET['name'];
//tampil group
$group = tampil_groupprofile_by($name);

//Error Null
$error = null;

//Update Profile
if(isset($_POST['submit'])){
    $groupname = $_POST['groupname'];
    $session = $_POST['session'];
    $download = $_POST['download'];
    $upload = $_POST['upload'];
    $url= $_POST['url'];
    $oldname = $name;

    $result = ubah_group($groupname,$session,$download,$upload,$url,$oldname);
    if($result){
        header('Location: profile.php');
    }else{
        $error = "Terjadi Kesalahan";
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

          <h4 style="margin-bottom: 70px;margin-top:50px;">Ubah Hotspot Profile</h4>
          
          <div style="margin:40px;">
              <blockquote> <?= $error ?> </blockquote>
          </div>

          <div class="row">
              <form class="col s12" method="POST">
                  <div class="row">
                      <div class="input-field col s6">
                          <input id="groupname" placeholder="groupname" type="text" class="validate" name="groupname" required value="<?= $name ?>">
                          <label for="groupname" data-error="wrong" data-success="right">Group Name</label>
                      </div>
                  </div>
                  <div class="row">
                      <div class="input-field col s6">
                          <input id="session" placeholder="session" type="number" class="validate" name="session" required value="<?= $group[0] ?>">
                          <label for="session" data-error="wrong" data-success="right">Session (Menit)</label>
                      </div>
                  </div>
                  <div class="row">
                      <div class="input-field col s6">
                          <input id="download" placeholder="download" type="number" class="validate" name="download" required value="<?= $group[1] ?>">
                          <label for="download" data-error="wrong" data-success="right">Max Download (KBps)</label>
                      </div>
                  </div>
                  <div class="row">
                      <div class="input-field col s6">
                          <input id="upload" placeholder="upload" type="number" class="validate" name="upload" required value="<?= $group[2] ?>">
                          <label for="upload" data-error="wrong" data-success="right">Max Upload (KBps)</label>
                      </div>
                  </div>
                  <div class="row">
                      <div class="input-field col s6">
                          <input id="url" placeholder="http://smknet.id" type="url" class="validate" name="url" required value="<?= $group[3] ?>">
                          <label for="url" data-error="wrong" data-success="right">Redirect URL </label>
                      </div>
                  </div>

                  <button class="btn waves-effect waves-light" type="submit" name="submit"> Simpan </button>
              </form>
          </div>
<?php
include 'view/footer.php';
?>