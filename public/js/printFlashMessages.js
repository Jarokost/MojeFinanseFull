let flash_message_id = 0;

function printFlashMessages(data)
{
  let flash_id;
  for (let i = 0; i< data.flash_message_body.length; i++) {
    flash_id = 'flash_message_id' + flash_message_id;
    document.querySelector(".flash_messages_print_from_ajax")
    .insertAdjacentHTML( "beforeend", 
    `<div id="${flash_id}" 
      class="alert alert-${data.flash_message_type[0]}">
      ${data.flash_message_body[0]}
    </div>`);
    setTimeout(function(){
      document.getElementById(flash_id).remove();
    }, 8000);

    flash_message_id++;
  }
}

setTimeout(function(){
    const messages = document.querySelectorAll('.flash_messages');
    for(let i=0; i < messages.length; i++) {
      messages[i].remove();
    }
  }, 5000);