import searchPage from "./search";
import pillarPage from "./pillar";

export const pillarDictionary = ["learn", "apply", "explore", "connect"];

// app init
window.addEventListener("load", async function () {
  try {
    const $ = jQuery;
    let term = location.search.length && location.search.slice(1).split("=")[1];

    const onPostClick = (e) => {
      console.log("post item clicked");
      const url = $(e.currentTarget).find("h2 a").attr("href");
      window.open(url, "_blank").focus();
    };

    $(".page-search").on("click", ".search-item", onPostClick);
    $("body .wp-block-query .wp-block-post-template li").on(
      "click",
      onPostClick
    );

    if (window.location.pathname.includes("/search")) {
      searchPage(onPostClick, term);
    }

    if (window.location.pathname.includes("/events")) {
      $(".gm-navbar")
        .after(`<div class="relative overflow-hidden bg-no-repeat bg-cover mb-10" style="
      background-position: 50%;
      background-image: url(/wp-content/uploads/2022/11/Hero-Image-Banner-1-2.png);
      height: 350px;
    ><div class=" absolute="" top-0="" right-0="" bottom-0="" left-0="" w-full="" h-full="" overflow-hidden="" bg-fixed"="">
      <div class="gm-container flex items-center h-full">
          <div class="text-white md:px-12 !pl-0">
              <h1 class="text-5xl font-medium mt-0 mb-6">Events</h1>
              <h3 class="text-3xl font-light mb-8">Connect with various communities and development groups around the firm.</h3>
          </div>
      </div>
  </div>`);
    }

    const isPillar = pillarDictionary.reduce(
      (prev, curr) => (window.location.pathname.includes(curr) && curr) || prev,
      ""
    );

    if (isPillar) {
      pillarPage(isPillar, searchPage);
    }
  } catch (e) {
    console.log(e);
  }
});
