let currentPage;

document.querySelector(".page-item").addEventListener("click", function(e){
    console.log("clicked");

    if(currentPage.className === "none") {
        currentPage.classList.add = "active";
    } else {
        currentPage.classList.remove = "active";
    }

})