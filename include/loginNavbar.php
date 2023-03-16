<nav class="navbar navbar-expand-lg bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand text-light" href="/project-to-do-list">
            <h2 class="px-4"> <img id="logo" src="https://img.icons8.com/external-flaticons-lineal-color-flat-icons/64/null/external-to-do-list-lifestyles-flaticons-lineal-color-flat-icons.png" /> To-Do-List</h2>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active text-light px-4" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light px-4" href="#">About</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <p class="text-light mt-3">welcome <?php session_start(); echo $_SESSION['email']; ?></p>
                <a href="../user/logout.php" class="btn btn-danger m-3" tabindex="-1" role="button" aria-disabled="true">Logout</a>

            </ul>
        </div>
    </div>
</nav>