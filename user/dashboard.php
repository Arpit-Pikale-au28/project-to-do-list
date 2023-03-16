<!-- check if user is logout or not -->
<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location:../index.php");
}
//get database connection
require '../include/Db-connection.php';


if (isset($_POST['submit']) && isset($_POST['todo'])) {


    //file uploads
    if ((isset($_FILES["inputfile"]) && !empty($_FILES['inputfile']['name']))) {
        $file_name = $_FILES['inputfile']['name'];
        $file_size = $_FILES['inputfile']['size'];
        $file_tmpnm = $_FILES['inputfile']['tmp_name'];

        // rename the file
        $uploaded_file_name = date('d-m-y h:i:s') . $file_name;

        // move file to folder
        move_uploaded_file($file_tmpnm, "../assets/images/to-do-images/" . $uploaded_file_name);

        // insert record into database.
        try {
            $statement = $PDO->prepare("INSERT INTO to_do_list.tbl_todo(todo, image, user_id) values (:todo, :image, :user_id);");
            $statement->execute([
                ':todo' => $_POST['todo'],
                ':image' => $uploaded_file_name,
                ':user_id' => $_SESSION['id']
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        try {
            $statement = $PDO->prepare("INSERT INTO to_do_list.tbl_todo(todo, user_id) values (:todo, :user_id);");
            $statement->execute([
                ':todo' => $_POST['todo'],
                ':user_id' => $_SESSION['id']
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
// get all todos of the user from database
$statement = $PDO->prepare('SELECT * FROM to_do_list.tbl_todo WHERE user_id = :user_id');
$statement->bindParam(':user_id', $_SESSION['id']);
$statement->execute();
$todoArray = $statement->fetchAll();

    // Delete a todo from database 
    if (isset($_POST['deleteButton'])) {
        $todo_id =  $_POST['deleteButton'];
        $statement = $PDO->prepare('DELETE FROM to_do_list.tbl_todo WHERE id = :id');
        $statement->bindParam(':id',$todo_id, PDO::PARAM_INT);
     
       if ($statement->execute()) {
        echo '<script type="text/javascript">';
        echo 'alert("Todo deleted successfully !!");';
        echo 'window.location.href = "dashboard.php";';
        echo '</script>';
       }


    }

    // edit a record from database
    // if (isset($_POST['editButton'])) {
    //     echo "This is editButton that is selected ". $_POST['deleteButton'];
    // }



?>




<!-- include bootstrap -->
<?php
require '../include/boostarp.php';
?>

<body>
    <?php require '../include/loginNavbar.php' ?>
    <div class="container mt-5">
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="creteTodo" class="form-label">Create To-Do's</label>
                <input type="text" required name="todo" placeholder="Enter To-do's Here..." class="form-control" id="creteTodo">
            </div>
            <div class="input-group mb-3">
                <input type="file" name="inputfile" onchange="return fileValidation()" class="form-control" id="inputfile">
                <label class="input-group-text" for="inputfile">Insert Image</label>
            </div>
            <p id="fileError"></p>
            <button type="submit" name="submit" class="btn btn-success">Add To-Do's</button>
        </form>
        <table class="table mt-5">
            <thead>
                <tr>
                    <th scope="col">Sr. No</th>
                    <th scope="col">To-Do's list</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Updated At</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($todoArray as $todo) : ?>
                    <tr>
                        <th scope="row"><?php echo $todo[0]; ?></th>
                        <td><?php echo $todo[1]; ?></td>
                        <td><?php echo $todo[4]; ?></td>
                        <td><?php echo $todo[5]; ?></td>
                        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                            <td><button type="submit" name="editButton" value="<?php echo $todo[0]; ?>" class="btn btn-info">Edit</button>
                                <button type="submit" name="deleteButton" value="<?php echo $todo[0]; ?>" class="btn btn-danger">Delete</button>
                            </td>
                        </form>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="../assets/js/formValidation.js"></script>
</body>
</head>