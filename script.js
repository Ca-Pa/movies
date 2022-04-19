
let closeButton = document.querySelector('.close-message');
closeButton.addEventListener('click',removeMsgHandler);

function removeMsgHandler(e){
    this.parentNode.remove();
    // location.reload();
};

