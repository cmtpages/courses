function addPerson() {
    var n = document.getElementById("nb_personnes").innerHTML++;
    var ul = document.getElementById("ingredients");
    var items = ul.getElementsByClassName("quantite");
    for (var i = 0; i < items.length; ++i) {
        if(items[i]!=""){
            var tmp = parseFloat(items[i].innerHTML)/parseInt(n);
            items[i].innerHTML = parseFloat(tmp)+parseFloat(items[i].innerHTML);
        }
    }
}
function delPerson() {
    var n = document.getElementById("nb_personnes").innerHTML;
    if(n>1) {
        var ul = document.getElementById("ingredients");
        var items = ul.getElementsByClassName("quantite");
        for (var i = 0; i < items.length; ++i) {
            if(items[i]!=""){
                var tmp = parseFloat(items[i].innerHTML)/parseInt(n);
                items[i].innerHTML = tmp*(n-1);
            }
        }
        document.getElementById("nb_personnes").innerHTML--;
        n--;
    }
}
