HomeButton = document.getElementById('HomeButton');
ProfileButton = document.getElementById('ProfileButton');

ProfileButton.addEventListener('click', function (){
    window.location.href="http://localhost:9000/pages/profile.php";
})

HomeButton.addEventListener('click', function (){
    window.location.href="http://localhost:9000/pages/main.php";
})