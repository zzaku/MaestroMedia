let filterIcon = document.querySelector(".filter-icon-container");
let filterContainer = document.querySelector(".filter-container");
function handleFilter(){
    if(getComputedStyle(filterContainer).display != "none"){
        console.log("Filter")
      filterContainer.style.display = "none";
    } else {
      filterContainer.style.display = "flex";
    }
  };

filterIcon.onclick = handleFilter;