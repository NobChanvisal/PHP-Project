<?php
require_once 'include/dbh.inc.php';

    try{
        $sql = "SELECT id, username, email, created_date FROM tbusers ORDER BY id DESC";
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
            
          <div class="grid gap-4 md:grid-cols-2 pb-5">
                      <div class=" w-1/2 self-end">
                          <div class="relative">
                              <div
                                class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                <svg
                                  class="w-4 h-4 text-gray-500"
                                  aria-hidden="true"
                                  xmlns="http://www.w3.org/2000/svg"
                                  fill="none"
                                  viewBox="0 0 20 20"
                                >
                                  <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                                  />
                                </svg>
                              </div>
                              <input
                                type="text"
                                name="email"
                                id="topbar-search"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-9 p-2.5"
                                placeholder="Search"
                              />
                            </div>
                      </div>
                      <div class="flex space-x-7 justify-self-end">
                        <div class=" w-fit px-6 py-2 min-w-44">
                        <div class="flex justify-end">
                            <button type="button" class="flex cursor-pointer items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600" onclick="openModal()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
                            </svg>
                            <span class="ml-2">Add Customers</span>
                            </button>
                        </div>

                        </div>
                          
                      </div>
          </div> 
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