<?php 
    // Menghubungkan ke database
    require_once('config.php');
    session_start();
    
    // Pastikan pengguna tidak dapat mengakses halaman ini sebelum login
    if (!isset($_SESSION['id_user'])) {
        header("Location: index_no_login.php");
        exit();
    }
    
    // Mengambil ID user dari sesi
    $id_user = $_SESSION['id_user'];
    $username = $_SESSION['username'];

    // Modifikasi query SQL untuk memfilter tugas berdasarkan ID pengguna
    $sql = "SELECT * FROM tbltodo WHERE id_user = ? ORDER BY id DESC";
    $stmt = mysqli_prepare($conn, $sql);
    
    function getStatusClass($status) {
        switch ($status) {
            case "Not Yet":
                return 'bg-red-500'; 
            case "In Progress":
                return 'bg-yellow-500';
            case "Waiting On":
                return 'bg-gray-400'; 
            default:
                return ''; 
        }
    }

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id_user);
        mysqli_stmt_execute($stmt);
        $rawData = mysqli_stmt_get_result($stmt);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-store" />
    <meta http-equiv="Pragma" content="no-store" />
    <title>To Do List App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/eb2cfeef2f.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head> 

<body class="bg-gradient-to-b from-gray-900 to-gray-600 bg-gradient-to-r">
    <!-- Navbar -->
    <div class="bg-gradient-to-b from-gray-900 to-gray-600 bg-gradient-to-r">
        <nav class="fixed top-0 left-0 w-full h-20 flex items-center justify-between bg-transparent backdrop-blur-sm p-4">
            <a class="flex items-center text-white" href="index.php">
                <span class="font-semibold text-xl">TASK TRACKER</span>
                <img src="images/tracking.png" alt="Logo" class="h-6 w-6 ml-1" />
            </a>
            <div class="flex items-center space-x-8">
                <a class="text-white hover:text-red-600" href="logout.php">Logout</a>
            </div>
        </nav>
    </div>

    <!-- Form -->
    <form action="insert.php" method="POST"  onsubmit="return validateForm()">
        <div class="container mx-auto mt-[100px] bg-white max-w-4xl p-4">
            <div class="row">
                <h2 class="text-center text-xl font-bold">Selamat Datang, <?php echo $username; ?>!</h2>
                <p class="text-center"><i>mau mengerjakan tugas apa hari ini?</i></p>
                <div class="mt-5 ml-[150px]">
                    <label for="list" class="block ml-5 mb-2 text-sm font-bold text-gray-900 dark:text-white">Tambahkan Tugas</label>
                    <input type="text" name="list" id="list" onkeyup="validateList()" class="ml-5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-[525px] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="cth: Memasak nasi.." required>
                    <span id="list-error" class="ml-5 text-red-700"></span>
                    
                    <label for="description" class="block ml-5 mb-2  mt-2 text-sm font-bold text-gray-900 dark:text-white">Deskripsi Tugas</label>
                    <input type="text" name="description" id="description" onkeyup="validateDesc()" class="ml-5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-[525px] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Deskripsi tugas.." required>
                    <span id="desc-error" class="ml-5 text-red-700"></span>
                    <select name="status" class="py-3 px-4 ml-5 block mt-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                    <option selected disabled class="font-bold">Status Tugas</option>
                        <option>Not Yet</option>
                        <option>In Progress</option>
                        <option>Waiting On</option> 
                    </select>
                    <button type="submit" name="submit" class="ml-5 block mt-5 mb-[50px] bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                        Add
                    </button>
                </div>
            </div>
        </div>
    </form>

    <!-- Table for tasks -->
    <div class=" mx-auto bg-white max-w-4xl p-4">
        <table class="w-full table-fixed">
            <tbody>
                <?php if (mysqli_num_rows($rawData) === 0) { ?>
                    <tr>
                        <td colspan="2" class="p-3 mb-1 text-center">
                            <h1 class="font-bold">Belum ada tugas sama sekali. Ayo jangan malas!</h1>
                            <img src="images/loading.gif" alt="No tasks yet" class="w-[500px] h-[300px] mx-auto">
                        </td>
                    </tr>
                <?php } else { ?>
                <?php while ($row = mysqli_fetch_array($rawData)) { 
                        $status = $row['status'];
                        $statusClass = getStatusClass($status);
                        ?>
                    <tr>
                        <td class="p-3 border-b border-gray-400 <?php if ($row['checked'] == 1) { echo 'completed'; } ?>">
                            <span class="task-text font-bold text-lg"><?php echo htmlspecialchars($row['list'], ENT_QUOTES, 'UTF-8');?></span>
                            <br>
                            <span class="task-text text-gray-800 text-sm"><?php echo htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8');?></span>
                            <br>
                            <div class=" flex text-sm mt-4">
                                <p class="text-gray-500">Ditambahkan pada: <?php echo $row['date_time']; ?> </p>
                                <p class="<?php echo $statusClass; ?> px-2 text-center rounded-[20px] ml-3"><?php echo htmlspecialchars($status, ENT_QUOTES, 'UTF-8');?></p>
                            </div>
                        </td>
                        <td class="p-3 border-b border-gray-400">
                            <a class="ml-2 float-right bg-transparent hover:bg-green-700 text-blue-dark font-semibold hover:text-white py-2 px-4 border border-blue-800 hover:border-transparent rounded" href="edit.php?id=<?php echo $row['id']?>">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a class="float-right bg-transparent hover:bg-red-700 text-blue-dark font-semibold hover:text-white py-2 px-4 border border-blue-800 hover.border.transparent rounded"
                            href="javascript:void(0);"
                            data-id="<?php echo $row['id']; ?>"
                            onclick="openDeleteTaskModal(this)">
                                <i class="fa-solid fa-delete-left"></i>
                            </a>

                            <div class="custom-checkbox float-right mr-1 p-[7px] w-md">
                                <input type="checkbox" class="h-8 w-8 rounded-full shadow" id="task_<?php  htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?>" name="task_completed[]" data-id="<?php htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?>" data-initial-checked="<?php echo $row['checked']; ?>"
                                <?php if ($row['checked'] == 1) { echo 'checked="checked"'; } ?>>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
    
    <!-- Task Deletion Modal -->
    <div id="deleteTaskModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-top sm:w-full sm:max-w-lg sm:p-6">
                <div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Delete Task
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Kamu yakin mau menghapus task ini?
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-6">
                    <button onclick="deleteTask()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:text-sm">
                        Hapus
                    </button>
                    <button onclick="closeDeleteTaskModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:text-sm">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function () {
            // Untuk checkbox
            $('input[type="checkbox"]').on('change', function () {
                const taskId = $(this).data('id');
                const initialChecked = $(this).data('initial-checked');
                
                // Toggle completed checkboxnya
                $(this).closest('td').toggleClass('completed', this.checked);
                
                // Send an AJAX request to update the 'checked' status in the database
                $.ajax({
                    url: 'update_status.php', 
                    method: 'POST',
                    data: {
                        taskId: taskId,
                        initialChecked: initialChecked,
                        checked: this.checked ? 1 : 0
                    },
                    success: function (response) {
                    },
                    error: function (error) {
                        // Error handling
                        console.error(error);
                    }
                });
            });
        });
            
            const statusSelects = document.querySelectorAll(".status");
            const selectedOptions = document.querySelectorAll(".selected-option");
            const customDropdowns = document.querySelectorAll(".custom-dropdown");

            statusSelects.forEach((statusSelect, index) => {
                statusSelect.addEventListener("change", function() {
                    const className = statusSelect.options[statusSelect.selectedIndex].className;
                    selectedOptions[index].className = "selected-option " + className;
                    customDropdowns[index].className = "custom-dropdown " + className;
                });
            });

            // Ambil semua elemen checkbox
            const checkboxes = document.querySelectorAll("input[type='checkbox']");
            checkboxes.forEach(checkbox => {
                // Tambahkan event listener untuk setiap checkbox
                checkbox.addEventListener('change', function() {
                    // Ambil elemen teks terkait
                    const taskText = this.parentElement.parentElement.previousElementSibling.querySelector('.task-text');
                    // Periksa apakah checkbox dicentang
                    if (this.checked) {
                        // Jika dicentang, tambahkan class 'completed' ke teks
                        taskText.classList.add('completed');
                    } else {
                        // Jika dicopot centang, hapus class 'completed' dari teks
                        taskText.classList.remove('completed');
                    }
                });
            });

        let taskToDeleteId;

        function openDeleteTaskModal(deleteLink) {
            taskToDeleteId = deleteLink.getAttribute('data-id');
            document.getElementById('deleteTaskModal').classList.remove('hidden');
        }

        function closeDeleteTaskModal() {
            document.getElementById('deleteTaskModal').classList.add('hidden');
        }

        function deleteTask() {
            if (taskToDeleteId) {
                // Redirect to the delete.php script with the task ID
                window.location.href = `delete.php?id=${taskToDeleteId}`;
            }
        }

        // Validasi input list dan description
        var listError = document.getElementById('list-error');
        var descError = document.getElementById('desc-error');

        function validateList() {
            var list = document.getElementById('list').value;

            // Pastikan input field tidak lebih dari 65 karakter
            if (list.length > 65) {
                listError.innerHTML = 'Karakternya terlalu banyak! Kurang efektif.';
                return false;
            }
            listError.innerHTML = '';
            return true;
        }

        function validateDesc() {
            var desc = document.getElementById('description').value;

            // Pastikan input field tidak lebih dari 65 karakter
            if (desc.length > 65) {
                descError.innerHTML = 'Karakternya terlalu banyak! Kurang efektif.';
                return false;
            }
            descError.innerHTML = '';
            return true;
        }

        function validateForm() {
            var list = document.getElementById('list').value;
            var desc = document.getElementById('description').value;

            // Validasi list dan desc
            if (list.length > 65) {
                listError.innerHTML = 'Karakternya terlalu banyak! Kurang efektif.';
                return false;
            }

            if (desc.length > 65) {
                descError.innerHTML = 'Karakternya terlalu banyak! Kurang efektif.';
                return false;
            }

            listError.innerHTML = '';
            descError.innerHTML = '';
            return true;
        }
    </script>


</body>
</html>

<?php 
        mysqli_stmt_close($stmt);
    
    } else {
        // Handle errornya
        echo "Ada eror saat menyiapkan select statementnya";
    }
?>