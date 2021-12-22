<nav>
    <div class="container-avatar">
        <img src="../../images/{{ $user->avatar }}" alt="Avatar">
        <br>
        <p>{{ $user->user }}</p>
    </div>
    <ul>
        @foreach ($services as $service)
            <li>
                <a href="{{ route('monthly_payments') }}">{{$service->service}}</a>
            </li>
        @endforeach
    </ul>
    <form action="{{route('logout')}}" method="POST">
        @csrf
        <img src="../../images/salida.png" alt="Icono de cerrar sesion">
        <input type="hidden" name="userName" value="{{ $user->user }}">
        <input type="submit" value="Cerrar sesión">
    </form>
</nav>