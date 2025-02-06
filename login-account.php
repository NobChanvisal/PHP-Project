<?php
session_start();
include 'include/dbh.inc.php'; // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $passwords = trim($_POST['password']);
    
    try {
        // Make sure to select `email`
        $stmt = $pdo->prepare("SELECT id, username, email, password FROM tbusers WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($passwords, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email']; // Now this should work

            header("Location: index.php"); // Redirect to homepage after login
            exit();
        } else {
            $error = "Invalid email or password!";
        }
    } catch (PDOException $e) {
        $error = "Query failed: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<?php include 'include/head.inc.php' ?>
<body class=" bg-gray-50">

    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <!-- <form method="post" action="">
        <label>Email:</label>
        <input type="email" name="email" required>
        <br>
        <label>Password:</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register</a></p> -->
    <!--

-->
<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <div class="flex lg:flex-1 justify-center">
          <a href="index.php" class="-m-1.5 p-1.5 border-2 border-black rounded-full">
            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-lamp"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 20h6" /><path d="M12 20v-8" /><path d="M5 12h14l-4 -8h-6z" /></svg>
          </a>
        </div>
    </div>

    <div class="mt-10 rounded-lg shadow sm:mx-auto sm:w-full sm:max-w-sm px-6 py-8">
    <h2 class="mb-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Sign in to your account</h2>
        <form class="space-y-6" action="#" method="POST">
        <div>
            <label for="email" class="block text-sm/6 font-medium text-gray-900">Email address</label>
            <div class="mt-2">
            <input type="email" name="email" id="email" autocomplete="email" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
            </div>
        </div>

        <div>
            <div class="flex items-center justify-between">
            <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
            <div class="text-sm">
                <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?</a>
            </div>
            </div>
            <div class="mt-2">
            <input type="password" name="password" id="password" autocomplete="current-password" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
            </div>
        </div>

        <div>
            <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign in</button>
        </div>
        </form>
        <p class="mt-10 text-center text-sm/6 text-gray-500">Don't have an account? <a class="font-semibold text-indigo-600 hover:text-indigo-500" href="register-account.php">Register</a></p>
    </div>
</div>

</body>
</html>
