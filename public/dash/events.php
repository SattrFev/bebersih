<?php
session_start();
require_once 'config.php';
require_once 'auth.php';

// Check if user is logged in
checkAuth();

// Initialize variables
$error = '';
$success = '';
$edit_id = null;
$edit_data = null;

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add new event
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        $title = $_POST['title'] ?? '';
        $date = $_POST['date'] ?? '';
        $time = $_POST['time'] ?? '';
        $location = $_POST['location'] ?? '';
        $image = $_POST['image'] ?? '';
        $formurl = $_POST['formurl'] ?? '';
        
        $stmt = $conn->prepare("INSERT INTO events (title, date, time, location, image, formurl) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $title, $date, $time, $location, $image, $formurl);
        
        if ($stmt->execute()) {
            $success = "Event added successfully!";
        } else {
            $error = "Error adding event: " . $conn->error;
        }
    }
    
    // Update event
    if (isset($_POST['action']) && $_POST['action'] === 'update') {
        $id = $_POST['id'] ?? 0;
        $title = $_POST['title'] ?? '';
        $date = $_POST['date'] ?? '';
        $time = $_POST['time'] ?? '';
        $location = $_POST['location'] ?? '';
        $image = $_POST['image'] ?? '';
        $formurl = $_POST['formurl'] ?? '';
        
        $stmt = $conn->prepare("UPDATE events SET title = ?, date = ?, time = ?, location = ?, image = ?, formurl = ? WHERE id = ?");
        $stmt->bind_param("ssssssi", $title, $date, $time, $location, $image, $formurl, $id);
        
        if ($stmt->execute()) {
            $success = "Event updated successfully!";
        } else {
            $error = "Error updating event: " . $conn->error;
        }
    }
    
    // Delete event
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $id = $_POST['id'] ?? 0;
        
        $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $success = "Event deleted successfully!";
        } else {
            $error = "Error deleting event: " . $conn->error;
        }
    }
}

// Handle edit request
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $edit_data = $result->fetch_assoc();
    }
}

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 10;
$offset = ($page - 1) * $records_per_page;

// Get total records
$total_records = $conn->query("SELECT COUNT(*) as count FROM events")->fetch_assoc()['count'];
$total_pages = ceil($total_records / $records_per_page);

