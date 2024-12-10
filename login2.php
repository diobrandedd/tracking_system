<?php // Include the connection to the database
include 'connection.php';

// Check if the form is submitted
if (isset($_POST['login'])) {
    // Retrieve the values from the form
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    // Prepare the SQL query to prevent SQL injection
    $sql = "SELECT * FROM users WHERE `Username` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user);  // Bind the username parameter
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the user data
    if ($data = $result->fetch_assoc()) {
        // Regenerate session ID to prevent session fixation
        session_regenerate_id();
        $_SESSION['username'] = $data['Username'];
        $_SESSION['company_name'] = $data['company_name'];
        session_write_close();

        // Check if the password matches and user position
        if ($data['Password'] == $pass) {
            if ($data['Position'] == 'courier') {
                header("Location: courier.php");
                exit();
            } else if ($data['Position'] == 'admin') {
                header("Location: dashboard.php");
                exit();
            }
        } else {
            echo "Incorrect credentials!";
        }
    } else {
        echo "User not found!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
	<style>
		* { box-sizing: border-box; }
@import url('https://fonts.googleapis.com/css?family=Rubik:400,500&display=swap');


body {
  font-family: 'Rubik', sans-serif;
  background-color:#BFECFF;
}

.container {
  display: flex;
  height: 100vh;
}

.left {
  overflow: hidden;
  display: flex;
  flex-wrap: wrap;
  flex-direction: column;
  justify-content: center;
  animation-name: left;
  animation-duration: 1s;
  animation-fill-mode: both;
  animation-delay: 1s;
}

.right {
  flex: 1;
  background-color: black;
  transition: 1s;
  background-image: url(truck.jpg);
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
}



.header > h2 {
  margin: 0;
  color: #CC2B52;
  font-weight: bolder;
  font-size: 40px;
}

.header > h4 {
  margin-top: 10px;
  font-weight: normal;
  font-size: 15px;
  color: white;
}

.form {
  max-width: 80%;
  display: flex;
  flex-direction: column;
}

.form > p {
  text-align: right;
}

.form > p > a {
  color: #000;
  font-size: 14px;
}

.form-field {
  height: 46px;
  padding: 0 15px;
  border: 0 0 2px solid #ddd;
  border-radius: 20px 0 20px 0;
  font-family: 'Rubik', sans-serif;
  outline: 0;
  transition: .2s;
  margin-top: 20px;
}

.form-field:focus {
  border-color: #0f7ef1;
}

.form > #btn {
  padding: 12px 5px;
  border: 0;
  background: linear-gradient(to right, #de48b5 0%,#E195AB 100%); 
  border-radius: 3px;
  margin-top: 40px;
  color: #fff;
  letter-spacing: 2px;
  font-family: 'Rubik', sans-serif;
}

.animation {
  animation-name: move;
  animation-duration: .4s;
  animation-fill-mode: both;
  animation-delay: 2s;
}

.a1 {
  animation-delay: 2s;
}

.a2 {
  animation-delay: 2.1s;
}

.a3 {
  animation-delay: 2.2s;
}

.a4 {
  animation-delay: 2.3s;
}

.a5 {
  animation-delay: 2.4s;
}

.#a6 {
  animation-delay: 2.5s;
}

@keyframes move {
  0% {
    opacity: 0;
    visibility: hidden;
    transform: translateY(-40px);
  }

  100% {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
  }
}

@keyframes left {
  0% {
    opacity: 0;
    width: 0;
  }

  100% {
    opacity: 1;
    padding:20px 40px;
    width: 440px;
  }
}
	</style>
<div class="container">
  <div class="left">
    <div class="header">
      <h2 class="animation a1">Welcome Back</h2>
    </div>
    <form method="POST">
      <input type="text"  name="user" for class="form-field animation a3" placeholder="Company Name">
      <input type="password" name="pass" class="form-field animation a4" placeholder="Password">
      <div>
        <br>
            <input type="submit" class="animation a6 btn btn-primary" value="Sign In" name="login">
        </div>
    </form>
  </div>
  <div class="right"></div>
</div>
	
</body>
</html>