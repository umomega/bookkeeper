<nav class="navbar is-transparent">
    <div class="navbar-brand">
        <a class="navbar-item" href="{{ route('bookkeeper.overview') }}">
            <img src="{{ Theme::url('img/bookkeeper-logo.svg') }}" width="32" height="32">
        </a>

        <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarSub">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div class="navbar-menu" id="navbarSub">
        <div class="navbar-start">
            @foreach(['transactions', 'accounts', 'clients', 'people'] as $section)
                <a class="navbar-item" href="{{ route('bookkeeper.' . $section . '.index') }}"><span class="navbar-item-text{{ $currentSection == $section ? ' is-selected' : '' }}">{{ __($section . '.title') }}</span></a>
            @endforeach
        </div>

        <div class="navbar-end">
            <div class="navbar-item is-hoverable">
                <span class="navbar-button">{!! Theme::img('img/user.svg') !!}</span>

                <div class="navbar-dropdown is-right">
                    <a href="{{ route('bookkeeper.users.index') }}" class="navbar-item">
                        <span class="icon"><i class="fa fa-users"></i></span> {{ __('users.index') }}
                    </a>
                    <a href="{{ route('bookkeeper.users.create') }}" class="navbar-item">
                        <span class="icon"><i class="fa fa-user-plus"></i></span> {{ __('users.create') }}
                    </a>
                </div>
            </div>

            <div class="navbar-item is-hoverable">
                <span class="navbar-button">{!! Theme::img('img/cog.svg') !!}</span>

                <div class="navbar-dropdown is-right">
                    <a href="{{ route('bookkeeper.settings.edit') }}" class="navbar-item">
                        <span class="icon"><i class="fa fa-wrench"></i></span> {{ __('settings.index') }}
                    </a>
                    <a href="{{ route('bookkeeper.update.index') }}" class="navbar-item">
                        <span class="icon"><i class="fa fa-sync"></i></span> {{ __('update.index') }}
                    </a>
                </div>
            </div>

            <div class="navbar-item is-hoverable">
                <span class="navbar-button">{!! $currentUser->presentAvatar() !!}</span>

                <div class="navbar-dropdown is-right">
                    <a href="{{ route('bookkeeper.profile.edit') }}" class="navbar-item">
                        <span class="icon"><i class="fa fa-user-circle"></i></span> {{ __('users.update_profile') }}
                    </a>
                    <a href="{{ route('bookkeeper.profile.password') }}" class="navbar-item">
                        <span class="icon"><i class="fa fa-key"></i></span> {{ __('users.change_password') }}
                    </a>
                    <hr class="navbar-divider">
                    <a href="{{ route('bookkeeper.auth.logout') }}" class="navbar-item">
                        <span class="icon"><i class="fa fa-sign-out-alt"></i></span> {{ __('auth.logout') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>
