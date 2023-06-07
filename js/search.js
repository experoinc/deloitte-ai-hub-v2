import { debounce, get, groupBy, keyBy, uniq } from "lodash";

export default async function searchPage(onPostClick, term, doInit = true) {
  const $ = jQuery;
  const $sortBy = $("#sortBy");
  const $pillars = $("#pillars");
  const $pillarTopics = $("#pillarTopics");
  const $tagsContainer = $("#tagsContainer");

  function getUrl(partial) {
    return `${location.origin}/${partial}`;
  }

  $([$sortBy, $pillars, $pillarTopics, $tagsContainer]).each(function () {
    const $el = this;
    $el.on("click", function () {
      $el.siblings(".categoryContainer").toggleClass("hidden");
      $el.find(".plus").toggleClass("transform rotate-45");
    });
  });

  function loadCategories() {
    // console.log("loading categories");
    // load all categories
    var str = "&pageNumber=" + 1 + "&per_page=" + 100;
    return $.ajax({
      type: "GET",
      dataType: "JSON",
      url: getUrl(ajax_args.categoriesUrl),
      data: str,
      success: function (data) {
        // console.log("categories", data, groupBy(data, "parent"));
      },
      error: function (jqXHR, textStatus, errorThrown) {
        // console.log("get categories error", errorThrown, textStatus, jqXHR);
      },
    });
  }

  function loadTags() {
    // load tags
    var str = "&pageNumber=" + 1 + "&per_page=" + 100;
    return $.ajax({
      type: "GET",
      dataType: "JSON",
      url: getUrl(ajax_args.tagsUrl),
      data: str,
      success: function (data) {
        // console.log("tags", data);
      },
      error: function (jqXHR, textStatus, errorThrown) {
        // console.log("get tags error", errorThrown, textStatus, jqXHR);
      },
    });
  }

  const categories = await loadCategories();
  const tags = await loadTags();
  const allFilters = [...categories, ...tags];
  const filtersById = keyBy(allFilters, "id");
  const categoriesByParent = groupBy(categories, "parent");
  const tagsById = groupBy(tags, "id");

  let ppp = 20; // Post per page
  let pageNumber = 1;
  let searchText = null;
  let posts = [];
  let selectedFilters = [];

  function load_posts(pageNumber, catIds, offset) {
    const aToZ = $("#aToZ").prop("checked");
    const orderby = aToZ ? "title" : "date";
    const categoryIds = selectedFilters.filter(
      (id) => filtersById[id].taxonomy === "category"
    );
    const tagsIds = selectedFilters.filter(
      (id) => filtersById[id].taxonomy === "post_tag"
    );

    // console.log("categoryIds", categoryIds, tagsIds);
    // const orderBy =
    var str =
      "&pageNumber=" +
      pageNumber +
      "&per_page=" +
      ppp +
      "&order=asc&orderby=" +
      orderby +
      "&offset=" +
      (offset === 0 ? offset : posts.length) +
      (catIds || categoryIds.length ? `&categories=${(catIds || categoryIds).join(",")}` : "") +
      (tagsIds.length ? `&tags=${tagsIds.join(",")}` : "") +
      "&tax_relation=OR" +
      (searchText ? "&search=" + searchText : "");

    $("#more_posts").toggleClass("hidden", true);
    $("#more_posts").attr("disabled", true);

    return $.ajax({
      dataType: "JSON",
      url: getUrl(ajax_args.postsUrl),
      data: str,
      success: function (data) {
        const $data = $(data).toArray();
        posts = [...posts, ...$data];
        if (!doInit) {
          return $data;
        } else {
          $("#more_posts").toggleClass("hidden", false);

          if ($data.length) {
            $("#noResults").toggleClass("hidden", true);
            $("#ajax-posts").append(renderPosts($data));
            $("#more_posts").attr("disabled", false);
            $("#results").html(`${data.length} Results`);
            renderDynamicFilters();
          } else {
            if (posts.length == 0) {
              $("#noResults").toggleClass("hidden", false);
            }
          }
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {},
    });
  }

  function renderPosts(posts) {
    return posts.map((p) => {
      const childCategories = p.categories.filter(
        (c) => !categoriesByParent[c]
      );
      const parentCategories = p.categories.filter(
        (c) => categoriesByParent[c]
      );

      const categories = parentCategories
        .map(
          (pc) =>
            `${filtersById[pc].name}: ${childCategories
              .filter((cc) => filtersById[cc].parent === pc)
              .map((c) => filtersById[c].name)
              .join(", ")}`
        )
        .join("|");

      const renderTags = (p.tags || []).map((t, i) => {
        // we dont render more than 3 tags
        if (i > 2) return;
        if (tagsById[t] && tagsById[t][0] && tagsById[t][0].name) {
          const val = tagsById[t][0].name;
          const caption = val.length > 10 ? `${val.slice(0, 10)}...` : val;
          return `<span class="tag text-xs border">${caption}</span>`;
        }
      });

      return `
      <li class="wp-block-post-template min-w-[300px] search-item shadow-none">
        ${
          (renderTags.length > 1 &&
            `<div class="post-tags-container">
          ${renderTags.join(" ")}
        </div>`) ||
          ""
        }
        <h2 class="text-lg font-semibold wp-block-post-title">
          <a href=${p.meta._links_to}>${p.title.rendered}</a>
        </h2>
        <div class="wp-block-post-terms">${categories}</div>
        <div class="wp-block-post-excerpt__excerpt">${p.excerpt.rendered}</div>
      </li>
    `;
    });
  }

  function renderTags() {
    const postsTags = uniq(
      posts.reduce((prev, curr) => [...prev, ...curr.tags], [])
    );
    const filteredTags = tags.filter((t) => postsTags.includes(t.id));
    if (filteredTags.length) {
      $(".tagsContainer").parent().removeClass("hidden");
      $(".tagsContainer").html(
        filteredTags.map((tag) => {
          return `
      <div class="px-4 py-2 flex flex-row items-center">
        <label class="inline-flex items-center text-xs">
        <input data-category="${tag.id}" ${
            selectedFilters.includes(String(tag.id)) ? "checked" : ""
          } class="tagInput categoryInput w-4 h-4 mr-2 focus:ring-transparent border text-[#43B02A] text-xs" type="checkbox" />${
            tag.name
          }
        </label>
      </div>`;
        })
      );
    } else {
      $(".tagsContainer").parent().toggleClass("hidden");
    }
  }

  function renderDynamicFilters() {
    const mainCategories = categoriesByParent[0];
    const catIds = posts.reduce(
      (prev, curr) => uniq([...prev, ...curr.categories]),
      []
    );
    const filteredMainCats = mainCategories.filter((c) =>
      catIds.includes(c.id)
    );

    if (filteredMainCats.length) {
      $(".pillarsContainer").parent().removeClass("hiden");
      $(".pillarsContainer").html(
        filteredMainCats.map((category) => {
          return `
        <div class="px-4 py-2 flex flex-row items-center">
          <label class="inline-flex items-center text-xs">
          <input data-category="${category.id}" ${
            selectedFilters.includes(String(category.id)) ? "checked" : ""
          } class="categoryInput w-4 h-4 mr-2 focus:ring-transparent border text-[#43B02A] text-xs" type="checkbox" />${
            category.name
          }
          </label>
        </div>`;
        })
      );
    } else {
      $(".pillarsContainer").parent().toggleClass("hiden");
    }

    if (filteredMainCats.length) {
      $(".pillarsByContainer").parent().removeClass("hidden");
      $(".pillarsByContainer").html(
        filteredMainCats.map((category) => {
          const filteredSubs = get(categoriesByParent, `[${category.id}]`, []);
          if (filteredSubs.length) {
            return `
                    <div class="px-4 py-2 capitalize mt-2"><span class="text-sm text-gray-600">${
                      category.name
                    }</span>
                    ${filteredSubs
                      .map((subcategory) => {
                        return `
                        <div class="py-2 flex flex-row items-center">
                          <label class="inline-flex items-center text-xs">
                            <input data-category="${subcategory.id}" ${
                          selectedFilters.includes(String(subcategory.id))
                            ? "checked"
                            : ""
                        } class="categoryInput w-4 h-4 mr-2 focus:ring-transparent border text-[#43B02A] text-xs" type="checkbox" />${
                          subcategory.name
                        }
                          </label>
                        </div>`;
                      })
                      .join("")}
                    `;
          }
        })
      );
    } else {
      $(".pillarsByContainer").parent().toggleClass("hidden");
    }

    renderTags();

    $("#aToZ, #oldToNew").on("click", () => {
      refreshPosts();
    });

    $(".categoryInput").on("click", (e) => {
      if (e.target.checked) {
        selectedFilters = [
          ...selectedFilters,
          e.target.getAttribute("data-category"),
        ];
      } else {
        selectedFilters = selectedFilters.filter(
          (category) => category !== e.target.getAttribute("data-category")
        );
      }

      renderSelectedCategories();
      refreshPosts();
    });
  }
  function refreshPosts() {
    pageNumber = 1;
    posts = [];
    $("#ajax-posts").empty();
    load_posts(pageNumber++);
  }
  function renderSelectedCategories() {
    $("#selectedCategories").html(
      selectedFilters.map((categoryId) => {
        const category = filtersById[categoryId];
        if (!category) {
          return "";
        }

        return `
      <div data-category="${category.id}" class="selectedCategory px-2 mb-2 text-white bg-primary flex items-center mr-4">
        <span class="text-sm">${category.name}</span>
        <svg class="removeCategory" class="ml-4 cursor-pointer" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M6.75586 8.875L2.75 12.8809L3.99414 14.125L8 10.1055L12.0059 14.125L13.25 12.8809L9.23047 8.875L13.25 4.86914L12.0059 3.625L8 7.63086L3.99414 3.625L2.75 4.86914L6.75586 8.875Z" fill="white"/>
        </svg>
      </div>
        `;
      })
    );

    $(".removeCategory").on("click", function () {
      selectedFilters = selectedFilters.filter(
        (category) =>
          category !== this.parentElement.getAttribute("data-category")
      );
      renderSelectedCategories();
      refreshPosts();
      renderDynamicFilters();
    });
  }

  function searchTerm(term) {
    searchText = term.toLowerCase();
    $([$sortBy, $pillars, $pillarTopics, $tagsContainer]).each(function () {
      const $el = this;
      $el.siblings(".categoryContainer").toggleClass("hidden", false);
      // $el.find(".plus").toggleClass("transform rotate-45", true);
    });

    pageNumber = 1;
    posts = [];
    $("#ajax-posts").empty();
    load_posts(pageNumber++);
  }

  function initialSetup() {
    const debounceSearch = debounce(searchTerm, 500);
    $("input.inner-search").on("input", (e) => debounceSearch(e.target.value));

    $("#clearAll").on("click", (e) => {
      if (searchText || selectedFilters.length) {
        selectedFilters = [];
        renderSelectedCategories();
        searchText = "";
        $("#searchInput").val("");
        debounceSearch(searchText);
      }
    });

    $("#more_posts").on("click", function () {
      // When btn is pressed.
      load_posts(pageNumber++);
    });

    $(".fa-chevron-down").on("click", function (params) {
      $(params.currentTarget).toggleClass("rotate");
    });

    if (term) {
      // console.log(`there's a term ${term}`);
      debounceSearch(term);
    } else {
      load_posts(pageNumber++);
    }
  }

  if (doInit) initialSetup();
  else
    return {
      renderPosts,
      load_posts,
    };
}
