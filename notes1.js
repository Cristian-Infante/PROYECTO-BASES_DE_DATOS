document.getElementById('add').style.display = "none";
document.getElementById('remove').style.display = "none";
document.getElementById('Edit').style.display = "none";


document.getElementById("bAdd").onclick = function () {
    sAdd()
};
function sAdd() {
    document.getElementById('add').style.display = "block";
    document.getElementById('principal').style.display = "none";
}

if(document.getElementById("bEdit") != null){
    document.getElementById("bEdit").onclick = function () {
        sEdit()
    };
}
function sEdit() {
    document.getElementById('principal').style.display = "none";
    document.getElementById('edit1').style.display = "none";
    document.getElementById('search').style.display = "block";
    document.getElementById('Edit').style.display = "block";
}
if(document.getElementById("bRemove") != null){
    document.getElementById("bRemove").onclick = function () {
        sRemove()
    };
}
function sRemove() {
    document.getElementById('principal').style.display = "none";
    document.getElementById('remove').style.display = "block";
}

document.getElementById("hAdd").onclick = function () {
    hAdd()
};
function hAdd() {
    document.getElementById('principal').style.display = "flex";
    document.getElementById('add').style.display = "none";
}
document.getElementById("hEdit").onclick = function () {
    hEdit()
};
function hEdit() {
    document.getElementById('Edit').style.display = "none";
    document.getElementById('principal').style.display = "flex";
}
document.getElementById("hRemove").onclick = function () {
    hRemove()
};
function hRemove() {
    document.getElementById('remove').style.display = "none";
    document.getElementById('principal').style.display = "flex";
}
