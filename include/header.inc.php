<!DOCTYPE html>
<html lang="en">
  <?php include 'head.inc.php'?>
  <body> 
  <?php 
    if (session_status() == PHP_SESSION_NONE) {
      session_start(); 
    }
    
  require_once 'DB_lib/Database.php'; // Include database connection
  $db = new Database();
  $stmt =$db->dbSelect('tbcategory');


  ?>
    <header class=" fixed w-full z-50">
    <div class="bg-white shadow">
      <nav
        class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8"
        aria-label="Global"
      >
        <div class="flex lg:flex-1">
          <a href="index.php" class="-m-1.5 p-1.5 border-2 border-black rounded-full">
            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-lamp"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 20h6" /><path d="M12 20v-8" /><path d="M5 12h14l-4 -8h-6z" /></svg>
          </a>
        </div>
        <div class="hidden lg:flex lg:gap-x-12">
          <div class="relative inline-block text-left">
            <div>
              <button
                type="button"
                class="flex items-center gap-x-1 text-[16px] font-semibold text-gray-900 hover:text-gray-500"
                id="menu-button"
                aria-expanded="true"
                aria-haspopup="true"
              >
                Products
                <svg
                  class="-mr-1 size-5 text-gray-900 hover:text-gray-500"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                  aria-hidden="true"
                  data-slot="icon"
                >
                  <path
                    fill-rule="evenodd"
                    d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                    clip-rule="evenodd"
                  />
                </svg>
              </button>
            </div>
            <div
              class="absolute left-0 z-10 hidden mt-2 w-56 origin-top-left rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none"
              role="menu"
              id="drop-content"
              aria-orientation="vertical"
              aria-labelledby="menu-button"
              tabindex="-1"
            >
              <div class="py-1" role="none">
                <!-- Active: "bg-gray-100 text-gray-900 outline-none", Not Active: "text-gray-700" -->
                <a
                  href="Shop.php"
                  class="block  py-2 px-5 text-sm/7 text-gray-700 hover:bg-gray-50"
                  role="menuitem"
                  tabindex="-1"
                  id="menu-item-0"
                  >All Product</a
                >
                <?php foreach($stmt as $cate) :?>
                    
                    
                        <a class="block py-2 px-5 text-sm/7 text-gray-700 hover:bg-gray-50" href="Shop.php?category= <?= $cate['id'] ?> "> <?=$cate['CategoryName']?> </a>
                    
                <?php endforeach?>

                
              </div>
            </div>
          </div>

          <a
            href="about.php"
            class="text-[16px] font-semibold text-gray-900 hover:text-gray-500"
            >About</a
          >
          <a
            href="contact-us.php"
            class="text-[16px] font-semibold text-gray-900 hover:text-gray-500"
            >Contact</a
          >
        </div>
        <div class="items-center flex lg:flex-1 lg:justify-end">
          <div class="hidden lg:flex lg:flex-1 lg:items-center lg:justify-end lg:space-x-6">
            <?php if (isset($_SESSION['username'])): ?>
              <!-- Profile Dropdown Button -->
              <div class="relative">
                <button id="profile-menu-button"  class=" cursor-pointer relative w-8 h-8 bg-sky-100 border-2 border-solid border-sky-600 flex justify-center items-center rounded-full">
                  <span class="text-sky-600 text-base font-medium"><?php echo strtoupper($_SESSION['username'][0]); ?></span>
                </button>
                <!-- Dropdown Menu -->
                <div id="profile-menu" class="hidden absolute left-1/2 -translate-x-1/2 z-10 min-w-[180px] overflow-auto rounded-lg border border-slate-200 bg-white p-1.5 mt-2 shadow-lg shadow-sm focus:outline-none">
                  <ul role="menu">
                    <li role="menuitem " class="cursor-pointer text-slate-800 flex flex-col w-full text-sm rounded-md p-3 transition-all hover:bg-slate-100 focus:bg-slate-100 active:bg-slate-100">
                      <p class="capitalize"><?= $_SESSION['username'] ?></p>
                      <p class="font-medium truncate pt-1"><?= $_SESSION['email']?></p>
                    </li>
                    
                    
                    <hr class="my-2 border-slate-200" role="menuitem" />
                    <li role="menuitem" class="cursor-pointer text-slate-800 flex w-full text-sm items-center rounded-md p-3 transition-all hover:bg-slate-100 focus:bg-slate-100 active:bg-slate-100">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-slate-400">
                        <path fill-rule="evenodd" d="M3 4.25A2.25 2.25 0 0 1 5.25 2h5.5A2.25 2.25 0 0 1 13 4.25v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 0-.75-.75h-5.5a.75.75 0 0 0-.75.75v11.5c0 .414.336.75.75.75h5.5a.75.75 0 0 0 .75-.75v-2a.75.75 0 0 1 1.5 0v2A2.25 2.25 0 0 1 10.75 18h-5.5A2.25 2.25 0 0 1 3 15.75V4.25Z" clip-rule="evenodd" />
                        <path fill-rule="evenodd" d="M19 10a.75.75 0 0 0-.75-.75H8.704l1.048-.943a.75.75 0 1 0-1.004-1.114l-2.5 2.25a.75.75 0 0 0 0 1.114l2.5 2.25a.75.75 0 1 0 1.004-1.114l-1.048-.943h9.546A.75.75 0 0 0 19 10Z" clip-rule="evenodd" />
                      </svg>
                      <a href="logout.php" class="text-slate-800 font-medium ml-2">Sign Out</a>
                    </li>
                  </ul>
                </div>
              </div>
            <?php else: ?>
              <a href="login-account.php" class="text-[16px] font-medium text-gray-700 hover:text-gray-800">Login</a>
            <?php endif; ?>
          </div>

          <!-- Search -->
          <div class="flex lg:ml-6">
            <a href="#" class="p-2 text-gray-900 hover:text-gray-500">
              <span class="sr-only">Search</span>
              <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
              </svg>
            </a>
          </div>

          <!-- Cart -->
          <div class="ml-4 flow-root lg:ml-6">
            <a href="cart.php" class="group -m-2 flex items-center p-2">
              <svg class="size-6 shrink-0 text-gray-900 group-hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
              </svg>
              <span class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-800"></span>
              <span class="sr-only">items in cart, view bag</span>
            </a>
          </div>

          <!-- Mobile Menu Button -->
          <div class="flex lg:hidden">
            <button type="button" class="p-2 text-gray-900 hover:text-gray-500">
              <svg class="size-7 mt-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
              </svg>
            </button>
          </div>
    </div>
      </div>
    </nav>
      <!-- Mobile menu, show/hide based on menu open state. -->
      <div class="hidden" role="dialog" aria-modal="true">
        <!-- Background backdrop, show/hide based on slide-over state. -->
        <div class="fixed inset-0 z-10"></div>
        <div
          class="fixed inset-y-0 right-0 z-10 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10"
        >
          <div class="flex items-center justify-between">
          <!-- <div class="flex lg:flex-1">
            <a href="index.php" class="-m-1.5 p-1.5 border-2 border-black rounded-full">
              <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-lamp"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 20h6" /><path d="M12 20v-8" /><path d="M5 12h14l-4 -8h-6z" /></svg>
            </a>
          </div> -->
            <button
              type="button"
              id="close-menu"
              class="-m-2.5 rounded-md p-2.5 text-gray-700"
            >
              <span class="sr-only">Close menu</span>
              <svg
                class="size-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                aria-hidden="true"
                data-slot="icon"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M6 18 18 6M6 6l12 12"
                />
              </svg>
            </button>
          </div>
          <div class="mt-6 flow-root">
            <div class="-my-6 divide-y divide-gray-500/10">
              <div class="space-y-2 py-6">
                <div class="-mx-3">
                  <button
                    type="button"
                    id="menu-button-mobile"
                    class="flex w-full items-center justify-between rounded-lg py-2 pl-3 pr-3.5 text-[16px] font-semibold text-gray-900 hover:text-gray-500"
                    aria-controls="disclosure-1"
                    aria-expanded="false"
                  >
                    Product
                    <!--
                  Expand/collapse icon, toggle classes based on menu open state.

                  Open: "rotate-180", Closed: ""
                -->
                    <svg
                      class="size-5 flex-none"
                      viewBox="0 0 20 20"
                      fill="currentColor"
                      aria-hidden="true"
                      data-slot="icon"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                        clip-rule="evenodd"
                      />
                    </svg>
                  </button>
                  <!-- 'Product' sub-menu, show/hide based on menu state. -->
                  <div class="mt-2 hidden space-y-2" id="drop-content-mobile">
                    <a
                      href="Shop?"
                      class="block rounded-lg py-2 px-5 text-sm/7 text-gray-900 hover:bg-gray-50"
                      role="menuitem"
                      tabindex="-1"
                      id="menu-item-0"
                      >All Product</a
                    >
                    <?php foreach($stmt as $cate): ?>
                      
                          <a class="block py-2 px-5 text-sm/7 text-gray-700 hover:bg-gray-50" href="Shop.php?category=<?=$cate['CategoryID']?>"><?=$cate['CategoryName']?></a>;
                   
                      <?php endforeach ?>
                    <a
                      href="Shop?category=Table Lamps"
                      class="block rounded-lg py-2 px-5 text-sm/7 text-gray-900 hover:bg-gray-50"
                      role="menuitem"
                      tabindex="-1"
                      id="menu-item-1"
                      >Table Lamps</a
                    >
                    <a
                      href="Shop?category=Ceiling Lamps"
                      class="block rounded-lg py-2 px-5 text-sm/7 text-gray-900 hover:bg-gray-50"
                      role="menuitem"
                      tabindex="-1"
                      id="menu-item-2"
                      >Ceiling Lamps</a
                    >
                  </div>
                </div>
                <a
                  href="about.php"
                  class="-mx-3 block rounded-lg px-3 py-2 text-[16px] font-semibold text-gray-900 hover:text-gray-500"
                  >About</a
                >
                <a
                  href="contact-us.php"
                  class="-mx-3 block rounded-lg px-3 py-2 text-[16px] font-semibold text-gray-900 hover:text-gray-500"
                  >Contact</a
                >
              </div>
              <div class="py-6">
              <?php if (isset($_SESSION['username'])): ?>
              <!-- Profile Dropdown Button -->
              <div class=" flex items-center justify-center space-x-4">
                <div class='relative cursor-pointer shrink-0 w-10 h-10 bg-sky-100 border-2 border-solid border-sky-600 flex justify-center items-center rounded-full'>
                  <span class='text-sky-600 text-base font-medium'><?php echo strtoupper($_SESSION['username'][0]); ?></span>
                </div>
                <div class="cursor-pointer text-slate-800 flex flex-col w-full text-sm rounded-md  transition-all hover:bg-slate-100 focus:bg-slate-100 active:bg-slate-100">
                  <p class="capitalize"><?= $_SESSION['username'] ?></p>
                  <p class="font-medium truncate pt-1"><?= $_SESSION['email']?></p>
                </div>
              </div>
            <?php else: ?>
              <a href="login-account.php" class="text-[16px] font-medium text-gray-700 hover:text-gray-800">Login</a>
            <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    </header>
    <script>
      const menuToggleButton = document.querySelector(".lg\\:hidden button");
      const closeButton = document.getElementById("close-menu");
      const mobileMenu = document.querySelector("[role='dialog']");

      // Show the menu
      menuToggleButton.addEventListener("click", () => {
        mobileMenu.classList.toggle("hidden");
      });

      // Hide the menu
      closeButton.addEventListener("click", () => {
        mobileMenu.classList.add("hidden");
      });

      const menuButton = document.getElementById("menu-button");
      const menuButtonMobile = document.getElementById("menu-button-mobile");
      const menuMobile = document.getElementById("drop-content-mobile");
      const menu = document.getElementById("drop-content");

      menuButton.addEventListener("click", (event) => {

        event.stopPropagation();
        menu.classList.toggle("hidden");
      });

      document.addEventListener("click", (event) => {
        // Check if the click target is outside the menu and menu button
        if (!menu.contains(event.target) && event.target !== menuButton) {
          menu.classList.add("hidden");
        }
      });
      menuButtonMobile.addEventListener("click", () => {
        console.log("click");
        menuMobile.classList.toggle("hidden");
      });
      const profileMenuButton = document.getElementById('profile-menu-button');
      const profileMenu = document.getElementById('profile-menu');

      // profileMenuButton.forEach((btn) => {
      //   btn.classList.toggle('hidden');
      // })
      profileMenuButton.addEventListener('click', () => {
        profileMenu.classList.toggle('hidden');
      });

      
      document.addEventListener('click', (event) => {
        if (!profileMenuButton.contains(event.target) && !profileMenu.contains(event.target)) {
          profileMenu.classList.add('hidden');
        }
      });
    </script>
  </body>
</html>
