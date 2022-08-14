document.getElementById('add').style.display = "none";
document.getElementById('remove').style.display = "none";

document.getElementById("bAdd").onclick = function () {
    sAdd()
};
function sAdd() {
    document.getElementById('add').style.display = "block";
    document.getElementById('principal').style.display = "none";
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

document.getElementById("hRemove").onclick = function () {
    hRemove()
};
function hRemove() {
    document.getElementById('remove').style.display = "none";
    document.getElementById('principal').style.display = "flex";
}
