<nav>
    <div class="container-avatar">
        <img src="../../images/{{$user['avatar']}}" alt="Avatar">
        <br>
        <p>{{ $user['name'] }} {{ $user['last_name'] }}</p>
    </div>
    <ul>
        @foreach ($services as $service)
            <li>
                <a href="{{ route('monthly_payments') }}">{{$service->name}}</a>
            </li>
        @endforeach
    </ul>
    <form action="{{route('logout')}}" method="GET">
        @csrf
        <img src="../../images/salida.png" alt="Icono de cerrar sesion">
        <input type="submit" value="Cerrar sesión">
    </form>
</nav>