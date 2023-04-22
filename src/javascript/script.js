HomeButton = document.getElementById('HomeButton');
ProfileButton = document.getElementById('ProfileButton');
MyTicketsButton = document.getElementById('MyTicketsButton');

ProfileButton.addEventListener('click', function (){
    window.location.href="http://localhost:9000/pages/profile.php";
})

HomeButton.addEventListener('click', function (){
    window.location.href="http://localhost:9000/pages/main.php";
})

MyTicketsButton.addEventListener('click', function (){
    window.location.href="http://localhost:9000/pages/mytickets.php";
})

function addMessage(type,message){

}