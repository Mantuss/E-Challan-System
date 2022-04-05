const dashboardEL = document.getElementById("dashboard-btn");
const historyEL = document.getElementById("history-btn");
const logoutEL = document.getElementById("logout-btn");

dashboardEL.addEventListener("click", dashboard);
historyEL.addEventListener("click", history);
logoutEL.addEventListener("click", logout);

function dashboard() {
  console.log("Button Clicked");
}

function history() {
  console.log("History Button clicked");
}

function logout() {
  console.log("Bye Bitch");
}

const challanEl = document.getElementById("challan-id");

const licenseEl = document.getElementById("license-num");

const vehicleEl = document.getElementById("vehicle-number");

const usernameEl = document.getElementById("username");

const trafficIDEl = document.getElementById("traffic-id");

const fineAmountEl = document.getElementById("fine-amount");

const checkboxEl = document.getElementById("checkbox");

const previewChallanEl = document.getElementById("previewChallanID");

const previewLicensenEl = document.getElementById("previewLicenceNum");

const previewVehicleEl = document.getElementById("previewVehicleNum");

const previewUsernameEl = document.getElementById("previewUsername");

const previewtrafficIDEl = document.getElementById("previewTrafficId");

const previewfineAmountEl = document.getElementById("previewFineAmount");

const challanItems = {
  challanMan: [challanEl, previewChallanEl],
  license: [licenseEl, previewLicensenEl],
  vehicle: [vehicleEl, previewVehicleEl],
  username: [usernameEl, previewUsernameEl],
  trafficID: [trafficIDEl, previewtrafficIDEl],
  fineAmount: [fineAmountEl, previewfineAmountEl],
};

let userInput = "";

licenseEl.addEventListener("click", (l) => {
  previewChallan(challanItems, "challanMan", "Challan ID : ");
});

vehicleEl.addEventListener("click", (v) => {
  previewChallan(challanItems, "license", "License Number : ");
});

usernameEl.addEventListener("click", (u) => {
  previewChallan(challanItems, "vehicle", "Vehicle Number : ");
});

trafficIDEl.addEventListener("click", (t) => {
  previewChallan(challanItems, "username", "Username  : ");
});

fineAmountEl.addEventListener("click", (f) => {
  previewChallan(challanItems, "trafficID", "Traffic ID : ");
});

checkboxEl.addEventListener("click", (ce) => {
  previewChallan(challanItems, "fineAmount", "Fine Amount :");
});

function previewChallan(previewChallanElement, changingContent, innertextMan) {
  console.log(previewChallanElement[changingContent][0].value);
  console.log(userInput);
  if (userInput != previewChallanElement[changingContent][0].value) {
    console.log(previewChallanElement[changingContent][1]);
    previewChallanElement[
      changingContent
    ][1].textContent = `${innertextMan}${previewChallanElement[changingContent][0].value}`;
    userInput = previewChallanElement[changingContent][0].value;
    console.log("Abhinav");
  }
}
