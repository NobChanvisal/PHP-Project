<!DOCTYPE html>
<html lang="en">
  <?php include 'include/head.inc.php' ?>
<body>
    <?php include 'include/header.inc.php'; ?>
    <section>
      <div class=" h-screen pt-20 flex md:flex-row sm:justify-between bg-gray-100">
        <div class=" self-center max-md:absolute pl-5 sm:pl-20 flex-1 order-2 sm:order-1">
          <h1 class="text-6xl">Amazing Lamps</h1>
          <p class=" pt-5">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
          <button class="mt-4 px-8 py-2 bg-black text-white hover:bg-gray-800">Shop Now</button>
        </div>
          <div class=" flex justify-end sm:px-16 w-2/4 order-1 sm:order-2">
            <img class=" h-2/6 mr-4 hidden lg:block" src="https://arredo.qodeinteractive.com/wp-content/uploads/2018/05/home9-slider-img3.png" alt="">
            <img class="  h-4/6" src="https://arredo.qodeinteractive.com/wp-content/uploads/2018/05/home9-slider-img1.png" alt="">
            <img class=" hidden sm:block h-3/6" src="https://arredo.qodeinteractive.com/wp-content/uploads/2018/05/home9-slider-img2.png" alt="">
          </div>
      </div>
    </section>
    <?php include 'include/newarrivals.inc.php' ?>
    <section>
    <!--  -->
      <div class=" mt-10 mb-10">
        <div class="relative h-auto max-h-[70vh] text-white overflow-hidden">
          <div class="absolute inset-0">
            <img class=" h-full w-full cover" src="https://www.lepower-tec.com/cdn/shop/files/lepower-tec-desk-lamps-category-page-banner.jpg?v=1684225822&width=2800" />
            <div class="absolute inset-0 bg-black opacity-20"></div>
          </div>
          
          <div class="relative p-5 sm:p-10 z-10 flex flex-col justify-center items-center h-full text-center">
            <h1 class=" text-3xl sm:text-5xl font-bold leading-tight mb-2 sm:mb-4">Upcoming collection</h1>
            <p class=" text-sm sm:text-lg text-gray-300 mb-3 sm:mb-8">Ut enim ad minim veniam, quis nostrud exercitation ullamco ommodo consequat. Duis aute irure dolor in reprehenderit.</p>
            <a  class=" py-1.5 sm:py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Read More</a>
          </div>
        </div>
      </div>
    </section>
    <section class="">
      <div class=" px-5 sm:px-10 md:px-20 py-5 gap-11 grid grid-cols-1 sm:grid-cols-2 place-items-center">
          <div class=" flex flex-col items-center text-center">
              <h1 class=" pb-3 text-4xl">Modern Table Lamps</h1>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
              <a href="Shop.php?category=Table Lamps" class="text-white bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-green-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center mt-4 me-2 mb-2">View All Product</a>
          </div>
          <div class=" w-full  justify-self-end">
            <img class=" w-full object-cover max-h-[450px]" src="https://brightech.com/cdn/shop/files/Serena.png?v=1708985652&width=576" alt="">
          </div>
      </div>
    </section>
    <section class="">
      <div class=" px-5 sm:px-10 md:px-20 py-5 gap-11 grid grid-cols-1 sm:grid-cols-2 place-items-center">
      <div class=" w-full  justify-self-end">
            <img class=" w-full object-cover max-h-[450px]" src="https://arredo.qodeinteractive.com/wp-content/uploads/2018/05/home9-product10-img1-768x927.jpg" alt="">
          </div>
          <div class=" flex flex-col items-center text-center">
              <h1 class=" pb-3 text-4xl">The Best Ceiling Lamps</h1>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
              <a href="Shop.php?category=Ceiling Lamps" class="text-white bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-green-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center mt-4 me-2 mb-2">View All Product</a>
          </div>
      </div>
    </section>
    <?php if (!isset($_SESSION['username'])):?>
      <section class="my-20 bg-gradient-to-br from-green-400 to-blue-600 py-8 text-white">
        <div class="container mx-auto px-4 text-center">
            <p class="text-lg md:text-xl pb-5">Sign up now and start using our awesome product.</p>
            <a href="login-account.php" class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Sign Up
                Now</a>
        </div>
      </section>
    <?php endif; ?>
    

    <?php include 'include/footer.inc.php'; ?>
</body>
</html>