<?php
require_once 'include/dbh.inc.php';

    try{
        $sql = "SELECT id, user_id, email, created_date FROM tbusers ORDER BY id DESC";
        $result = $pdo->query($sql);
        $users = $result->fetchAll(PDO::FETCH_ASSOC);          
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
?>

<?php $title = "Customers" ?>
<!DOCTYPE html>
<html lang="en">
<?php include 'include/head.inc.php' ?>
<body class=" bg-slate-50">
    
    <?php include 'include/adside.inc.php' ?>
    <?php include 'include/header.inc.php' ?>
    <main class="ml-70 p-6 pt-21">
      <div class=" size-full py-5">
            
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
        <thead class="text-xs text-gray-700 uppercase bg-gray-200 ">
            <tr>
                <th scope="col" class="p-4">
                    <div class="flex items-center">
                        <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2 ">
                        <label for="checkbox-all-search" class="sr-only">checkbox</label>
                    </div>
                </th>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Emails
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
                <th scope="col" class="px-6 py-3">
                    Create Date
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($users as $user): ?>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="w-4 p-4">
                    <div class="flex items-center">
                        <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                    </div>
                </td>
                <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                    <img class="w-10 h-10 rounded-full" src="../image/me.jpg" alt="Jese image">
                    <div class="ps-3">
                        <div class="text-base font-semibold"><?php echo $user['username'] ?></div>
                    </div>  
                </th>
                <td class="px-6 py-4">
                    <?php echo $user['email'] ?>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div> Online
                    </div>
                </td>
                <td class="px-6 py-4">
                    <?php echo $user['created_date'] ?>
                </td>
                <td class="px-6 py-4">
                    <!-- Modal toggle -->
                    <a href="#" type="button" data-modal-target="editUserModal" data-modal-show="editUserModal" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit user</a>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    
</div>

      </div>
    </main>

    <script>
        function open(){
            document.getElementById("editUserModal").classList.remove("hidden");
        }
    </script>
</body>
</html>