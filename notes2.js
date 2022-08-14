document.getElementById('Edit').style.display = "none";

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

function setInputFilter(textbox, inputFilter, errMsg) {
    ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop", "focusout"].forEach(function(event) {
      textbox.addEventListener(event, function(e) {
        if (inputFilter(this.value)) {
          // Accepted value
          if (["keydown","mousedown","focusout"].indexOf(e.type) >= 0){
            this.classList.remove("input-error");
            this.setCustomValidity("");
          }
          this.oldValue = this.value;
          this.oldSelectionStart = this.selectionStart;
          this.oldSelectionEnd = this.selectionEnd;
        } else if (this.hasOwnProperty("oldValue")) {
          // Rejected value - restore the previous one
          this.classList.add("input-error");
          this.setCustomValidity(errMsg);
          this.reportValidity();
          this.value = this.oldValue;
          this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
        } else {
          // Rejected value - nothing to restore
          this.value = "";
        }
      });
    });
  }
  setInputFilter(document.getElementById("edit"), function(value) {
    return /^\d*\.?\d*$/.test(value); // Allow digits and '.' only, using a RegExp
  }, "Only digits and '.' are allowed");
  