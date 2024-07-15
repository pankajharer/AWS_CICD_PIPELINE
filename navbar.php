<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="img/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link href="https://cdn.rawgit.com/michalsnik/aos/2.1.1/dist/aos.css" rel="stylesheet" />

    <script src="https://kit.fontawesome.com/18b4046e5e.js" crossorigin="anonymous"></script>

    
    <title>National Museum</title>
    <style>
        div{
            transition: 1s all ease;
        }
        .slist1 li:hover{
            color: red;
        }
        .scrollup {
            background-color: #00ffa6;
            width: 50px;
            font-size: 20px;
            height: 50px;
            text-align: center;
            bottom: 10px;
            right: 10px;
            position: fixed;
            border-radius: 10%;
            cursor: pointer;
            z-index: 99;
            padding: 10px;
        }
    </style>
</head>
<body>
<!-- Navigation bar starts -->
<nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand text-info" href="/museum"><b><i class="fas fa-landmark"></i> National Museum</b></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav flex">
                    <a class="nav-link active" aria-current="page" href="/museum"><b>Home</b></a>
                    <a class="nav-link" href="/museum#about"><b>About</b></a>
                    <a class="nav-link" href="/museum#vision"><b>Vision</b></a>
                    <a class="nav-link" href="/museum/gallery"><b>Gallery</b></a>
                    <a class="nav-link" href="/museum/login.php"><b>Book Now..!</b></a>
                    <a class="nav-link" href="/museum/admin.php"><b>Admin</b></a>
                    <a class="nav-link" href="/museum/security.php"><b>Security Guard</b></a>
                </div>
            </div>
            <a href="/museum#contact"><button class="btn btn-outline-success my-2 my-sm-0">Contact</button></a>
        </div>
    </nav>
    <!-- Navigation bar ends -->