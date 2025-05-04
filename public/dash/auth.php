<?php
function processLogin($username, $password) {
    global $conn;
    
    if (empty($username) || empty($password)) {
        return "Username and password are required";
    }
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        return "Invalid username or password";
    }
    
    $user = $result->fetch_assoc();
    
    if (isset($user['locked_until']) && $user['locked_until'] !== null) {
        $locked_until = new DateTime($user['locked_until']);
        $now = new DateTime();
        
        if ($now < $locked_until) {
            $time_diff = $now->diff($locked_until);
            $minutes = $time_diff->i + ($time_diff->h * 60);
            return "Account is locked. Try again in {$minutes} minutes.";
        } else {
            // Reset lock if time has passed
            $stmt = $conn->prepare("UPDATE users SET failed_attempts = 0, locked_until = NULL WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
        }
    }
    
    if (password_verify($password, $user['password'])) {
        
        $stmt = $conn->prepare("UPDATE users SET failed_attempts = 0, locked_until = NULL, last_login = NOW() WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return true;
    } else {
        
        $failed_attempts = $user['failed_attempts'] + 1;
        
        if ($failed_attempts >= 4) {
            $lock_time = new DateTime();
            $lock_time->add(new DateInterval('PT5M'));
            $lock_time_str = $lock_time->format('Y-m-d H:i:s');
            
            $stmt = $conn->prepare("UPDATE users SET failed_attempts = ?, locked_until = ? WHERE username = ?");
            $stmt->bind_param("iss", $failed_attempts, $lock_time_str, $username);
            $stmt->execute();
            
            return "Too many failed attempts. Account locked for 5 minutes.";
        } else {
            $stmt = $conn->prepare("UPDATE users SET failed_attempts = ? WHERE username = ?");
            $stmt->bind_param("is", $failed_attempts, $username);
            $stmt->execute();
            
            $attempts_left = 4 - $failed_attempts;
            return "Invalid username or password. {$attempts_left} attempts remaining.";
        }
    }
}

function checkAuth() {
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header('Location: index.php');
        exit;
    }
}
?>