// Get events with pagination
$events = $conn->query("SELECT * FROM events ORDER BY date DESC LIMIT $offset, $records_per_page");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Events - DB Bebersih</title>
    <link rel="stylesheet" href="../styles.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#f8f8f8] min-h-screen">
    <div class="flex flex-col h-screen">
        <!-- Header -->
        <?php 
        include("header.php");
        ?>
        
        <!-- Main Content -->
        <main class="flex-grow container mx-auto px-4 py-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold">Manage Events</h2>
                <button id="showAddForm" class="bg-[#32af53] text-white px-4 py-2 rounded">
                    <i class="fas fa-plus mr-1"></i> Add New Event
                </button>
            </div>
            
            <?php if (!empty($error)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($success)): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>
            
            <!-- Add/Edit Form -->
            <div id="eventForm" class="bg-white rounded-lg shadow-md p-6 mb-6 <?php echo ($edit_data || isset($_GET['showForm'])) ? '' : 'hidden'; ?>">
                <h3 class="text-lg font-semibold mb-4"><?php echo $edit_data ? 'Edit Event' : 'Add New Event'; ?></h3>
                
                <form method="POST" action="">
                    <input type="hidden" name="action" value="<?php echo $edit_data ? 'update' : 'add'; ?>">
                    <?php if ($edit_data): ?>
                        <input type="hidden" name="id" value="<?php echo $edit_data['id']; ?>">
                    <?php endif; ?>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="title" class="block text-gray-700 font-medium mb-2">Title</label>
                            <input type="text" id="title" name="title" required 
                                   value="<?php echo $edit_data ? htmlspecialchars($edit_data['title']) : ''; ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label for="date" class="block text-gray-700 font-medium mb-2">Date</label>
                            <input type="date" id="date" name="date" required 
                                   value="<?php echo $edit_data ? htmlspecialchars($edit_data['date']) : ''; ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="time" class="block text-gray-700 font-medium mb-2">Time</label>
                            <input type="text" id="time" name="time" required 
                                   value="<?php echo $edit_data ? htmlspecialchars($edit_data['time']) : ''; ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label for="location" class="block text-gray-700 font-medium mb-2">Location</label>
                            <input type="text" id="location" name="location" required 
                                   value="<?php echo $edit_data ? htmlspecialchars($edit_data['location']) : ''; ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="image" class="block text-gray-700 font-medium mb-2">Image URL</label>
                        <input type="text" id="image" name="image" required 
                               value="<?php echo $edit_data ? htmlspecialchars($edit_data['image']) : ''; ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div class="mb-4">
                        <label for="formurl" class="block text-gray-700 font-medium mb-2">Form URL</label>
                        <input type="text" id="formurl" name="formurl" required 
                               value="<?php echo $edit_data ? htmlspecialchars($edit_data['formurl']) : ''; ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div class="flex justify-end space-x-2">
                        <button type="button" id="cancelForm" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                            Cancel
                        </button>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                            <?php echo $edit_data ? 'Update Event' : 'Add Event'; ?>
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Events Table -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if ($events->num_rows > 0): ?>
                            <?php while ($row = $events->fetch_assoc()): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo $row['id']; ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($row['title']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo date('M d, Y', strtotime($row['date'])); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($row['time']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($row['location']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex space-x-2">
                                            <a href="?edit=<?php echo $row['id']; ?>" class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="text-red-600 hover:text-red-900 delete-btn" 
                                                    data-id="<?php echo $row['id']; ?>" 
                                                    data-title="<?php echo htmlspecialchars($row['title']); ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">No events found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <div class="flex justify-center mt-6">
                    <nav class="inline-flex rounded-md shadow-sm">
                        <?php if ($page > 1): ?>
                            <a href="?page=<?php echo $page - 1; ?>" class="px-3 py-2 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-l-md">
                                Previous
                            </a>
                        <?php endif; ?>
                        
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <a href="?page=<?php echo $i; ?>" 
                               class="px-3 py-2 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 <?php echo $i === $page ? 'bg-blue-50 text-blue-600' : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                        
                        <?php if ($page < $total_pages): ?>
                            <a href="?page=<?php echo $page + 1; ?>" class="px-3 py-2 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-r-md">
                                Next
                            </a>
                        <?php endif; ?>
                    </nav>
                </div>
            <?php endif; ?>
        </main>
        
    
    </div>
    
    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full">
            <h3 class="text-lg font-semibold mb-4">Confirm Delete</h3>
            <p id="deleteMessage" class="mb-4">Are you sure you want to delete this event?</p>
            
            <form method="POST" action="" id="deleteForm">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" id="deleteId">
                
                <div class="flex justify-end space-x-2">
                    <button type="button" id="cancelDelete" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                        Cancel
                    </button>
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                        Delete
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        // Show/hide add form
        document.getElementById('showAddForm').addEventListener('click', function() {
            document.getElementById('eventForm').classList.remove('hidden');
        });
        
        document.getElementById('cancelForm').addEventListener('click', function() {
            document.getElementById('eventForm').classList.add('hidden');
        });
        
        // Delete confirmation modal
        const deleteButtons = document.querySelectorAll('.delete-btn');
        const deleteModal = document.getElementById('deleteModal');
        const deleteMessage = document.getElementById('deleteMessage');
        const deleteId = document.getElementById('deleteId');
        const cancelDelete = document.getElementById('cancelDelete');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const title = this.getAttribute('data-title');
                
                deleteMessage.textContent = `Are you sure you want to delete event "${title}"?`;
                deleteId.value = id;
                deleteModal.classList.remove('hidden');
            });
        });
        
        cancelDelete.addEventListener('click', function() {
            deleteModal.classList.add('hidden');
        });
    </script>
</body>
</html>