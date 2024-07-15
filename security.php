<?php include"navbar.php"; ?>
<?php
session_start();
$csrf_security = rand(1000,9000)."NM";
$_SESSION['csrf_security'] = $csrf_security;
?>
<style>
        .container{
            /* background-image: url("security.png"); */
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }
    </style>
    <div class="container p-4 mt-4 mb-5 shadow border rounded w-75">
        <h2 class="text-center">National Museum</h2>
        <h2 class="text-center">Login Security</h2>
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
        <form action="security_con.php" id="security_login" method="POST" class="form p-4">
            <div class="mb-3">
                <label for="username" class="mb-2 fs-3 rounded px-4"><b>Security ID :</b></label>
                <input type="text" name="sec_id" class="form-control" placeholder="Enter your ID here" required>
            </div>
            
            <input type="hidden" name="csrf_security" value="<?php echo $csrf_security; ?>">
            <div class="mb-3">
                <label for="password" class="mb-2 fs-3 rounded px-4"><b>Password :</b></label>
                <input type="password" name="sec_passwd" class="form-control" placeholder="Enter Password Here" required>
            </div>
            <div class="text-center">
                <button class="btn btn-primary" name="loginBtn" type="submit">Login</button>
            </div>
        </form>
    </div>
</body>
</html>