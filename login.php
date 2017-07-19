<?php
include 'view/header.php';

//error variable null
$error = '';
//check login
if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
            if(!empty(trim($username)) && !empty(trim($password))){
                    if(cek_pengguna($username,$password) == 'true'){
                        $_SESSION['user'] = $username;
                        header('Location: index.php');
                    }else{
                        $error = 'Terjadi Kesalahan';
                    }
            }else{
                $error = 'E-mail dan Password Tidak Valid';
            }
}
?>

<div class="container">

<div class="row"><!--Empty Row--></div>

    <div class="row">

        <div class="col s12 m6">
        <div style="margin-bottom:70px;">
            <h2> <?= APPNAME ?> </h2>
        </div>
        <div class="row">
            <form class="col s12" method="POST">
                <div class="row">
                    <div class="input-field col s12">
                        <input id="username" type="text" class="validate" name="username">
                        <label for="username" data-error="wrong" data-success="right">Username</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="password" type="password" class="validate" name="password">
                        <label for="password">Password</label>
                    </div>
                </div>
                <button class="btn waves-effect waves-light" type="submit" name="submit">Masuk</button>
            </form>
        </div>
        <?php
            echo "".$error."";
        ?>
        </div>

      <div class="col m6"><!-- DIV KOSONG --></div>

</div>
</div>
</div>


<?php
include 'view/footer.php';
?>