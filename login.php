<?php include 'connection.php'; ?>

<?php 
if (isset($_POST['login'])) {
		
		$user = $_POST['user'];
		$pass = $_POST['pass'];


		$sql = "SELECT * FROM users WHERE `Username` = '$user'";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = $result->fetch_assoc();

		session_regenerate_id();
		$_SESSION['username'] = $data['Username'];
		$_SESSION['company_name'] = $data['company_name'];
		session_write_close();

		if($data['Password'] == $pass && $data['Position'] == 'courier'){

			header("Location:courier.php");

		}else if($data['Password'] == $pass && $data['Position'] == 'Admin'){

				header("Location:dashboard.php");
		}else{

			echo "Incorrect Credentials";
			}

		}

		?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<div class="cont">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card" id="signIn">
                <h5 class="card-header">Sign In</h5>
                <div class="card-body">
                    <form method="POST">
                        <div class="input-group mb-3">
                            <i class="fas fa-envelope"></i>
                            <input type="text" name="user" placeholder="Company Name" required>
                            <label for="email">Company Name</label>
                        </div>
                        <div class="input-group mb-3">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="pass" id="password" placeholder="Password" required>
                            <label for="password">Password</label>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Sign In" name="login">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
	.cont{
		padding-top: 100px;
		
	}
</style>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>
</html>