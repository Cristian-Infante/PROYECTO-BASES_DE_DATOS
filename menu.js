document.getElementById('students').style.display = "none";
document.getElementById('notes1').style.display = "none";
document.getElementById('notes2').style.display = "none";
document.getElementById('menu').style.display = "block";

document.getElementById("sStudents").onclick = function() {sStudents()};
function sStudents() {
    document.getElementById('students').style.display = "block";
    document.getElementById('menu').style.display = "none";
}
document.getElementById("hStudents").onclick = function() {hStudents()};
function hStudents() {
    document.getElementById('students').style.display = "none";
    document.getElementById('menu').style.display = "block";
}

document.getElementById("sNotes1").onclick = function() {sNotes1()};
function sNotes1() {
    document.getElementById('notes1').style.display = "block";
    document.getElementById('menu').style.display = "none";
}
document.getElementById("hNotes1").onclick = function() {hNotes1()};
function hNotes1() {
    document.getElementById('notes1').style.display = "none";
    document.getElementById('menu').style.display = "block";
}

document.getElementById("sNotes2").onclick = function() {sNotes2()};
function sNotes2() {
    document.getElementById('notes2').style.display = "block";
    document.getElementById('menu').style.display = "none";
}
document.getElementById("hNotes2").onclick = function() {hNotes2()};
function hNotes2() {
    document.getElementById('notes2').style.display = "none";
    document.getElementById('menu').style.display = "block";
}