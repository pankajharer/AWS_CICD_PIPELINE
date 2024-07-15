<?php include"navbar.php"; ?>
<?php
session_start();
$csrf_admin = rand(1000,9000)."NM";
$_SESSION['csrf_admin'] = $csrf_admin;
?>
<style>
        body{
            /* background-image: url("svg/admin.svg"); */
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }
    </style>
    <div class="container p-4 mt-4 mb-5 shadow border rounded w-75">
        <h2 class="text-center">National Museum</h2>
        <h2 class="text-center">Login Admin</h2>
        <?php  
            if(isset($_SESSION['msg'])){  ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>
                <?php echo $_SESSION['msg'];                    
                    $_SESSION['msg'] = null; 
                ?>
                </strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>                
            </div>            
            <?php 
            }
        ?>
        <form action="admin_con.php" id="admin_login" method="POST" class="form p-4">
            <div class="mb-3">
                <label for="username" class="text-dark mb-2 fs-3 bg-light rounded px-4"><b>Username :</b></label>
                <input type="text" name="username" class="form-control" placeholder="Enter Username Here" required>
            </div>
            
            <input type="hidden" name="csrf_admin" value="<?php echo $csrf_admin; ?>">
            <div class="mb-3">
                <label for="password" class="text-dark mb-2 fs-3 bg-light rounded px-4"><b>Password :</b></label>
                <input type="password" name="password" class="form-control" placeholder="Enter Password Here" required>
            </div>
            <div class="text-center">
                <button class="btn btn-primary" name="loginBtn" type="submit">Login</button>
            </div>
        </form>
    </div>
</body>
</html>