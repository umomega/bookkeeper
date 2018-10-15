<div class="flash-container">
    <div class="container">
        <div class="columns">
            <div class="column is-4 is-offset-8">
                @foreach (session('flash_notification', collect())->toArray() as $message)
                    <div class="notification is-{{ $message['level'] }}">
                        <button class="delete"></button>
                        <span class="flash-text">{{ $message['message'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
