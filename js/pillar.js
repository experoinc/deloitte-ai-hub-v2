import "tw-elements";
import { defer } from "lodash";

export default async function pillarPage(page, searchPage) {
  let hash = window.location.hash.length
    ? `tabs-${window.location.hash.slice(1)}-tab`
    : false;
  const { renderPosts, load_posts } = await searchPage(null, "", false);
  const $ = jQuery;
  let currCategory = -1;
  const topCount = $("section.pillar-top li").get().length;
  const carIndex = 2;

  const $pillarCategoriesIds = $("a[cat-id]")
    .get()
    .map((e, i) => {
      if (i === 0) currCategory = $(e).attr("cat-id");
      return $(e).attr("cat-id");
    });

  async function loadTabContent(first = false) {
    const ids =
      currCategory === "-1" ? $pillarCategoriesIds.slice(1) : [currCategory];
    const posts = await load_posts(1, ids, 0);
    $("ul#ajax-posts").html(renderPosts(posts));
    if (hash) {
      defer(() => {
        $(document).ready(() => {
          $(`#${hash}`).click();
          $(`#${hash}`).addClass("active");
          hash = false;
        });
      });
    } else if (first) {
      $("a[cat-id=-1]").addClass("active");
    }
  }

  $("a[cat-id]").on("click", function (e) {
    currCategory = $(this).attr("cat-id");
    loadTabContent();
  });

  function enableCarousel() {
    console.log(topCount);
    $("section.pillar-top li").each(function (i) {
      $(this).attr("car-index", i);
      if (i > 2) $(this).addClass("carousel-hidden");
    });
    $("button.car-btn-right").on("click", function () {
      $("section.pillar-top li").each(function (i) {
        if (i < carIndex + 3) $(this).toggleClass("carousel-hidden");
      });
    });
  }

  loadTabContent(true);
  enableCarousel();
}
