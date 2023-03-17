<?php
session_start();
if (isset($_SESSION['email'])) {
    header("Location:dashboard.php");
}

if (isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

    require '../include/Db-connection.php';
    try {

        $statement = $PDO->prepare("select id, email, password from  to_do_list.tbl_user where email = :email;");
        $statement->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
        $statement->execute();
        $credentials = $statement->fetch(PDO::FETCH_ASSOC);

        //$credentials = $statement->fetchAll();

    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    $dbUserId = $credentials['id'];
    $dbEmail = $credentials['email'];
    $dbPassword = $credentials['password'];                         // default username - admin,  password - admin123
    $validPassword = password_verify($_POST['password'], $dbPassword);


    // save the session data and validate user
    session_start();
    if ($dbEmail == $_POST['email'] && $validPassword == true) {
        $_SESSION['id'] = $dbUserId;
        $_SESSION['email'] = $dbEmail;

        echo $_SESSION['id'];
        echo $_SESSION['email'];

        header("Location:dashboard.php");
    } else {
        echo '<script>alert("Invalid Username/Passsword")</script>';
    }
}
?>




<?php require '../include/boostarp.php'; ?>

<body class="p-0 m-0 border-0" style="background:url(../assets/images/styles-images/16-03-23\ 10:48:375172658.jpg);">

    <div class="container w-25 mt-5 p-3 bg-body-secondary border border-primary-subtle rounded">
        <h3 class="text-left">Log In</h3>
        <hr class="border border-danger border-2 opacity-50">
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" onsubmit="return validateLogin()">
            <div class="mb-3">
                <label for="inputEmail" class="form-label">E-mail</label>
                <input type="text" class="form-control" placeholder="Enter your email..." name="email" id="inputEmail" aria-describedby="emailHelp">
                <p id="emailError"></p>
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="inputPassword" class="form-label">Password</label>
                <input type="password" name="password" placeholder="Enter your password..." class="form-control" id="inputPassword">
                <p id="passwordError"></p>
            </div>
            <p class="text-end">New user login here...</p>
            <div class="d-flex justify-content-between">
                <button type="submit" name="submit" value="submit" class="btn btn-primary">Log In</button>
                <a href="./register.php" class="btn btn-primary" tabindex="-1" role="button" aria-disabled="true">Sign Up</a>
            </div>
        </form>
    </div>
    <script src="../assets/js/formValidation.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>