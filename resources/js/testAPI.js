
// if (document.getElementById("showItem")) {
//     console.log("sveiki");
// }

// console.log(window.location.href);
// console.log(window.location.href.includes("map")," vaikstau po kategorijas");
// console.log(window.location.href.includes("show"), " esu prekeje");

if(document.getElementById("searchBar")){
  

    let input = document.getElementById('searchBar');
    let timeout = null;

    searchBar.addEventListener('keyup', function (e) {
        clearTimeout(timeout);
        timeout = setTimeout(function () {
            console.log('Value:', searchBar.value);
        }, 700);
    });
}
