<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with {{ $receiver->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/js/app.js'])
</head>
<body>
    <div class="container mt-5">
        <h1>Chat with {{ $receiver->name }}</h1>
        <div id="chat-box" class="border p-3" style="height: 400px; overflow-y: scroll;">
            @foreach ($messages as $message)
                <div class="mb-2 {{ $message->sender_id == auth()->id() ? 'text-start' : 'text-end' }}">
                    <span class="badge {{ $message->sender_id == auth()->id() ? 'bg-primary' : 'bg-secondary' }}">
                        {{ $message->message }}
                    </span>
                </div>
            @endforeach
        </div>
        <div id="typing-indicator" class="mt-2 text-muted" style="display: none;">{{ $receiver->name }} is typing...</div>
        <form id="message-form" class="mt-3">
            @csrf
            <div class="input-group">
                <input type="text" id="message-input" class="form-control" placeholder="Type a message...">
                <button type="submit" class="btn btn-primary">Send</button>
            </div>
        </form>
    </div>
    <script>
        let receiverId = {{$receiver->id}};
        let senderId = {{Auth::id()}};

        let chatBox = document.getElementById('chat-box');
        let messageInput = document.getElementById('message-input');
        let typingIndicator = document.getElementById('typing-indicator');
        let messageForm = document.getElementById('message-form');

        
        window.addEventListener('DOMContentLoaded',function(){
            console.log('Content Reloaded');

    
            // subscribe to channel [send-message];
            window.Echo.private('send-message-' + senderId).listen('SendMessage' , (e)=>{
                console.log('message sent',e);
                
                // show the message
                const messageDiv = document.createElement('div');
                messageDiv.className = 'mb-2 text-end';
                messageDiv.innerHTML = `<span class="badge bg-secondary">${e.message.message}</span>`;
                chatBox.appendChild(messageDiv);
                chatBox.scrollTop = chatBox.scrollHeight;
            });

            // send message by calling send_message method from user-Model
            messageForm.addEventListener('submit', function (e) {
                e.preventDefault(); // prevent page from reload after submitting ;
                const message = messageInput.value;
                if (message) {
                    fetch(`/user/message/${receiverId}/send`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ message })
                    });
                    const messageDiv = document.createElement('div');
                    messageDiv.className = 'mb-2 text-start';
                    messageDiv.innerHTML = `<span class="badge bg-primary">${message}</span>`;
                    chatBox.appendChild(messageDiv);
                    chatBox.scrollTop = chatBox.scrollHeight;
                    messageInput.value = '';
                }
            });

            // subscribe to channel [user-typing];
            window.Echo.private('typing-' + receiverId).listen('Typing' , (e)=>{
                console.log('user is typing',e) ;
                if(e.value === receiverId){
                    typingIndicator.style.display = 'block';
                    setTimeout(() => typingIndicator.style.display = 'none', 3000);
                }
            });

            // call typing method from User-Model ; 
            let typingTimeOut;
            messageInput.addEventListener('input', function () {
                clearTimeout(typingTimeOut);
                fetch(`/user/message/typing`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                typingTimeOut = setTimeout(() => {typingIndicator.style.display = 'none'}, 3000);
            });

            // Set user offline on window close
            // window.addEventListener('beforeunload', function () {
            //     fetch('/user/offline', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
            // });
       

        });
       
    </script>
</body>
</html>