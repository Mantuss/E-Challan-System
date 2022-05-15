
var dropdown = document.getElementById("cause");

dropdown.addEventListener("change", function () {

    var amount =  document.getElementById("amt");

    if (dropdown.value == "Overspeeding") {

      amount.value = 1000;
    }
    if (dropdown.value == "Accident") {

       amount.value = 2000;

    }
    if (dropdown.value == "Drink and Drive") {

        amount.value = 3000;

    }
    if (dropdown.value == "Others") {
        
        amount.value = 4000;
    }

});