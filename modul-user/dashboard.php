<?php
@session_start();
include '../config/koneksi.php';
if (!$_SESSION['id_user']) {
    echo '<script>
    alert("anda mesti login dulu");
    window.location.href = "index.php";
    </script>
    ';
}

if (isset($_POST['id_user'])) {
    $id = $_POST['id_user'];
    $q =  "DELETE FROM tbl_user WHERE id_user = '$id'";
    $d = mysqli_query($connection, $q);
}
$q =  "SELECT * FROM tbl_user";
$d = mysqli_query($connection, $q);

if (isset($_POST['update'])) {
    $id = $_POST['id_update'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    if ($password != '') {
        $q =  "UPDATE tbl_user SET nama_lengkap = '$nama_lengkap', username = '$username', password = md5('$password')   WHERE id_user = '$id' ";
        $connection->query($q);
        header("Refresh:0");
    } else {
        $q =  "UPDATE tbl_user SET nama_lengkap = '$nama_lengkap', username = '$username' WHERE id_user = '$id' ";
        $connection->query($q);
        header("Refresh:0");
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    

    <title>Dashboard</title>
</head>

<body>

    <div class="container" style="margin-top: 50px">
        <div class="row">

            <?php include '../assets/menu.php';
            // echo $_SERVER['SERVER_NAME'];
            ?>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <label> Selamat Datang <?php echo $_SESSION['nama_lengkap'] ?><br> di Modul User</label><br>
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalRegister">+ tambah data</button>
                        <div class="modal fade" id="modalRegister" tabindex="-1" role="dialog" aria-labelledby="modalRegisterLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalRegisterLabel">Tambah Data</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Nama Lengkap</label>
                                            <input type="text" class="form-control" id="nama_lengkap" placeholder="Masukkan Nama Lengkap">
                                        </div>
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input type="text" class="form-control" id="username" placeholder="Masukkan Username">
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" class="form-control" id="password" placeholder="Masukkan Password">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-register btn-block btn-success">REGISTER</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>nama lengkap</th>
                                    <th>username</th>
                                    <th>password</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($r = mysqli_fetch_object($d)) {
                                    echo '<tr><td>' . $r->nama_lengkap . '</td>';
                                    echo '<td>' . $r->username . '</td>';
                                    echo '<td>' . $r->password . '</td>';
                                    echo '<td><a href="#" type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#myModal' . $r->id_user . '">Edit</a></td>';
                                    echo '<td><form action="" method="post"><input name="id_user" type="hidden" value=' . $r->id_user . '><button type="submit" class="btn btn-danger">hapus</form></td>';
                                    echo '<td></td></tr>';
                                    echo '<div class="modal fade" id="myModal' . $r->id_user . '" role="dialog" aria-labelledby="myModal' . $r->id_user . 'Label" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myModal' . $r->id_user . 'Label">EDIT DATA</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                        ';
                                    $id = $r->id_user;
                                    $q_edit =  "SELECT * FROM tbl_user WHERE id_user='$id'";
                                    $d_edit = mysqli_query($connection, $q_edit);
                                    while ($r_edit = mysqli_fetch_object($d_edit)) {
                                        echo    '
                                    <form action="" method="post">
                                    <div class="form-group">
                                                <label>Nama Lengkap</label>
                                                <input name="id_update" value=' . $r_edit->id_user . ' type="hidden">
                                                <input name="nama_lengkap" value=' . $r_edit->nama_lengkap . ' type="text" class="form-control" placeholder="Masukkan Nama Lengkap">
                                            </div>
                                            <div class="form-group">
                                                <label>Username</label>
                                                <input name="username" value=' . $r_edit->username . '  type="text" class="form-control"  placeholder="Masukkan Username">
                                            </div>
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input name="password" value=""  type="password" class="form-control"  placeholder="Masukkan Password">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="update" class="btn btn-update btn-block btn-primary">UPDATE</button>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>';
                                    }
                                }
                                ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>
</body>
<script>
    $(document).ready(function() {

        $(".btn-register").click(function() {

            var nama_lengkap = $("#nama_lengkap").val();
            var username = $("#username").val();
            var password = $("#password").val();

            if (nama_lengkap.length == "") {

                Swal.fire({
                    type: 'warning',
                    title: 'Oops...',
                    text: 'Nama Lengkap Wajib Diisi !'
                });

            } else if (username.length == "") {

                Swal.fire({
                    type: 'warning',
                    title: 'Oops...',
                    text: 'Username Wajib Diisi !'
                });

            } else if (password.length == "") {

                Swal.fire({
                    type: 'warning',
                    title: 'Oops...',
                    text: 'Password Wajib Diisi !'
                });

            } else {

                //ajax
                $.ajax({

                    url: "simpan-register.php",
                    type: "POST",
                    data: {
                        "nama_lengkap": nama_lengkap,
                        "username": username,
                        "password": password
                    },

                    success: function(response) {
                        let result = response.trim()
                        console.log(result)
                        if (result == "success") {

                            Swal.fire({
                                type: 'success',
                                title: 'Register Berhasil!',
                                text: 'silahkan login!'
                            }).then(function() {
                                window.location.href = 'dashboard.php';
                            });

                            $("#nama_lengkap").val('');
                            $("#username").val('');
                            $("#password").val('');

                        } else {

                            Swal.fire({
                                type: 'error',
                                title: 'Register Gagal!',
                                text: 'silahkan coba lagi!'
                            });

                        }

                        console.log(response);

                    },

                    error: function(response) {
                        Swal.fire({
                            type: 'error',
                            title: 'Opps!',
                            text: 'server error!'
                        });
                    }

                })

            }

        });


    });
</script>

</html>