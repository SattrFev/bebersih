<?php
session_start();
require_once 'config.php';
require_once 'auth.php';

// Check if already logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $result = processLogin($username, $password);
    
    if ($result === true) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = $result;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DB Bebersih Dashboard</title>
    <link rel="stylesheet" href="../styles.css" />
    
</head>
<body class="bg-[#f8f8f8] min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-[20rem]">
        <h1 class="text-2xl font-bold text-center mb-6 uppercase">Dashboard Bebersih</h1>
        
        <?php if (!empty($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="mb-4">
                <input type="text" id="username" placeholder="username" name="username" required 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div class="mb-6">
                <input type="password" id="password" placeholder="password" name="password" required 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <button type="submit" class="w-full bg-sunset text-white p-3 rounded-full focus:outline-none focus:ring-1 focus:ring-transparent focus:ring-offset-2">
                Login
            </button>
        </form>
    </div>
    

    
</body>
</html>