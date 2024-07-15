<?php
session_start();
if(isset($_POST['sendMv'])){
    //extract data from the post
    
    //set POST variables
    $url = 'https://www.fast2sms.com/dev/bulk';
    $id = $_SESSION['visitor']['visitor_id'];
    $p = $_SESSION['visitor']['visitor_passwd'];
    $content = "Click http://localhost/museum/verifyphone.php?id=$id&p=$p to verify.";

    $fields = array(
        // 'authorization' => "qiPgO3zY0926hxKyVEHCFoBNraS1j4RIMZbtud5lDpJvfw8c7UPwa2JvkK4yr5uC0Ap6oS7lnMWYj3Ox",
        'sender_id' => "FSTSMS",
        'message' => $content,
        'language' => "english",
        'route' => "p",
        'numbers' => substr($_SESSION['visitor']['visitor_phone'], 2),
    );

    $fields_string = '';
    //url-ify the data for the POST
    foreach($fields as $key=>$value) { 
        $fields_string .= $key.'='.$value.'&';
    }

    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_SSL_VERIFYHOST => 0,
    CURLOPT_SSL_VERIFYPEER => 0,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode($fields),
    CURLOPT_HTTPHEADER => array(
        "authorization: tnQqDJ1Fe2R8HTzpOkblYBuNcsdGMZKyEjXvoVC306W4raLmhAt75fMWKsXjGkcnDY1bBOJIdmzvawp4",
        "accept: */*",
        "cache-control: no-cache",
        "content-type: application/json"
    ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "<script>alert('Something went wrong..!'); location.href = 'index.php'</script>";
    } else {
        echo "<script>alert('Verification link sent to the phone number.'); location.href = 'index.php'</script>";    
    }


    // if ($server_output == "OK") {
    //     echo $server_output;
    //     echo "<script>alert('Verification link sent to the phone number.');</script>";    
    // } else {
    //     echo "<script>alert('Not sent.');</script>";    
    //  }
    
    // echo "<script>alert('Verification link sent to the phone number.'); location.href = 'index.php'</script>";
}else{
    header("Location: index.php");
}
?>