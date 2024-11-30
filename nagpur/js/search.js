document.getElementById("searchForm").addEventListener("submit", function(event){
    event.preventDefault();
    let searchTerm = document.getElementById("searchInput").value.toLowerCase();
    let items = document.querySelectorAll();
    let found = false;

    items.forEach(function(item) {
        if(item.textContent.toLowerCase().includes(searchTerm)){
            item.classList.remove("hidden");
            found = true;
        } else{
            item.classList.add("hidden");
        }
    });

    if(!found){
        document.getElementById("noResults").classList.remove("hidden");
    } else{
        document.getElementById("noResults").classList.add("hidden");
    }
});