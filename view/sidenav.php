      <div class="col s12 m4 l3"> 
            <ul id="slide-out" class="side-nav fixed">
                <li><div class="userView">
                        <div class="background">
                        <img src="asset/images/background.jpg">
                    </div>
                    <a href="./foto_profile.php"><img class="circle" src="asset/images/empty-profile.png"></a>
                    <a href="profile.php" ><span class="white-text name"><?= tampil_nama($_SESSION['user']); ?> </span></a>
                    <a href="profile.php" style="padding-bottom:20px;" ><span class="white-text name"><?= 'Aktiv : '.NAMA_SEKOLAH ?> </span></a>
                    </div>
                </li>
            <li><a class="waves-effect" href="index.php">Dashboard</a></li>
            <li><a class="waves-effect" href="user.php">User Hotspot</a></li>
            <li><a class="waves-effect" href="profile.php">User Profile</a></li>
            <li><a class="waves-effect" href="logout.php">Keluar</a></li>
            </ul>
      </div>