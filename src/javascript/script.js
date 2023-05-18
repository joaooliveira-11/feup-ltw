const manage_options_button = document.getElementById('ManageWebsite');

if(manage_options_button) {
    const manageOptions = document.querySelector('#AsideAdmin ul');
    const arrowLeftImage = document.querySelector('#SetaParaDireita');

    manage_options_button.addEventListener('click', function () {
        if (manageOptions.style.display === "none") {
            manageOptions.style.display = "block";
            arrowLeftImage.style.display = "block";
        } else {
            manageOptions.style.display = "none";
            arrowLeftImage.style.display = "none";
        }
    })
}

function createNotification(type, text) {
    let notification = document.createElement('div');
    notification.classList.add('notification', type);
    notification.textContent = type + ' -> ' + text;
    document.body.appendChild(notification);
    /*setTimeout(function() {
        notification.remove();
    }, 5000);*/
}