// This file helps to make the domain switching more scalable and manageable
// Change the following 2 variables below to your own situation

const myLocalHost = "http://localhost/schola"; //change to yours
const myProductionHost = "https://schola-2.myf2.net"; //change to yours


let API_DOMAIN = null;

// let url = location.href;
let url = location.protocol + "//" + location.hostname;
// console.log(url)

if (url == "http://localhost" || url == "http://127.0.0.1") {
    API_DOMAIN = myLocalHost;
}
if (url == myProductionHost) {
    API_DOMAIN = myProductionHost;
}

// console.log(API_DOMAIN)
