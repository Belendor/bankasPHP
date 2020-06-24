const name = document.querySelector("#input-name")
const nameError = document.querySelector(".name-error")
const surename = document.querySelector("#input-surename")
const surenameError = document.querySelector(".surename-error")
const id = document.querySelector("#input-id")
const idError = document.querySelector(".id-error")
const button = document.querySelector("button")

const message = document.querySelector(".message")


name.addEventListener("input", ()=>{

    if(name.value.length < 3){
        button .disabled = true
        nameError.innerHTML = 'Per trumpas vardas'
    }else{
        button .disabled = false
        nameError.innerHTML = ''
    }
})

surename.addEventListener("input", ()=>{

    if(surename.value.length < 3){
        button .disabled = true
        surenameError.innerHTML = 'Per trumpa pavarde'
    }else{
        button .disabled = false
        surenameError.innerHTML = ''
    }
})

id.addEventListener("input", ()=>{

    if(id.value.length != 11){
        button .disabled = true
        idError.innerHTML = 'Blogas asmens kodas'
    }else{
        button .disabled = false
        idError.innerHTML = ''
    }

})

message.addEventListener("click", ()=>{
    message.remove()
})