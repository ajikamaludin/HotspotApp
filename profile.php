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
                <th>Nama Profile</th>
                <th>Attribut</th>
                <th>Hapus</th>
            </tr>
          </thead>
          <tbody>
          <?php
          foreach($users as $user){
          ?> 
            <tr id="data_<?= $user['id']?>">
              <td> <?= $user['username'] ?> </td>
              <td> <?= tampil_group_by($user['username']) ?> </td>
              <td> <a href="#" class="hapus_post" data-id="<?= $user['id']?>" data-postid="<?= $user['id']?>">Hapus</a> </td>
            </tr>
          <?php
          }
          ?>
          </tbody>
        </table>
        </div>

        <div class="fixed-action-btn" style="bottom: 25px; right: 24px;">
            <a class="btn-floating btn-large red" href="user/new">
              <i class="material-icons">replay</i>
            </a>
          </div>
      </div>

<?php
include 'view/footer.php';
?>