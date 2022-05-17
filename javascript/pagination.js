let currentPage= document.querySelector(".page-item")

currentPage.addEventListener("click", function(e){
    console.log("clicked");
/*    if(currentPage.style.display === "none") {
        currentPage.classList.add = "active";
    } else {
        currentPage.classList.remove = "active";
    }*/
    currentPage.classList.add = "active";

})