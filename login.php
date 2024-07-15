<?php include"navbar.php"; ?>
    
    <style>
        body{
            /* background-image: url("svg/login.svg"); */
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }
    </style>
    <div class="container p-4 mt-4 mb-5 shadow border rounded w-75">    
    <h2 class="text-info m-4 text-center">Login here..!</h2>
        <?php
            session_start();
            $csrf_login = rand(10000, 90000);
            $_SESSION['csrf_login'] = $csrf_login;
        ?>
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
            if(isset($_SESSION['resend'])){
                ?>
                <form action="resendEv.php" method="POST" class="text-align: center;">
                    <input type="hidden" name="id" value="<?php echo $_SESSION['resend']['visitor_id']; ?>">
                    <input type="hidden" name="email" value="<?php echo $_SESSION['resend']['visitor_email']; ?>">
                    <button type="submit" name="resend" value="pressed" class="btn btn-primary">Resend Email Verification</button>
                </form>
                <?php
                $_SESSION['resend'] = null;
            }
        ?>      
        
        <form action="login_con.php" method="post">
            <div class="mt-5">
                <label for="email" class="mb-2"><b>Email ID</b></label>
                <input type="email" placeholder="john@gmail.com" name="email" id="email" class="form-control" required>                    
            </div>
            <div class="mt-4">
                <label for="passwd" class="mb-2"><b>Password</b></label>
                <input type="hidden" name="csrf_login" value="<?php echo $csrf_login; ?>">
                <input type="password" placeholder="********" name="passwd" id="passwd" class="form-control" required>
                <a href="forgot-password.php">Forgot Password ?</a>
            </div>
            <div class="text-center pt-4">
                <button class="btn btn-primary" name="login" value="true"><b>Login </b><i class="fa fa-arrow-right"></i></button>
                <p class="" style="font-family: Sans-serif;">Not have an account? <br> <a href="register.php">Register here</a></p>
            </div>
        </form>
    </div>
</body>
</html>