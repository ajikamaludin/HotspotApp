      <div class="col s12 m4 l3"> 
            <ul id="slide-out" class="side-nav fixed">
                <li><div class="userView">
                        <div class="background">
                        <img src="asset/images/background.jpg">
                    </div>
                    <img class="circle" src="asset/images/empty-profile.png">
                    <span class="white-text name"><?= tampil_nama($_SESSION['user']); ?> </span></a>
                    <a href="index.php" style="padding-bottom:20px;" ><span class="white-text name"><?= 'Aktiv : '.NAMA_SEKOLAH ?> </span></a>
                    </div>
                </li>
            <li><a class="waves-effect" href="index.php">Dashboard</a></li>
            <li><a class="waves-effect" href="user.php">User Hotspot</a></li>
            <li><a class="waves-effect" href="profile.php">User Profile</a></li>
            <li><a class="waves-effect" href="log.php">Login Log</a></li>
            <li><a class="waves-effect" href="logout.php">Keluar</a></li>
            </ul>
      </div>