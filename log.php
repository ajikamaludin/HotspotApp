<?php
include 'view/header.php';
session_cek();

$logs = tampil_login_log();

?>


    <div class="row">

    <!--sidenav-->
<?php
include 'view/sidenav.php';
?>
    <!--main content-->
      <div class="col s12 m8">

        <h4 style="margin-bottom: 30px;">Hotspot Users Login Log</h4>

      <div class="row" id="data-table">
        <div class="row" >
          <table class="responsive-table striped" id="table_id" width="100%" cellspacing="0" data-page-length='5'>
          <thead>
            <tr>
                <th>No</th>
                <th>Nama Profile</th>
                <th>Status</th>
                <th>Waktu</th>
            </tr>
          </thead>
          <tbody>
          <?php
          $i = 1;
          foreach($logs as $log){
          ?> 
            <tr id="data_<?= $log['username']?>">
              <td><?= $i++ ?></td>
              <td> <?= $log['username'] ?> </td>
              <td> <?= $log['reply'] ?> </td>
              <td> <?= $log['authdate'] ?> </td>
            </tr>
          <?php
          }
          ?>
          </tbody>
        </table>
        </div>

        <div class="fixed-action-btn" style="bottom: 25px; right: 24px;">
            <a class="btn-floating btn-large red" href="profile_tambah.php">
              <i class="material-icons">add_circle_outline</i>
            </a>
          </div>
      </div>
      </div>

<?php
include 'view/footer.php';
?>