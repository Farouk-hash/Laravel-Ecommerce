<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/js/app.js'])
</head>
<body>
    <div class="container mt-5">
        <h1>{{$current_user->name}}'s Chat {{$current_user->id}}</h1>
        <ul class="list-group mt-3">
            @foreach ($users_available as $user)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="{{ route('user.chat', $user->id) }}">{{ $user->name }} {{$user->id}}</a>
                    <span class="badge {{$user->isOnline() ? 'bg-success' : 'bg-secondary'}}" id="user-{{ $user->id }}-badge">
                        {{$user->isOnline() ? 'Online' : 'Offline'}}
                    </span>

                    
                </li>
            @endforeach
        </ul>
    </div>

    <script>
        let userId = {{Auth::id()}};

        window.addEventListener('DOMContentLoaded', function () {
            
            // set user is online ;
            fetch('/user/online', 
                { 
                    method: 'POST', 
                    headers: { 
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
                    } 
                }
            ).then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Success:', data);
            })
            .catch(error => {
                console.error('Fetch error:', error);
            });
        

            window.Echo.private('user-status-tracker')
            .listen('UserChatStatus', (e) => {
                console.log(`Realtime: User ${e.user_id} is now ${e.user_status}`);

                // Update badge in the DOM
                const badgeElement = document.querySelector(`#user-${e.user_id}-badge`);
                if (badgeElement) {
                    badgeElement.className = 'badge ' + (e.user_status === 'online' ? 'bg-success' : 'bg-secondary');
                    badgeElement.innerText = e.user_status.charAt(0).toUpperCase() + e.user_status.slice(1);
                }
            });

        // Set user offline on window close
        // window.addEventListener('beforeunload', function () {
        //     fetch('/user/offline', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
        // });

             let isInternalNavigation = false;

// Track internal navigation (clicks on internal links)
document.addEventListener('click', function(e) {
    const link = e.target.closest('a');
    if (link && link.href) {
        const linkHost = new URL(link.href).hostname;
        const currentHost = window.location.hostname;
        
        if (linkHost === currentHost) {
            isInternalNavigation = true;
        }
    }
});

// Reset flag after a short delay to handle programmatic navigation
document.addEventListener('click', function() {
    setTimeout(() => {
        isInternalNavigation = false;
    }, 100);
});

// Set user offline only when actually leaving the site or closing
window.addEventListener('beforeunload', function(e) {
    // Don't fire if it's internal navigation
    if (isInternalNavigation) {
        return;
    }
    
    // Use sendBeacon for better reliability when page is closing
    if (navigator.sendBeacon) {
        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        navigator.sendBeacon('/user/offline', formData);
    } else {
        // Fallback to fetch with keepalive
        fetch('/user/offline', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({}),
            keepalive: true // Ensures request completes even if page is closing
        }).catch(() => {}); // Ignore errors since page might be closing
    }
});

    });

    </script>
</body>
</html>