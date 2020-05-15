var participantDiv = document.querySelector('#participant-signup');
var adminDiv = document.querySelector('#admin-signup');
var adminBtnChange = document.querySelector('#admin-change-button');
var participantBtnChange = document.querySelector('#participant-change-button');

adminBtnChange.addEventListener('click', function () {
    participantDiv.classList.toggle('hide');
    adminDiv.classList.toggle('hide');
})
participantBtnChange.addEventListener('click', function () {
    adminDiv.classList.toggle('hide');
    participantDiv.classList.toggle('hide');
})