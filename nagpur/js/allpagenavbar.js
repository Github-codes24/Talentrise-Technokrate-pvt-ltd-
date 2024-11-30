import navbar from "./navbar.js";

// document.getElementById('navbar_content').innerHTML = navbar();

const nav = document.getElementById('navbar_content');

if(nav)
    nav.innerHTML = 'navbar';
// else
//     console.error('nav not found');