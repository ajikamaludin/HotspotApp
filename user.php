<?php
include 'view/header.php';
session_cek();

$users = tampil_users();

?>


    <div class="row">

    <!--sidenav-->
<?php
include 'view/sidenav.php';
?>
    <!--main content-->
      <div class="col s12 m8">

    <h4 style="margin-bottom: 30px;">Hotspot Users</h4>
    
      <div class="row" id="data-table">
        <div class="row" >
          <table class="responsive-table highlight" id="table_id" width="100%" cellspacing="0" data-page-length='25'>
          <thead>
            <tr>
                <th>Username</th>
                <th>Password</th>
                <th>Profile</th>
                <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
          <?php
          foreach($users as $user){
          ?> 
            <tr id="data_<?= $user['id']?>">
              <td> <?= $user['username'] ?> </td>
              <td> <?= $user['value'] ?> </td>
              <td> <?= tampil_group_by($user['username']) ?> </td>
              <td> <a href="." title="Edit"><i class="material-icons">mode_edit</i></a>
              <a href="#" class="hapus_post" data-id="<?= $user['id']?>" data-postid="<?= $user['id']?>" title="Hapus"><i class="material-icons">clear</i></a> </td>
            </tr>
          <?php
          }
          ?>
          </tbody>
        </table>
        </div>

        <div class="fixed-action-btn" style="bottom: 25px; right: 24px;">
            <a class="btn-floating btn-large red" href="user_tambah.php">
              <i class="material-icons">add_circle_outline</i>
            </a>
          </div>
      </div>

<?php
include 'view/footer.php';
?>