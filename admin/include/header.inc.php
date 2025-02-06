<header class=" ">
      <nav class="z-30 fixed w-full top-0 bg-white shadow px-3 lg:px-6 py-4">
        <div class="pl-70 pr-10 w-full flex flex-wrap justify-between items-center">
          <div class="flex justify-start items-center">
            <a href="https://flowbite.com" class="flex mr-4">
              <span class="self-center text-2xl font-semibold whitespace-nowrap"
                ><?= $title ?> </span
              >
            </a>
            
          </div>
          <div class="flex items-center justify-center lg:order-2">
            <button
              type="button"
              class="hidden sm:inline-flex items-center justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-xs px-3 py-1.5 mr-2"
            >
              <svg
                aria-hidden="true"
                class="mr-1 -ml-1 w-5 h-5"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                  clip-rule="evenodd"
                ></path>
              </svg>
              New Widget
            </button>
            <button
              id="toggleSidebarMobileSearch"
              type="button"
              class="p-2 text-gray-500 rounded-lg lg:hidden hover:text-gray-900 hover:bg-gray-100"
            >
              <span class="sr-only">Search</span>
              <!-- Search icon -->
              <svg
                class="w-4 h-4"
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
            </button>
            <!-- Notifications -->
            <button
              type="button"
              data-dropdown-toggle="notification-dropdown"
              class="cursor-pointer p-2 mr-1 rounded-lg text-gray-700 hover:bg-gray-200"
            >
              <span class="sr-only">View notifications</span>
              <!-- Bell icon -->
              <svg
                class="w-5 h-5"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="currentColor"
                viewBox="0 0 14 20"
              >
                <path
                  d="M12.133 10.632v-1.8A5.406 5.406 0 0 0 7.979 3.57.946.946 0 0 0 8 3.464V1.1a1 1 0 0 0-2 0v2.364a.946.946 0 0 0 .021.106 5.406 5.406 0 0 0-4.154 5.262v1.8C1.867 13.018 0 13.614 0 14.807 0 15.4 0 16 .538 16h12.924C14 16 14 15.4 14 14.807c0-1.193-1.867-1.789-1.867-4.175ZM3.823 17a3.453 3.453 0 0 0 6.354 0H3.823Z"
                />
              </svg>
            </button>
            <!-- Dropdown menu -->
            <div
              class="hidden overflow-hidden z-50 my-4 max-w-sm text-base list-none bg-white rounded divide-y divide-gray-100 shadow-lg"
              id="notification-dropdown"
            >
              <div
                class="block py-2 px-4 text-base font-medium text-center text-gray-700 bg-gray-50"
              >
                Notifications
              </div>
            </div>
            <div class=" relative">
              <button
                type="button"
                class="cursor-pointer mx-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300"
                id="user-menu-button"
                aria-expanded="false"
              >
                <span class="sr-only">Open user menu</span>
                <img
                  class="w-8 h-8 rounded-full"
                  src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
                  alt="user photo"
                />
              </button>
              <!-- Dropdown menu -->
              <div
                class="hidden absolute right-0 origin-top-right z-50 my-4 w-56 text-base list-none bg-white rounded divide-y divide-gray-100 shadow"
                id="dropdown"
              >
                <div class="py-3 px-4">
                  <span class="block text-sm font-semibold text-gray-900"
                    >Neil sims</span
                  >
                  <span class="block text-sm text-gray-500 truncate"
                    >name@flowbite.com</span
                  >
                </div>
                <ul class="py-1 text-gray-500" aria-labelledby="dropdown">
                  <li>
                    <a
                      href="#"
                      class="block py-2 px-4 text-sm hover:bg-gray-100"
                      >My profile</a
                    >
                  </li>
                  <li>
                    <a
                      href="#"
                      class="block py-2 px-4 text-sm hover:bg-gray-100"
                      >Account settings</a
                    >
                  </li>
                </ul>
                <ul class="py-1 text-gray-500" aria-labelledby="dropdown">
                  <li>
                    <a
                      href="#"
                      class="block py-2 px-4 text-sm hover:bg-gray-100"
                      >Sign out</a
                    >
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </nav>
    </header>
    <script>
      document
        .getElementById("user-menu-button")
        .addEventListener("click", () => {
          console.log("click");
          document.getElementById("dropdown").classList.toggle("hidden");
        });
    </script>