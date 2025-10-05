<?php
session_start();
include 'db_connect.php'; // Your DB connection file

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1){
        $_SESSION['user_id'] = mysqli_fetch_assoc($result)['id'];
        header("Location: index.php"); // your homepage after login
        exit;
    } else {
        $error = "Invalid email or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Login - Startup Idea Pitch Board</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
body { font-family: 'Plus Jakarta Sans', sans-serif; }
.gradient-background { background: linear-gradient(135deg, #a8e6cf, #d8a7e0, #ff8a80, #a2d2ff); }
.glassmorphism { background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); }
</style>
</head>
<body class="gradient-background flex items-center justify-center min-h-screen">
<div class="w-full max-w-md mx-auto">
<div class="glassmorphism rounded-xl shadow-lg p-8">
<div class="text-center mb-8">
<h1 class="text-3xl font-bold text-gray-800">Login</h1>
<p class="text-gray-600 mt-2">Access your account</p>
<?php if(isset($error)) echo "<p class='text-red-500 mt-2'>$error</p>"; ?>
</div>
<form method="POST" class="space-y-6">
<input type="email" name="email" placeholder="Email Address" required class="w-full px-4 py-3 rounded-full bg-white/50 border-none focus:ring-2 focus:ring-green-300 text-gray-800"/>
<input type="password" name="password" placeholder="Password" required class="w-full px-4 py-3 rounded-full bg-white/50 border-none focus:ring-2 focus:ring-green-300 text-gray-800"/>
<button type="submit" name="login" class="w-full bg-gradient-to-r from-green-400 to-green-200 text-black font-bold py-3 rounded-full shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">Login</button>
</form>
<p class="text-center text-sm text-gray-700 mt-6">Don't have an account? <a href="register.php" class="font-semibold text-gray-800 hover:underline">Sign Up</a></p>
</div>
</div>
</body>
</html>
