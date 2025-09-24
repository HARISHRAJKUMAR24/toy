    <!--Product View Section Start -->
    <section class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4"> <!-- Increased container width -->

            <!-- Main Container -->
            <div class="bg-white rounded-2xl shadow-xl transform transition hover:shadow-2xl duration-300 p-8">

                <div class="flex flex-col md:flex-row gap-12">

                    <!-- Left: Product Images -->
                    <div class="flex flex-col md:flex-row gap-4 justify-center items-start flex-1">
                        <!-- Thumbnails -->
                        <div id="thumbnailContainer"
                            class="flex md:flex-col gap-3 md:max-h-[360px] overflow-x-auto md:overflow-y-auto order-2 md:order-1">
                            <img src="https://fantasticcleaners.com.au/blog/wp-content/uploads/2024/09/How-to-Clean-and-Disinfect-Childrens-Toys.jpg"
                                class="thumbnail w-20 h-20 object-cover rounded-lg cursor-pointer border-2 border-pink-500 transition"
                                onclick="document.getElementById('mainProductImage').src=this.src">
                            <img src="https://ichef.bbci.co.uk/ace/standard/976/cpsprodpb/2E0B/production/_107478711_gettyimages-1017309510.jpg"
                                class="thumbnail w-20 h-20 object-cover rounded-lg cursor-pointer border-2 border-gray-200 transition"
                                onclick="document.getElementById('mainProductImage').src=this.src">
                            <img src="https://storio.in/cdn/shop/files/71rmsECet7L.jpg?v=1712378234"
                                class="thumbnail w-20 h-20 object-cover rounded-lg cursor-pointer border-2 border-gray-200 transition"
                                onclick="document.getElementById('mainProductImage').src=this.src">
                            <img src="https://www.shutterstock.com/image-photo/many-soft-plush-fluffy-toys-600nw-1667812726.jpg"
                                class="thumbnail w-20 h-20 object-cover rounded-lg cursor-pointer border-2 border-gray-200 transition"
                                onclick="document.getElementById('mainProductImage').src=this.src">
                            <img src="https://moditoys.com/cdn/shop/files/website_banner_20.png?v=1731596936&width=2400"
                                class="thumbnail w-20 h-20 object-cover rounded-lg cursor-pointer border-2 border-gray-200 transition"
                                onclick="document.getElementById('mainProductImage').src=this.src">
                        </div>

                        <!-- Main Image Container -->
                        <div
                            class="flex justify-center items-center w-full md:w-[600px] lg:w-[700px] max-w-full rounded-lg overflow-hidden shadow-md order-1 md:order-2">
                            <img id="mainProductImage"
                                src="https://fantasticcleaners.com.au/blog/wp-content/uploads/2024/09/How-to-Clean-and-Disinfect-Childrens-Toys.jpg"
                                alt="Product Name" class="w-full h-full object-contain">
                        </div>
                    </div>

                    <!-- Right: Product Info -->
                    <div class="flex-1 flex flex-col">
                        <!-- Heading -->
                        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-2">Premium Teddy Bear
                        </h1>
                        <p class="text-base sm:text-lg md:text-xl text-gray-600 mb-4">Variant: Brown | Size: Medium</p>

                        <!-- Color Variants -->
                        <div class="flex gap-3 mt-4 mb-4 flex-wrap">
                            <button
                                class="px-4 py-2 bg-red-100 text-red-600 font-semibold rounded-lg shadow hover:bg-red-200 transition">RED</button>
                            <button
                                class="px-4 py-2 bg-green-100 text-green-600 font-semibold rounded-lg shadow hover:bg-green-200 transition">GREEN</button>
                            <button
                                class="px-4 py-2 bg-blue-100 text-blue-600 font-semibold rounded-lg shadow hover:bg-blue-200 transition">BLUE</button>
                            <button
                                class="px-4 py-2 bg-yellow-100 text-yellow-600 font-semibold rounded-lg shadow hover:bg-yellow-200 transition">YELLOW</button>
                        </div>

                        <!-- Rating -->
                        <div class="flex items-center gap-1 text-yellow-400 mb-4">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star text-gray-300"></i>
                            <span class="ml-2 text-sm text-gray-600">(120 reviews)</span>
                        </div>

                        <!-- Price -->
                        <div class="flex items-center gap-3 mb-6">
                            <span class="text-2xl font-bold text-pink-600">₹1,499</span>
                            <span class="text-gray-400 line-through">₹1,999</span>
                        </div>

                        <!-- Description -->
                        <p class="text-gray-700 leading-relaxed mb-6">
                            This premium teddy bear is made of ultra-soft plush fabric, safe for kids,
                            and perfect as a gift for birthdays or anniversaries. Lightweight and huggable,
                            it brings joy and comfort for all ages.
                        </p>

                        <!-- Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 mb-6 items-start sm:items-center">
                            <button
                                class="px-6 py-3 rounded-lg bg-gradient-to-r from-pink-400 to-pink-600 text-white font-semibold shadow-lg hover:from-pink-500 hover:to-pink-700 transition transform hover:scale-105">Buy
                                Now</button>
                            <button
                                class="px-6 py-3 rounded-lg bg-gray-200 text-gray-800 font-semibold shadow-lg hover:bg-gray-300 transition transform hover:scale-105">Add
                                to Cart</button>

                            <!-- Report Button -->
                            <button id="reportBtn"
                                class="px-4 py-3 rounded-lg bg-red-500 text-white shadow hover:bg-red-600 transition transform hover:scale-105 flex items-center justify-center">
                                <i class="fas fa-flag"></i>
                            </button>
                            <button
                                class="px-6 py-3 w-full sm:w-auto rounded-lg bg-gradient-to-r from-red-400 to-red-600 text-white font-semibold shadow-lg hover:from-red-500 hover:to-red-700 transition transform hover:scale-105 flex items-center justify-center gap-2">
                                <i class="fas fa-flag"></i>
                                Report Product
                            </button>
                        </div>

                        <!-- Social Share -->
                        <div>
                            <h3 class="text-gray-700 font-semibold mb-3">Share this product</h3>
                            <div class="flex gap-4 text-2xl">
                                <a href="#" class="text-green-500 hover:scale-110 transition"><i
                                        class="fab fa-whatsapp"></i></a>
                                <a href="#" class="text-pink-500 hover:scale-110 transition"><i
                                        class="fab fa-instagram"></i></a>
                                <a href="#" class="text-blue-600 hover:scale-110 transition"><i
                                        class="fab fa-facebook"></i></a>
                                <a href="#" class="text-sky-400 hover:scale-110 transition"><i
                                        class="fab fa-twitter"></i></a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!--Product View Section End -->


    
