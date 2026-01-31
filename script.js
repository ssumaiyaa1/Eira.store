function openForm(productName){
    document.getElementById("popupForm").style.display = "flex";
    document.getElementById("orderName").value = productName;
}

function closeForm(){
    event.preventDefault();
    document.getElementById("popupForm").style.display = "none";
}

function scrollToProducts(){
    document.getElementById("products").scrollIntoView({behavior: "smooth"});
}

function searchProducts(){
    let input = document.getElementById("searchBox").value.toLowerCase();
    let products = document.querySelectorAll(".product");

    products.forEach(p => {
        let name = p.querySelector("h3").innerText.toLowerCase();
        p.style.display = name.includes(input) ? "block" : "none";
    });
}
