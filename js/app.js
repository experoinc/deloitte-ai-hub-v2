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
