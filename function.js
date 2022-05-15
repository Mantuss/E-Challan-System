function printDiv(divName) {

    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    
}

function randomPassword(){

    var chars = "0123456789abcdefghijklmnopqrstuvwxyz!@#$%^&*()ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    var passwordLength = 8;
    var password = "";

    for (var i = 0; i <= passwordLength; i++) {
        var randomNumber = Math.floor(Math.random() * chars.length);
        password += chars.substring(randomNumber, randomNumber +1);
    }

    document.getElementById("pass").value = password;
    
}


var dropdown = document.getElementById("cause");
dropdown.addEventListener("change", function () {
    var amount = document.getElementById("amt");
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