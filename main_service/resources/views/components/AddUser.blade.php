<form>
    <div class="ilustration">
        <img src="../../images/form.svg" alt="Ilustración de formulario">
    </div>
    <div class="container">
        @csrf
        <div class="container-input">
            <input type="text" name="identification" placeholder=" identificacion...">
            <input type="text" name="userName" placeholder=" nombre de usuario">
        </div>
        <div class="container-input">
            <input type="text" name="name" placeholder=" nombres">
            <input type="text" name="lastName" placeholder=" apellidos">
        </div>
        <div class="container-input">
            <input type="password" name="password" placeholder=" contraseña">
            <input type="password" name="confirmPassword" placeholder=" confirmar contraseña">
        </div>
        <div class="container-input">
            <select name="role">
                <option value="...">role...</option>
            </select>
            <select name="gender">
                <option value="...">género...</option>
            </select>
        </div>
        <input type="submit" name="send" value="Añadir">
    </div>
</form>