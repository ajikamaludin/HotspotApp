<?php
include 'view/header.php';
session_cek()
?>

    <div class="row">

    <!--sidenav-->
<?php
include 'view/sidenav.php';
?>
<div style="margin-top:50px;margin-bottom:50px;"> </div>
<div class="container" >
    <ul class="collection with-header">
        <li class="collection-header"><h4>Hotspot Area : Web Based HotspotUser Management</h4></li>
         <li class="collection-item">Aktiv : <?= NAMA_SEKOLAH ?> , Code : <?= AKTIV_CODE ?></li>
        <li class="collection-item">Users : <?= cek_jumlah_pengguna() ?></li>
        <li class="collection-item">Groups : <?= cek_jumlah_group() ?></li>
        <li class="collection-item">Login Log : <?= cek_jumlah_login() ?></li>
    </ul>
</div>
</div>

<?php
include 'view/footer.php';
?>