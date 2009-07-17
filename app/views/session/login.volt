{{ content() }}

<div align="center" class="well">

    {{ form('class': 'form-search') }}

    <div align="left">
        <h2>Log In</h2>
    </div>

    {{ form.render('player') }}
    {{ form.render('password') }}
    {{ form.render('go') }}

    <div align="center" class="remember">
        <label class="checkbox">
            {{ form.render('remember') }}
            Remeber me!
        </label>
    </div>

    {{ form.render('csrf', ['value': security.getToken()]) }}

    <hr>

    <div class="forgot">
        {{ link_to("session/forgotPassword", "Forgot my password") }}
    </div>

    </form>

</div>