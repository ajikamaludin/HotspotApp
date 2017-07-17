<?php
include 'view/header.php';
session_cek();

$groups = tampil_group();

?>


    <div class="row">

    <!--sidenav-->
<?php
include 'view/sidenav.php';
?>
    <!--main content-->
      <div class="col s12 m8">

        <h4 style="margin-bottom: 30px;">Hotspot Users Profile</h4>

      <div class="row" id="data-table">
        <div class="row" >
          <table class="responsive-table striped" id="table_id" width="100%" cellspacing="0" data-page-length='25'>
          <thead>
            <tr>
                <th>Nama Profile</th>
                <th>Attribut</th>
                <th>Hapus</th>
            </tr>
          </thead>
          <tbody>
          <?php
          foreach($groups as $group){
          ?> 
            <tr id="data_<?= $group['id']?>">
              <td> <?= $group['groupname'] ?> </td>
              <td> <?php 
                    $groupattrs = tampil_group_attribute($group['groupname']);
                    foreach($groupattrs as $atts){
                      echo $atts['attribute'].' : '.$atts['value'].'<br>';
                    }
               ?> </td>
              <td> <a href="" title="Edit"><i class="material-icons">mode_edit</i></a>
              <a href="#" class="hapusUser" data-id="<?= $group['id']?>" data-postid="<?= $group['id']?>" title="Hapus"><i class="material-icons">clear</i></a>
              </td>
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

<?php
include 'view/footer.php';
?>