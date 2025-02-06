<?php $title = "Dashboard" ?>
<!DOCTYPE html>
<html lang="en">
<?php include 'include/head.inc.php' ?>
<body class=" bg-slate-50">
<?php include 'include/adside.inc.php' ?>
<?php include 'include/header.inc.php' ?>
<main>
  <div class="container">
    <div class=" ml-70">
      <div class="p-6 pt-21">
        <div class="">
            <div class="grid gap-4 md:grid-cols-3 pb-5">
                <div class="relative p-6 rounded-2xl bg-white shadow">
                    <div class="space-y-2">
                        <div class="flex items-center space-x-2 rtl:space-x-reverse text-sm font-medium text-gray-500">
                            <span>Revenue</span>
                        </div>

                        <div class="text-3xl">
                            $192.1k
                        </div>

                        <div class="flex items-center space-x-1 rtl:space-x-reverse text-sm font-medium text-green-600">
                            <span>32k increase</span>
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="relative p-6 rounded-2xl bg-white shadow">
                    <div class="space-y-2">
                        <div class="flex items-center space-x-2 rtl:space-x-reverse text-sm font-medium text-gray-500">
                            <span>New customers</span>
                        </div>

                        <div class="text-3xl">
                            1340
                        </div>

                        <div class="flex items-center space-x-1 rtl:space-x-reverse text-sm font-medium text-red-600">
                            <span>3% decrease</span>
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12 13a1 1 0 100 2h5a1 1 0 001-1V9a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586 3.707 5.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414 14.586 13H12z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="relative p-6 rounded-2xl bg-white shadow">
                    <div class="space-y-2">
                        <div class="flex items-center space-x-2 rtl:space-x-reverse text-sm font-medium text-gray-500">
                            <span>New orders</span>
                        </div>

                        <div class="text-3xl">
                            3543
                        </div>

                        <div class="flex items-center space-x-1 rtl:space-x-reverse text-sm font-medium text-green-600">
                            <span>7% increase</span>
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-wrap">
          <div class="w-full lg:w-8/12 flex">
            <div class="w-full bg-white shadow rounded-lg mr-4">
              <div class="p-4">
                <div
                  class="flex flex-col sm:flex-row items-center justify-between mb-6"
                >
                  <div class="mb-3 sm:mb-0">
                    <h5 class="text-lg font-semibold">Sales Overview</h5>
                  </div>
                  <div>
                    <select class="form-select">
                      <option value="1">March 2023</option>
                      <option value="2">April 2023</option>
                      <option value="3">May 2023</option>
                      <option value="4">June 2023</option>
                    </select>
                  </div>
                </div>
                <div id="chart"></div>
              </div>
            </div>
          </div>
        <div class="w-full lg:w-4/12">
          <div class="flex flex-col">
            <div class="w-full">
              <!-- Yearly Breakup -->
              <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="p-4">
                  <h5 class="text-lg font-semibold mb-6">Yearly Breakup</h5>
                  <div class="flex items-center">
                    <div class="w-8/12">
                      <h4 class="font-semibold mb-3">$36,358</h4>
                      <div class="flex items-center mb-3">
                        <span
                          class="me-1 rounded-full bg-green-100 w-5 h-5 flex items-center justify-center"
                        >
                        <svg xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-up-left text-green-500"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7l10 10" /><path d="M16 7l-9 0l0 9" /></svg>
                        </span>
                        <p class="text-gray-700 me-1 text-lg">+9%</p>
                        <p class="text-lg">last year</p>
                      </div>
                      <div class="flex items-center">
                        <div class="me-4">
                          <span
                            class="w-2 h-2 bg-blue-500 rounded-full me-2 inline-block"
                          ></span>
                          <span class="text-lg">2023</span>
                        </div>
                        <div>
                          <span
                            class="w-2 h-2 bg-blue-100 rounded-full me-2 inline-block"
                          ></span>
                          <span class="text-lg">2023</span>
                        </div>
                      </div>
                    </div>
                    <div class="w-4/12">
                      <div class="flex justify-center">
                        <div id="breakup"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="w-full mt-4">
              <!-- Monthly Earnings -->
              <div class="bg-white shadow rounded-lg">
                <div class="p-4">
                  <div class="flex items-start">
                    <div class="w-8/12">
                      <h5 class="text-lg font-semibold mb-6">Monthly Earnings</h5>
                      <h4 class="font-semibold mb-3">$6,820</h4>
                      <div class="flex items-center pb-1">
                        <span
                          class="me-2 rounded-full bg-red-100 w-5 h-5 flex items-center justify-center"
                        >
                          <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-down-right text-red-300"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7l10 10" /><path d="M17 8l0 9l-9 0" /></svg>
                        </span>
                        <p class="text-gray-700 me-1 text-lg">+9%</p>
                        <p class="text-lg">last year</p>
                      </div>
                    </div>
                    <div class="w-4/12">
                      <div class="flex justify-end">
                        <div
                          class="bg-blue-400 text-white rounded-full w-12 h-12 flex items-center justify-center"
                        >
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-currency-dollar"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2" /><path d="M12 3v3m0 12v3" /></svg>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="earning"></div>
              </div>
            </div>
          </div>
        </div>
    </div>
    <div class="flex flex-wrap mt-6">
      <div class="w-full lg:w-4/12 flex">
        <div class="w-full bg-white shadow rounded-lg">
          <div class="p-4">
            <div class="mb-4">
              <h5 class="text-lg font-semibold">Recent Transactions</h5>
            </div>
            <ul class="space-y-4">
              <li class="flex items-center relative">
                <div class="text-gray-700 flex-shrink-0 text-end">09:30</div>
                <div class="flex flex-col items-center mx-4">
                  <span
                    class="w-2 h-2 border-2 border-blue-500 rounded-full my-2"
                  ></span>
                  <span class="w-px h-4 bg-gray-200"></span>
                </div>
                <div class="text-gray-700">
                  Payment received from John Doe of $385.90
                </div>
              </li>
              <li class="flex items-center relative">
                <div class="text-gray-700 flex-shrink-0 text-end">10:00 am</div>
                <div class="flex flex-col items-center mx-4">
                  <span
                    class="w-2 h-2 border-2 border-blue-400 rounded-full my-2"
                  ></span>
                  <span class="w-px h-4 bg-gray-200"></span>
                </div>
                <div class="text-gray-700 font-semibold">
                  New sale recorded
                  <a href="#" class="text-blue-500 block font-normal">#ML-3467</a>
                </div>
              </li>
              <li class="flex items-center relative">
                <div class="text-gray-700 flex-shrink-0 text-end">12:00 am</div>
                <div class="flex flex-col items-center mx-4">
                  <span
                    class="w-2 h-2 border-2 border-green-500 rounded-full my-2"
                  ></span>
                  <span class="w-px h-4 bg-gray-200"></span>
                </div>
                <div class="text-gray-700">
                  Payment was made of $64.95 to Michael
                </div>
              </li>
              <li class="flex items-center relative">
                <div class="text-gray-700 flex-shrink-0 text-end">09:30 am</div>
                <div class="flex flex-col items-center mx-4">
                  <span
                    class="w-2 h-2 border-2 border-yellow-500 rounded-full my-2"
                  ></span>
                  <span class="w-px h-4 bg-gray-200"></span>
                </div>
                <div class="text-gray-700 font-semibold">
                  New sale recorded
                  <a href="#" class="text-blue-500 block font-normal">#ML-3467</a>
                </div>
              </li>
              <li class="flex items-center relative">
                <div class="text-gray-700 flex-shrink-0 text-end">09:30 am</div>
                <div class="flex flex-col items-center mx-4">
                  <span
                    class="w-2 h-2 border-2 border-red-500 rounded-full my-2"
                  ></span>
                  <span class="w-px h-4 bg-gray-200"></span>
                </div>
                <div class="text-gray-700 font-semibold">
                  New arrival recorded
                </div>
              </li>
              <li class="flex items-center relative">
                <div class="text-gray-700 flex-shrink-0 text-end">12:00 am</div>
                <div class="flex flex-col items-center mx-4">
                  <span
                    class="w-2 h-2 border-2 border-green-500 rounded-full my-2"
                  ></span>
                </div>
                <div class="text-gray-700">Payment Done</div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="w-full lg:w-8/12 flex mt-6 lg:mt-0">
        <div class="w-full bg-white shadow rounded-lg">
          <div class="p-4">
            <h5 class="text-lg font-semibold mb-4">Recent Transactions</h5>
            <div class="overflow-x-auto">
              <table class="w-full text-left">
                <thead class="text-gray-700">
                  <tr>
                    <th class="py-2">Id</th>
                    <th class="py-2">Assigned</th>
                    <th class="py-2">Name</th>
                    <th class="py-2">Priority</th>
                    <th class="py-2">Budget</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="py-2">1</td>
                    <td class="py-2">
                      <h6 class="font-semibold">Sunil Joshi</h6>
                      <span class="text-sm">Web Designer</span>
                    </td>
                    <td class="py-2">Elite Admin</td>
                    <td class="py-2">
                      <span
                        class="bg-blue-500 text-white px-2 py-1 rounded-full text-sm"
                        >Low</span
                      >
                    </td>
                    <td class="py-2">$3.9</td>
                  </tr>
                  <tr>
                    <td class="py-2">2</td>
                    <td class="py-2">
                      <h6 class="font-semibold">Andrew McDownland</h6>
                      <span class="text-sm">Project Manager</span>
                    </td>
                    <td class="py-2">Real Homes WP Theme</td>
                    <td class="py-2">
                      <span
                        class="bg-gray-500 text-white px-2 py-1 rounded-full text-sm"
                        >Medium</span
                      >
                    </td>
                    <td class="py-2">$24.5k</td>
                  </tr>
                  <tr>
                    <td class="py-2">3</td>
                    <td class="py-2">
                      <h6 class="font-semibold">Christopher Jamil</h6>
                      <span class="text-sm">Project Manager</span>
                    </td>
                    <td class="py-2">MedicalPro WP Theme</td>
                    <td class="py-2">
                      <span
                        class="bg-red-500 text-white px-2 py-1 rounded-full text-sm"
                        >High</span
                      >
                    </td>
                    <td class="py-2">$12.8k</td>
                  </tr>
                  <tr>
                    <td class="py-2">4</td>
                    <td class="py-2">
                      <h6 class="font-semibold">Nirav Joshi</h6>
                      <span class="text-sm">Frontend Engineer</span>
                    </td>
                    <td class="py-2">Hosting Press HTML</td>
                    <td class="py-2">
                      <span
                        class="bg-green-500 text-white px-2 py-1 rounded-full text-sm"
                        >Critical</span
                      >
                    </td>
                    <td class="py-2">$2.4k</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    </div>
      </div>
    
  </div>
</main>
<script src="libs/apexcharts/dist/apexcharts.min.js"></script>
<script src="js/dashboards.js"></script>
</body>
</html>

