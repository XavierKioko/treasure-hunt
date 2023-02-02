let phoneInput = document.getElementById("phone-number");
let message = document.getElementById("message-to-send");

function sendMessage(){
    let number = phoneInput.value;

    number = (number[0] != "+") ? `+${number}` : number;

    location.href = `https://api.whatsapp.com/send?phone=${phoneInput.value}&text=${encodeURIComponent(message.value)}`;
}

