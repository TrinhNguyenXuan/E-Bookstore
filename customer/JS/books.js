// import {books} from "./data.js"

var bookEl = document.getElementsByClassName("main")[0]

// for(let i = 0; i<books.length; i++){
//     var book = document.createElement("div")
//     book.classList.add("book")
//     book.innerHTML =`<img src="./assets/Berserk_vol01.jpg" alt="">
//     <p class="title">${books[i].title}</p>
//     <p class="price">${books[i].price}$</p>
//     `
//     var btn = document.createElement("div")
//     btn.classList.add("btn")
//     var buyBtn = document.createElement("button")
//     buyBtn.innerText = "Buy"
//     buyBtn.classList.add("buy-btn")
//     buyBtn.addEventListener("click",()=>buyNow(i),false)
//     var addBtn = document.createElement("button")
//     addBtn.innerText = "Add"
//     addBtn.classList.add("add-btn")
//     addBtn.addEventListener("click",()=>addBook(i),false)
//     btn.appendChild(buyBtn)
//     btn.appendChild(addBtn)

//     // <div class="btn">
//     //     <button class="buy-btn">Buy</button>
//     //     <button class="add-btn" onclick="addBook(${i})">Add</button>
//     // </div>`
//     book.appendChild(btn)
//     bookEl.appendChild(book)
// }

function addBook(value){
    let num = sessionStorage.getItem(`${value}`)
    notify()
    if(num)
    {    
        sessionStorage.setItem(`${value}`,parseInt(num)+1)        
    }
    else
    {
        sessionStorage.setItem(`${value}`, 1)
    }
}

function notify(){
    var noti = document.getElementsByClassName("alert")[0]
    noti.style.display = "block"
    setTimeout(()=>{
        noti.style.display = "none"
    },3000)
}

function buyNow(value){
    localStorage.setItem("product", value)
    window.location.replace("./pay_one_book.html")
}
