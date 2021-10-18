
// if (document.getElementById("showItem")) {
//     console.log("sveiki");
// }


// const { default: axios } = require("axios");


// console.log(window.location.href);
// console.log(window.location.href.includes("map")," vaikstau po kategorijas");
// console.log(window.location.href.includes("show"), " esu prekeje");

const { default: axios } = require("axios");

// console.log(window.location.href.includes("map")," vaikstau po kategorijas");
// console.log(window.location.href.includes("show")," esu prekeje");

let drpDwn = document.getElementById("lines");
let searchBar = document.getElementById("searchBar");
let houseOfCards = document.getElementById("houseOfCards");


if (searchBar) {
    
    searchBar.addEventListener('keyup', function (e) {
        let timeout = null;
        clearTimeout(timeout);
        timeout = setTimeout(function () {
            axios.post(urlSearchBar,{
                searchBar : searchBar.value
            })
            .then(function(response){
               
                let HTML ='';
                let counter = 0;
                console.log(response.data);
                    for (let i = 0; i < response.data.items.length; i++) {
                        const item = response.data.items[i];
                        
                   
                    HTML += ' <a href="'+itemShow.substring(0, itemShow.length -1)+
                    +( ( (  ( (  (item['id']*3)  +6)  *3)  +7) *13) +6)* 124
                    +'">';
                    
                    
                    if(item['photos'] !=null && item['photos'].length > 0){
                        HTML+= ' <img  class="searchBarImg" src="'+url+'/items/small/' +item['photos'][0]['name'] + '" alt="">'; 
                       }else{
                         HTML+= ' <img style="width:25px; max-height:25px;" src="'+url+'/icons/defaultPlaceholder.png" alt=""> ';
                        }
                    
                        HTML+= item["name"]+'</a>';

                    if(++counter == 10){
                        // console.log(counter);
                        drpDwn.innerHTML = HTML;
                        return;
                    }
                };
                drpDwn.innerHTML = HTML;
            });
        }, 700);
    });

    searchBar.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
         console.log("enterinau");
         axios.post(urlSearchBar,{
            searchBar : searchBar.value
        })
        .then(function(response){
            let HTMLCards ='';
            response.data.items.forEach(item => {

            HTMLCards += generateCard(item);
            });

            houseOfCards.innerHTML = HTMLCards;
        });
        }
    });
}

function generateCard(item) {
 
  
    HTML =  `<a href="`+ itemShow.substring(0, itemShow.length -1)+
    +( ( (  ( (  (item['id']*3)  +6)  *3)  +7) *13) +6)* 124 + `" >
    <div class="Item '; `;
    if(item['status']==0) {
        HTML+= " bg-red ";
    }else if(item['quantity']==0){
            $HTML +=" inactive ";
        }
    
        HTML+= `">
      <div style="text-align:center;" > `+ item['name']  +`</div>
        <div style="border: solid red 1px; margin-left:10px; width:230px;height:230px; position: relative; ">`;
         
        if(item['photos'] !=null && item['photos'].length > 0){
           HTML+= ' <img class="cardImage" src="'+url+'/items/small/' +item['photos'][0]['name'] + '" alt="">'; 
          }else{
            HTML+= ' <img class="cardImage" src="'+url+'/icons/defaultPlaceholder.png" alt=""> ';
           }
           HTML+= ' </div>';
        if(item['discount'] > 0){
            HTML+= ' <div class="itemPrice">'+ item['price']+ '€';
            HTML+= ' <div class="itemDis">' + discountPrice(item)+ '</div>';
        }else{
            HTML+= ' <div class="itemPriceFull">'+ item['price']+'€';
        }
        HTML+= ' </div>';
        HTML+= '<div class="manufacturer"" >Gamintojas: '+ item['manufacturer']+'</div>';
        HTML+= ' <div class="quantity" >Prekės likutis: '+ item['quantity']+'</div>';
        HTML+= '<object><a class="toCart"  ';
        if(item['status']==0 || item['quantity']==0){
            HTML += "avoid-clicks";
        }
            HTML += '  class="btn btn-danger" href="">Į krepšelį</a> </object>';
       
        HTML+= `  <div class="heart"></div>
        </div>
        </a> `;
  return HTML;
    
}

 function discountPrice(item){
    // round( item->price - (),2 )
    return round_up(  item['price'] - (item['price'] *  (item['discount'] / 100) ),2  );
}
 function round_up ( value, precision ) { 
    // let pow = pow( 10, precision ); 
    // return ( ceil ( pow * value ) + ceil ( pow * value - ceil ( pow * value ) ) ) / pow; 
    return 1;
} 

// document.getElementById('myDropdown').addEventListener('focusout', function () {
   
//     drpDwn.innerHTML = "";
// });


//-------------------------//
// console.log("radau url", url);

// axios.get(url)
//     .then(function (response) {
//         console.log(response.data.msg);
//     });



//plain js (fetch)
//ajax
//axios