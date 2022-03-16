const more = document.getElementById("more");
const dropdown = document.getElementById("dropdown-more");
const navbar = document.querySelector(".navbar");
const host = window.location.protocol + "//" + window.location.host;
const pathname = window.location.pathname;
const n = 5;

more.addEventListener("click", (e) => {
    dropdown.classList.toggle("open")
})


const openNavbar = () => {
    document.querySelector('.navbar-menu').classList.toggle('is-active')
    navbar.classList.toggle("white");

}
if (window.location.pathname === "/") {
    const sliderContainer = document.querySelector(".slider-container")

    const slideRight = document.querySelector(".right-slide")

    const slideLeft = document.querySelector(".left-slide")


    const nextBtn = document.querySelector('.slider-container .action-buttons button:nth-child(1)')
    const prevBtn = document.querySelector('.slider-container .action-buttons button:nth-child(2)')


    const slidesLength = slideLeft.querySelectorAll('div').length;

    let activeSlide = 0;
// slideLeft.style.top = `-${(slidesLength - 1) * 100}vh`

    const changeSlide = (direction) => {
        const sliderHeight = sliderContainer.clientHeight;
        if (direction === "up") {
            activeSlide++;
            if (activeSlide > slidesLength - 1) {
                activeSlide = 0;
            }
        } else {
            activeSlide--;
            if (activeSlide < 0) {
                activeSlide = slidesLength - 1;
            }
        }

        slideRight.style.transform = `translateY(-${activeSlide * sliderHeight}px)`
        slideLeft.style.transform = `translateY(-${activeSlide * sliderHeight}px)`
    }
    nextBtn.addEventListener("click", () => changeSlide('up'))
    prevBtn.addEventListener("click", () => changeSlide('down'))
}

const loadMoreBtn = document.getElementById("load-more");
loadMoreBtn.addEventListener("click", (e) => {
    loadMoreBtn.classList.add("is-loading")
    const slug = pathname.includes("anakoinwseis") ? "anakoinwseis" : "draseis";
    const container = document.getElementById("postsContainer")
    const count = container.children.length;
    const limit = count + n + 1;
    var route = `${host}/wp-json/kranidi/v1/getMore?lower=${count}&upper=${limit}&cat=${slug}`;

    $.get(route).done(function (data) {
        loadMoreBtn.classList.remove("is-loading")
        container.innerHTML += data;
        console.log("ads")

    })

})

const searchBtn = document.getElementById("search");
var hasSearched = false;
searchBtn.addEventListener("click", () => {
    searchBtn.classList.add("is-loading")
    const container = document.getElementById("postsContainer")
    const like = document.querySelector("input[type=text]").value;
    const slug = pathname.includes("anakoinwseis") ? "anakoinwseis" : "draseis";
    var route = `${host}/wp-json/kranidi/v1/search?like=${like}&cat=${slug}`;
    ;

    $.get(route).done(function (data) {
        searchBtn.classList.remove("is-loading")

        container.innerHTML = data;
    })
})

const cancelBtn = document.getElementById("cancel");
cancelBtn.addEventListener("click", () => {
    initialPosts();
})

const initialPosts = () => {
    cancelBtn.classList.add("is-loading")
    const container = document.getElementById("postsContainer")
    const slug = pathname.includes("anakoinwseis") ? "anakoinwseis" : "draseis";
    var route = `${host}/wp-json/kranidi/v1/getMore?lower=1&upper=5&cat=${slug}`;

    $.get(route).done(function (data) {
        cancelBtn.classList.remove("is-loading")

        container.innerHTML = data;
    })
}

const like = document.querySelector("input[type=text]");
like.addEventListener("keyup", (e) => {
    const value = e.target.value;
    if (value === "") {
        initialPosts()
    }
})