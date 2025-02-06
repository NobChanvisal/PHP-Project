<!DOCTYPE html>
<html lang="en">
<?php include 'include/head.inc.php'?>

<body>
<? include 'include/adside.inc.php'?>
<div class="container-fluid">
  <!-- Row 1 -->
  <div class="flex flex-wrap">
    <div class="w-full lg:w-8/12 flex">
      <div class="w-full bg-white shadow rounded-lg">
        <div class="p-4">
          <div class="flex flex-col sm:flex-row items-center justify-between mb-6">
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
                    <span class="me-1 rounded-full bg-green-100 w-5 h-5 flex items-center justify-center">
                      <i class="ti ti-arrow-up-left text-green-500"></i>
                    </span>
                    <p class="text-gray-700 me-1 text-lg">+9%</p>
                    <p class="text-lg">last year</p>
                  </div>
                  <div class="flex items-center">
                    <div class="me-4">
                      <span class="w-2 h-2 bg-blue-500 rounded-full me-2 inline-block"></span>
                      <span class="text-lg">2023</span>
                    </div>
                    <div>
                      <span class="w-2 h-2 bg-blue-100 rounded-full me-2 inline-block"></span>
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
                    <span class="me-2 rounded-full bg-red-100 w-5 h-5 flex items-center justify-center">
                      <i class="ti ti-arrow-down-right text-red-500"></i>
                    </span>
                    <p class="text-gray-700 me-1 text-lg">+9%</p>
                    <p class="text-lg">last year</p>
                  </div>
                </div>
                <div class="w-4/12">
                  <div class="flex justify-end">
                    <div class="bg-gray-600 text-white rounded-full w-12 h-12 flex items-center justify-center">
                      <i class="ti ti-currency-dollar text-lg"></i>
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
                <span class="w-2 h-2 border-2 border-blue-500 rounded-full my-2"></span>
                <span class="w-px h-4 bg-gray-200"></span>
              </div>
              <div class="text-gray-700">Payment received from John Doe of $385.90</div>
            </li>
            <li class="flex items-center relative">
              <div class="text-gray-700 flex-shrink-0 text-end">10:00 am</div>
              <div class="flex flex-col items-center mx-4">
                <span class="w-2 h-2 border-2 border-blue-400 rounded-full my-2"></span>
                <span class="w-px h-4 bg-gray-200"></span>
              </div>
              <div class="text-gray-700 font-semibold">New sale recorded <a href="#" class="text-blue-500 block font-normal">#ML-3467</a></div>
            </li>
            <li class="flex items-center relative">
              <div class="text-gray-700 flex-shrink-0 text-end">12:00 am</div>
              <div class="flex flex-col items-center mx-4">
                <span class="w-2 h-2 border-2 border-green-500 rounded-full my-2"></span>
                <span class="w-px h-4 bg-gray-200"></span>
              </div>
              <div class="text-gray-700">Payment was made of $64.95 to Michael</div>
            </li>
            <li class="flex items-center relative">
              <div class="text-gray-700 flex-shrink-0 text-end">09:30 am</div>
              <div class="flex flex-col items-center mx-4">
                <span class="w-2 h-2 border-2 border-yellow-500 rounded-full my-2"></span>
                <span class="w-px h-4 bg-gray-200"></span>
              </div>
              <div class="text-gray-700 font-semibold">New sale recorded <a href="#" class="text-blue-500 block font-normal">#ML-3467</a></div>
            </li>
            <li class="flex items-center relative">
              <div class="text-gray-700 flex-shrink-0 text-end">09:30 am</div>
              <div class="flex flex-col items-center mx-4">
                <span class="w-2 h-2 border-2 border-red-500 rounded-full my-2"></span>
                <span class="w-px h-4 bg-gray-200"></span>
              </div>
              <div class="text-gray-700 font-semibold">New arrival recorded</div>
            </li>
            <li class="flex items-center relative">
              <div class="text-gray-700 flex-shrink-0 text-end">12:00 am</div>
              <div class="flex flex-col items-center mx-4">
                <span class="w-2 h-2 border-2 border-green-500 rounded-full my-2"></span>
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
                    <span class="bg-blue-500 text-white px-2 py-1 rounded-full text-sm">Low</span>
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
                    <span class="bg-gray-500 text-white px-2 py-1 rounded-full text-sm">Medium</span>
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
                    <span class="bg-red-500 text-white px-2 py-1 rounded-full text-sm">High</span>
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
                    <span class="bg-green-500 text-white px-2 py-1 rounded-full text-sm">Critical</span>
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
  <div class="flex flex-wrap mt-6">
    <div class="w-full sm:w-6/12 lg:w-3/12">
      <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="relative">
          <a href="#"><img src="./images/products/s4.jpg" class="w-full" alt="..."></a>
          <a href="#" class="bg-blue-500 rounded-full p-2 text-white absolute bottom-0 right-0 m-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add To Cart"><i class="ti ti-basket"></i></a>
        </div>
        <div class="p-4">
          <h6 class="font-semibold text-lg">Boat Headphone</h6>
          <div class="flex items-center justify-between">
            <h6 class="font-semibold text-lg">$50 <span class="text-gray-500 text-base line-through">$65</span></h6>
            <ul class="flex space-x-1">
              <li><a href="#"><i class="ti ti-star text-yellow-400"></i></a></li>
              <li><a href="#"><i class="ti ti-star text-yellow-400"></i></a></li>
              <li><a href="#"><i class="ti ti-star text-yellow-400"></i></a></li>
              <li><a href="#"><i class="ti ti-star text-yellow-400"></i></a></li>
              <li><a href="#"><i class="ti ti-star text-yellow-400"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="w-full sm:w-6/12 lg:w-3/12 mt-6 sm:mt-0">
      <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="relative">
          <a href="#"><img src="./images/products/s5.jpg" class="w-full" alt="..."></a>
          <a href="#" class="bg-blue-500 rounded-full p-2 text-white absolute bottom-0 right-0 m-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add To Cart"><i class="ti ti-basket"></i></a>
        </div>
        <div class="p-4">
          <h6 class="font-semibold text-lg">MacBook Air Pro</h6>
          <div class="flex items-center justify-between">
            <h6 class="font-semibold text-lg">$650 <span class="text-gray-500 text-base line-through">$900</span></h6>
            <ul class="flex space-x-1">
              <li><a href="#"><i class="ti ti-star text-yellow-400"></i></a></li>
              <li><a href="#"><i class="ti ti-star text-yellow-400"></i></a></li>
              <li><a href="#"><i class="ti ti-star text-yellow-400"></i></a></li>
              <li><a href="#"><i class="ti ti-star text-yellow-400"></i></a></li>
              <li><a href="#"><i class="ti ti-star text-yellow-400"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="w-full sm:w-6/12 lg:w-3/12 mt-6 lg:mt-0">
      <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="relative">
          <a href="#"><img src="./images/products/s7.jpg" class="w-full" alt="..."></a>
          <a href="#" class="bg-blue-500 rounded-full p-2 text-white absolute bottom-0 right-0 m-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add To Cart"><i class="ti ti-basket"></i></a>
        </div>
        <div class="p-4">
          <h6 class="font-semibold text-lg">Red Valvet Dress</h6>
          <div class="flex items-center justify-between">
            <h6 class="font-semibold text-lg">$150 <span class="text-gray-500 text-base line-through">$200</span></h6>
            <ul class="flex space-x-1">
              <li><a href="#"><i class="ti ti-star text-yellow-400"></i></a></li>
              <li><a href="#"><i class="ti ti-star text-yellow-400"></i></a></li>
              <li><a href="#"><i class="ti ti-star text-yellow-400"></i></a></li>
              <li><a href="#"><i class="ti ti-star text-yellow-400"></i></a></li>
              <li><a href="#"><i class="ti ti-star text-yellow-400"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="w-full sm:w-6/12 lg:w-3/12 mt-6 lg:mt-0">
      <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="relative">
          <a href="#"><img src="./images/products/s11.jpg" class="w-full" alt="..."></a>
          <a href="#" class="bg-blue-500 rounded-full p-2 text-white absolute bottom-0 right-0 m-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add To Cart"><i class="ti ti-basket"></i></a>
        </div>
        <div class="p-4">
          <h6 class="font-semibold text-lg">Cute Soft Teddybear</h6>
          <div class="flex items-center justify-between">
            <h6 class="font-semibold text-lg">$285 <span class="text-gray-500 text-base line-through">$345</span></h6>
            <ul class="flex space-x-1">
              <li><a href="#"><i class="ti ti-star text-yellow-400"></i></a></li>
              <li><a href="#"><i class="ti ti-star text-yellow-400"></i></a></li>
              <li><a href="#"><i class="ti ti-star text-yellow-400"></i></a></li>
              <li><a href="#"><i class="ti ti-star text-yellow-400"></i></a></li>
              <li><a href="#"><i class="ti ti-star text-yellow-400"></i></a></li>
            </ul>
          </div>
    </div>
          
</body>
</html>