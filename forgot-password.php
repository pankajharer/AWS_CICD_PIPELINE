<?php include"navbar.php"; ?>
        
    <div class="container p-4 mt-5 mb-5 shadow border rounded">
    <p class="text-primary m-5 text-center fs-1"><b>Forgot Password</b></p>
        <?php
            session_start();
            $csrf_fp = rand(10000, 90000);
            $_SESSION['csrf_fp'] = $csrf_fp;
        ?>        

        <form action="fp_con.php" method="post">
            <div class="mt-5">
                <label for="email" class="mb-2 text-info fs-3"><b>Enter Email ID</b></label>
                <input type="hidden" name="csrf_fp" value="<?php echo $csrf_fp; ?>">
                <input type="email" placeholder="john@gmail.com" name="email" id="email" class="form-control" required>                    
            </div>
            <div class="text-center pt-4">
                <button class="btn btn-primary" name="forgot" value="true"><b>Send </b><i class="fa fa-arrow-right"></i></button>
            </div>
        </form>
    </div>
</body>
</html>