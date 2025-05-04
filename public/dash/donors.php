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
    // Add new donor
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $amount = $_POST['amount'] ?? 0;
        $message = $_POST['message'] ?? '';
        $date = date('Y-m-d H:i:s');
        
        $stmt = $conn->prepare("INSERT INTO donors (name, email, amount, message, date) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiss", $name, $email, $amount, $message, $date);
        
        if ($stmt->execute()) {
            $success = "Donor added successfully!";
        } else {
            $error = "Error adding donor: " . $conn->error;
        }
    }
    
    // Update donor
    if (isset($_POST['action']) && $_POST['action'] === 'update') {
        $id = $_POST['id'] ?? 0;
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $amount = $_POST['amount'] ?? 0;
        $message = $_POST['message'] ?? '';
        
        $stmt = $conn->prepare("UPDATE donors SET name = ?, email = ?, amount = ?, message = ? WHERE id = ?");
        $stmt->bind_param("ssisi", $name, $email, $amount, $message, $id);
        
        if ($stmt->execute()) {
            $success = "Donor updated successfully!";
        } else {
            $error = "Error updating donor: " . $conn->error;
        }
    }
    
    // Delete donor
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $id = $_POST['id'] ?? 0;
        
        $stmt = $conn->prepare("DELETE FROM donors WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $success = "Donor deleted successfully!";
        } else {
            $error = "Error deleting donor: " . $conn->error;
        }
    }
}

// Handle edit request
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM donors WHERE id = ?");
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
$total_records = $conn->query("SELECT COUNT(*) as count FROM donors")->fetch_assoc()['count'];
$total_pages = ceil($total_records / $records_per_page);

// Get donors with pagination
$donors = $conn->query("SELECT * FROM donors ORDER BY date DESC LIMIT $offset, $records_per_page");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Donors - DB Bebersih</title>
    <link rel="stylesheet" href="../styles.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#f8f8f8] min-h-screen">
    <div class="flex flex-col h-screen">
        <?php 
        include("header.php");
        ?>
        
        <!-- Main Content -->
        <main class="flex-grow container mx-auto px-4 py-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold">Manage Donors</h2>
                <button id="showAddForm" class="bg-[#32af53]  text-white px-4 py-2 rounded">
                    <i class="fas fa-plus mr-1"></i> Add New Donor
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
            <div id="donorForm" class="bg-white rounded-lg shadow-md p-6 mb-6 <?php echo ($edit_data || isset($_GET['showForm'])) ? '' : 'hidden'; ?>">
                <h3 class="text-lg font-semibold mb-4"><?php echo $edit_data ? 'Edit Donor' : 'Add New Donor'; ?></h3>
                
                <form method="POST" action="">
                    <input type="hidden" name="action" value="<?php echo $edit_data ? 'update' : 'add'; ?>">
                    <?php if ($edit_data): ?>
                        <input type="hidden" name="id" value="<?php echo $edit_data['id']; ?>">
                    <?php endif; ?>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
                            <input type="text" id="name" name="name" required 
                                   value="<?php echo $edit_data ? htmlspecialchars($edit_data['name']) : ''; ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                            <input type="email" id="email" name="email" required 
                                   value="<?php echo $edit_data ? htmlspecialchars($edit_data['email']) : ''; ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="amount" class="block text-gray-700 font-medium mb-2">Amount</label>
                        <input type="number" id="amount" name="amount" required 
                               value="<?php echo $edit_data ? htmlspecialchars($edit_data['amount']) : ''; ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div class="mb-4">
                        <label for="message" class="block text-gray-700 font-medium mb-2">Message</label>
                        <textarea id="message" name="message" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"><?php echo $edit_data ? htmlspecialchars($edit_data['message']) : ''; ?></textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-2">
                        <button type="button" id="cancelForm" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                            Cancel
                        </button>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                            <?php echo $edit_data ? 'Update Donor' : 'Add Donor'; ?>
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Donors Table -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if ($donors->num_rows > 0): ?>
                            <?php while ($row = $donors->fetch_assoc()): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo $row['id']; ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($row['amount']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo date('M d, Y', strtotime($row['date'])); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex space-x-2">
                                            <a href="?edit=<?php echo $row['id']; ?>" class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="text-red-600 hover:text-red-900 delete-btn" 
                                                    data-id="<?php echo $row['id']; ?>" 
                                                    data-name="<?php echo htmlspecialchars($row['name']); ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">No donors found</td>
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
            <p id="deleteMessage" class="mb-4">Are you sure you want to delete this donor?</p>
            
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
            document.getElementById('donorForm').classList.remove('hidden');
        });
        
        document.getElementById('cancelForm').addEventListener('click', function() {
            document.getElementById('donorForm').classList.add('hidden');
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
                const name = this.getAttribute('data-name');
                
                deleteMessage.textContent = `Are you sure you want to delete donor "${name}"?`;
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