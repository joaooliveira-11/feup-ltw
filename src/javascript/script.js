const manage_options_button = document.getElementById('ManageWebsite');
const manageOptions = document.querySelector('#AsideAdmin ul');
const arrowLeftImage = document.querySelector('#SetaParaDireita');

manage_options_button.addEventListener('click', function (){
    if(manageOptions.style.display==="none") {
        manageOptions.style.display="block";
        arrowLeftImage.style.display="block";
    }
    else {
        manageOptions.style.display="none";
        arrowLeftImage.style.display="none";
    }
})