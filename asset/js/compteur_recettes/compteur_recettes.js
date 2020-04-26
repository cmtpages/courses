function addPerson(quantites) {
    var n = ++document.getElementById("nb_personnes").innerHTML;
    var ul = document.getElementById("ingredients");
    var items = ul.getElementsByClassName("quantite");
    for (var i = 0; i < items.length; i++) {
        items[i].innerHTML = Math.round(parseFloat(quantites[i])*n*100)/100;
    }
}
function delPerson(quantites) {
    var n = document.getElementById("nb_personnes").innerHTML;
    if(n>1) {
        n=--document.getElementById("nb_personnes").innerHTML;
        var ul = document.getElementById("ingredients");
        var items = ul.getElementsByClassName("quantite");
        for (var i = 0; i < items.length; ++i) {
            if(items[i]!=""){
                items[i].innerHTML = Math.round(parseFloat(quantites[i])*n*100)/100;
            }
        }
    }
}
