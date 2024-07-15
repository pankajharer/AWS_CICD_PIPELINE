<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Verification Email</title>
</head>
<body>
    <div class="container" >
        <br>        
        <div style="background-color:transperent; font-family:sans-serif;padding:20px;text-align: justify; justify-content: center;">
            <h1>Welcome to National Museum</h1><br>
            <br><br>
            <p style="text-align: left;font-size: 20px; ">We are very glad to see you here..!! We hope you are fine. <br><br>
            Thank you for showing interest in <b>Ticketless Entry Pass</b>.<br><br>
            The importance of the museum in our society is unmatchable. It not only brings people belonging from different cultures and backgrounds under one roof but also feeds their hunger to know more about our World's ancient history.<br><br>
            The rarest specimens might give you the chills<br><br>
            Please verify your email by clicking.</p>
        
            <div style="text-align: center;">
                <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/museum/verifyemail.php?email=<?php echo $email; ?>&id=<?php echo $visitor_id; ?>"><button style="background-color:#2965ff; padding:5%; border-radius: 10px; border: 5px solid #03fcd3; font-size: 25px; cursor:pointer; font-weight:bold;padding:1%;color:white;">Verify Email</button></a>
            </div>
        </div>        
    </div>
</body>
</html>