<?php
require '../include/Db-connection.php';


if (isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $inputEmail = $_POST['email'];
    $password = $_POST['password'];
    $inputfile = $_FILES['inputfile'];

    // hash password and validate email
    $hashPassword = password_hash($password, PASSWORD_DEFAULT);
    $validEmail = filter_var($inputEmail, FILTER_SANITIZE_EMAIL);

    // file uploads
    if (isset($_FILES["inputfile"])) {
        $file_name = $_FILES['inputfile']['name'];
        $file_size = $_FILES['inputfile']['size'];
        $file_tmpnm = $_FILES['inputfile']['tmp_name'];

        // rename the file
        $uploaded_file_name = date('d-m-y h:i:s') . $file_name;
        
        // move file to folder
        $isUploaded  = (move_uploaded_file($file_tmpnm, "../assets/images/user-images/" . $uploaded_file_name));

        
       // check if user alredy exists or not..
        function checkUserExists(){
            global $PDO;
            global $inputEmail;
            $sql = 'select email from  to_do_list.tbl_user;';
            $statement = $PDO->query($sql);
            $credentials = $statement->fetchAll(PDO::FETCH_ASSOC);

            $dbEmail = $credentials[0]['email'];

            if($dbEmail == $inputEmail){
                echo '<script type="text/javascript">';
                echo 'alert("Oops User Already Registered.. You need to login");';
                echo 'window.location.href = "login.php";';
                echo '</script>';
                return false;
            }else {
                return true;
            }

        }
        // insert a record into database
        if ($isUploaded && checkUserExists()) {
            try {

                $sql = 'insert into to_do_list.tbl_user(fname, lname, email, password, image) values (:fname, :lname, :email, :password, :image)';
                $statement = $PDO->prepare($sql);

                $statement->execute([
                    ':fname' => $fname,
                    ':lname' => $lname,
                    ':email' => $validEmail,
                    ':password' => $hashPassword,
                    'image' => $uploaded_file_name
                ]);
                echo '<script type="text/javascript">';
                echo 'alert("User Registered Successfully !! click ok go to login");';
                echo 'window.location.href = "login.php";';
                echo '</script>';
            } catch (PDOException $e) {

                echo $e->getMessage();
            }
        }
    }
}
?>

<?php require '../include/boostarp.php'; ?>

<body class="p-0 m-0 border-0 bd-example" style="background:linear-gradient(#F1DEC9, #E9EDC9, #CBE4DE, #E9A178)">
    <div class="main-container">

        <div class="container w-50 p-3 my-4 bg-body-secondary border border-primary-subtle">
            <h1 class="text-center">Sign Up</h1>
            <div class="text-success">
                <hr>
            </div>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" onsubmit="return validateRegister()" enctype="multipart/form-data">
                <div class="row">
                    <label for="name" class="form-label py-2">Name</label>
                    <div class="col">
                        <input type="text" id="fname" class="form-control" name="fname" placeholder="First name" aria-label="First name">
                    </div>
                    <div class="col">
                        <input type="text" id="lname" class="form-control" name="lname" placeholder="Last name" aria-label="Last name">
                    </div>
                    <p id="nameError"></p>
                </div>

                <div class="mb-3">

                    <label for="inputEmail" class="form-label py-2">Email</label>
                    <input type="text" class="form-control" name="email" id="inputEmail" aria-describedby="emailHelp">
                    <p id="emailError"></p>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label py-2">Password</label>
                    <input type="password" class="form-control" name="password" id="password" aria-describedby="emailHelp">
                    <p id="passwordError"></p>
                </div>

                <div class="mb-3">
                    <label for="cpassword" class="form-label py-2">Confirm Password</label>
                    <input type="password" class="form-control" name="password" id="cpassword" aria-describedby="emailHelp">
                    <p id="cpasswordError"></p>
                </div>

                <div class="input-group mb-3">
                    <input type="file" name=inputfile onchange="return fileValidation()" class="form-control" id="inputfile">
                    <label class="input-group-text" for="inputfile">Upload</label>
                </div>
                <p id="fileError"></p>
                <p class="text-end">Alredy Registerd Login Here...</p>
                <div class="d-flex justify-content-between">
                    <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
                    <a href="./login.php" class="btn btn-primary" tabindex="-1" role="button" aria-disabled="true">Login</a>
                </div>

            </form>
        </div>


    </div>


    <script src="../assets/js/formValidation.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>