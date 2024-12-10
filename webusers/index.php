<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="style.css">
    <title>POWERPUFF BOYS EXPRESS || Home Page</title>
</head>
<body>
<style>
:root {
    --primary-color:rgb(231, 140, 137);
    --color-white: #fff;
    --color-black: rgb(46, 38, 24);
}
*,
*::before,
*::after {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
.wrap{
    border: 5px transparent;
}
.searchTerm{
    height: 20px;
    width: 300px;
    border-radius:  20px 20px ;
    outline: rgb(0,204, 204);
    padding: 20px;
}
.nav-link{
    padding-right: 40px;
}
.fa {
    box-sizing: border-box;
    font-size: 20px;
    background-color:rgb(231, 140, 137);
    color: #fff;
    outline: rgb(231, 140, 137);
}
</style>
<header>
    <div class="main-nav">
        <a href="index.php" class="logo" style="font-weight: bolder;">POWERPUFF BOYS EXPRESS</a>
        <div class="wrap">
            <form action="track_package.php" method="GET">
                <div class="search">
                    <input type="text" class="searchTerm" name="tracking_num" placeholder="TRACK YOUR PACKAGE" required>
                    <button type="submit" class="searchButton">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
        <ul class="nav-link">
            <li><a href="index.php" style="font-size: 20px;">HOME</a></li>
            <li><a href="contact.html"style="font-size: 20px;">CONTACT US</a></li>
            <li><a href="about.html"style="font-size: 20px;">ABOUT US</a></li>
        </ul>
        <ul>
            <li>
                <a href="#"><i class="fab fa-facebook-f"></i></a>
            </li>
            <li>
                <a href="#"><i class="fab fa-twitter"></i></a>
            </li>
            <li>
                <a href="#"><i class="fab fa-instagram-square"></i></a>
            </li>
        </ul>
    </div>
</header>
<div class="container">
    <div class="hero">
        <div class="content">
            <h1 class="heading-primary" style="font-weight: bolder;">
                DELIVER FAST!, TRACK FAST!
            </h1>
            <p>
                Kailangan mo ng isang mabilis? POWER RUSH. New bilis-delivery service to Visayas to Mindanao!
            </p>
            <a href="contact.html" class="btn">Contact Now</a>
        </div>
        <div class="hero-img">
            <img src="lbc.png" alt="Hero Image" style="width: 100%; height: 75%;">
        </div>
    </div>
</div>
</body>
</html>
