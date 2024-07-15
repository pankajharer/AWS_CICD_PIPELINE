<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>National Museum Credentials</title>
</head>
<body>
    <div class="container" >
        <br>        
        <div style="font-family:sans-serif;padding:10px;text-align:center;">
            <h1>Welcome to National Museum</h1>
            <p style="font-family: monospace">Where Life and Science meets in a place</p>
                <br>
                <p style="font-size: 20px; text-align: left;">We are very glad to see you here..!! We hope you are fine. <br><br>
                "A place where exploration meets curiosity"<br><br>
                Your National Museum Login Credentials are<br><br> <b>Email ID : <?php echo $email; ?><br> Password : <?php echo $password; ?></b><br><br>
                Wish you have a nice Day..!<br><br>
            </p>
            <div style="text-align: center;">            
                <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/museum"><button style="background-color:#2965ff; padding:5%; border-radius: 10px; border: 5px solid #03fcd3; font-size: 25px; cursor:pointer; font-weight:bold;padding:1%;color:white;">Continue</button></a>
            </div>            
        </div>
    </div>
</body>
</html>