var rows = 12;
var cols = 13;
var value = "foo";
var trafficData  = [...Array(rows).map(e => Array(cols).fill(value))];
function loadTrafficData(){
    for(var i  = 0; i < rows ; i++){
        for (var j = 0; j < cols; j++){
            console.log(trafficData[i][j]);
        }
    }
}
console.log("hello");

loadTrafficData()

function createTrafficTable(trafficData){
   
    
    
    // dataHTML = `<tr><td></td><td></td><td></td><td></td><td></td></tr>`
}