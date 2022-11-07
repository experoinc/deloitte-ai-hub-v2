<?php
get_header(); ?>

<div style="min-height: calc(100vh - 78px);" class="page-search flex flex-col container mx-auto bg-white font-roboto content-padding pt-10 pb-20">
  <div class="flex flex-col lg:flex-row items-center lg:items-start">
    <div class="flex flex-col">
      <div class="border-gray border flex flex-none self-start flex-col w-[333px] mb-5 p-3 rounded-md">
        <div class="sidebarSection">
          <div id="sortBy" class="border-gray px-4 flex flex-row justify-between items-center text-sm">
            <div>Sort By</div>
            <div class="fa fa-chevron-down alt"></div>
          </div>
          <div class="sortByContainer categoryContainer border-gray">
            <div class="px-4 py-2 flex flex-row items-center">
              <label class="inline-flex items-center text-xs">
                <input id="aToZ" name="sort" value="aToZ" class="text-grborder-gray w-4 h-4 mr-2 focus:ring-transparent border text-[#43B02A]" type="radio" />
                A-Z
              </label>
            </div>

            <div class="px-4 py-2 flex flex-row items-center">
              <label class="inline-flex items-center text-xs">
                <input id="oldToNew" checked="true" name="sort" value="oldToNew" class="text-grborder-gray  w-4 h-4 mr-2 focus:ring-transparent border text-[#43B02A]" type="radio" />
                Old to new
              </label>
            </div>
          </div>
        </div>
      </div>

      <div class="border-gray border flex flex-none self-start flex-col w-[333px] mb-10 p-3 rounded-md border-b">
        <div class="px-4 py-2 border-gray border-b text-sm">
          <span class="">Filter By</span>
        </div>
        <div class="sidebarSection">
          <div id="pillars" class="border-gray  px-4 py-2 flex flex-row justify-between items-center border-b text-sm">
            <div>Pillars</div>
            <div class="fa fa-chevron-down alt"></div>
          </div>
          <div class="categoryContainer pillarsContainer border-gray"></div>
        </div>

        <div class="sidebarSection">
          <div id="pillarTopics" class="border-gray border-b px-4 py-2 flex flex-row justify-between items-center text-sm">
            <div>Pillar Topics</div>
            <div class="fa fa-chevron-down alt"></div>
          </div>
          <div class="categoryContainer pillarsByContainer border-gray">
          </div>
        </div>

        <div class="sidebarSection">
          <div id="tagsContainer" class="border-gray  border-b px-4 py-2 flex flex-row justify-between items-center text-sm">
            <div>Tags</div>
            <div class="fa fa-chevron-down alt"></div>
          </div>
          <div class="categoryContainer tagsContainer border-gray border-b">
          </div>
        </div>
      </div>
    </div>


    <div class="flex flex-col flex-1">
      <div class="ml-6 mr-4 pb-7 flex mt-6 lg:mt-0 justify-center lg:justify-between">
        <div class="inner-search-container">
          <i class="gmi gmi-zoom-search"></i>
          <input type="text" placeholder="What are you looking for ?" class="inner-search">
        </div>
      </div>
      <div class="ml-6 mr-4 pb-7 flex lg:border-b lg:border-gray-400 mt-6 lg:mt-0 justify-center lg:justify-between">
        <span class="text-sm font-medium" id="results">Results</span>
      </div>
      <div id="selectedCategories" class="flex flex-wrap py-3 px-6"></div>
      <ul id="ajax-posts" class="wp-block-post-template font-sans space-between ml-[25px]">
      </ul>
      <div id="noResults" class="flex order-1 p-5 justify-center">
        <span>No Results</span>
      </div>

      <button id="more_posts" class="hidden order-2 ml-6 mr-4 bg-transparent text-gray-600 py-2 px-4 justify-between items-center flex bg-gray-300">
        <span class="mr-2">Show More</span>
        <svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M1.59249 0.320696C1.16783 0.0527657 0.601609 0.0527663 0.318499 0.454662C-0.106167 0.856557 -0.106167 1.52638 0.318499 1.79431L4.28204 5.6793L4.4236 5.81327C4.84826 6.0812 5.41448 6.0812 5.69759 5.6793L9.66113 1.79431L9.80269 1.66035C10.0858 1.25845 10.0858 0.722591 9.66113 0.320696L9.51958 0.186731C9.09491 -0.081199 8.52869 -0.0811998 8.24558 0.320696L4.98981 3.53586L1.59249 0.320696Z" fill="#787878" />
        </svg>

      </button>
    </div>
  </div>
</div>
</main>

<?php
get_footer(); ?>