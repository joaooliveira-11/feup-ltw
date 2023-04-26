HomeButton = document.getElementById('HomeButton');
ProfileButton = document.getElementById('ProfileButton');
MyTicketsButton = document.getElementById('MyTicketsButton');
NewTicket = document.getElementById('CreateNewTicket');
OpenTicketsButton = document.getElementById('TicketsOpenButton');
AssignedTicketsButton = document.getElementById('AssignedTicketsButton');

ProfileButton.addEventListener('click', function (){
    window.location.href="http://localhost:9000/pages/profile.php";
})

HomeButton.addEventListener('click', function (){
    window.location.href="http://localhost:9000/pages/main.php";
})

MyTicketsButton.addEventListener('click', function (){
    window.location.href="http://localhost:9000/pages/mytickets.php";
})

NewTicket.addEventListener('click', function (){
    window.location.href="http://localhost:9000/pages/newTicket.php";
})

OpenTicketsButton.addEventListener('click', function (){
    window.location.href="http://localhost:9000/pages/openTickets.php";
})

AssignedTicketsButton.addEventListener('click', function (){
    window.location.href="http://localhost:9000/pages/myAssignedTickets.php";
})



function addMessage(type,message){

}