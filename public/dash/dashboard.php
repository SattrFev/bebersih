<?php
session_start();
require_once 'config.php';
require_once 'auth.php';

checkAuth();

$donors_count = $conn->query("SELECT COUNT(*) as count FROM donors")->fetch_assoc()['count'];
$events_count = $conn->query("SELECT COUNT(*) as count FROM events")->fetch_assoc()['count'];
$events_status_count = $conn->query("SELECT COUNT(*) as count FROM events_status")->fetch_assoc()['count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - DB Bebersih</title>
    <link rel="stylesheet" href="../styles.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#f8f8f8] min-h-screen">
    <div class="flex flex-col h-screen">

        <header class="bg-[#113259] text-white shadow-lg">
            <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="dashboard.php" class="text-2xl font-bold uppercase"><span class="font-medium">Dashboard</span> Bebersih</a>
                <div class="flex items-center space-x-4">
                    <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    <a href="logout.php" class="bg-sunset px-3 py-1 rounded">Logout</a>
                </div>
            </div>
        </header>
        
        <!-- Main Content -->
        <main class="flex-grow container mx-auto px-4 py-8">
            <h2 class="text-xl font-semibold mb-6">Database Tables</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Donors Card -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold">Donors</h3>
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm"><?php echo $donors_count; ?> records</span>
                        </div>
                        <p class="text-gray-600 mt-2">Manage donor information and contributions</p>
                    </div>
                    <div class="bg-gray-50 px-6 py-3">
                        <a href="donors.php" class="text-blue-600 hover:text-blue-800 font-medium">
                            Manage Donors <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Events Card -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold">Events</h3>
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm"><?php echo $events_count; ?> records</span>
                        </div>
                        <p class="text-gray-600 mt-2">Manage upcoming and past events</p>
                    </div>
                    <div class="bg-gray-50 px-6 py-3">
                        <a href="events.php" class="text-blue-600 hover:text-blue-800 font-medium">
                            Manage Events <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Events Status Card -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold">Events Status</h3>
                            <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-sm"><?php echo $events_status_count; ?> records</span>
                        </div>
                        <p class="text-gray-600 mt-2">Track event status and progress</p>
                    </div>
                    <div class="bg-gray-50 px-6 py-3">
                        <a href="events_status.php" class="text-blue-600 hover:text-blue-800 font-medium">
                            Manage Status <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </main>
        
        
    </div>
</body>
</html>