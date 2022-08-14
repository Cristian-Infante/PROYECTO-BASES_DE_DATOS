document.getElementById('Edit').style.display = "none";


document.getElementById('hidden').style.display = "none";

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

document.getElementById("hEdit").onclick = function () {
    hEdit()
};
function hEdit() {
    document.getElementById('Edit').style.display = "none";
    document.getElementById('principal').style.display = "flex";
}
