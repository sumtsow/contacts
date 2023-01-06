<nav class="navbar navbar-expand-lg">
  <!-- Primary Navigation Menu -->
  <div class="container-fluid">
    <a class="navbar-brand" href="/">{{ __('app.main') }}</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#dropdownMenu" aria-controls="dropdownMenu" aria-expanded="true" aria-label="Переключити">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div id="dropdownMenu" class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="true">{{ Auth::user()->name }}</a>
          <ul class="dropdown-menu">
            <li>
              <a class="dropdown-item" href="/dashboard">{{ __('app.home') }}</a>
            </li>
            <li>
              <a class="dropdown-item" href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Вийти</a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
</nav>
