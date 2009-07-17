{{ content() }}

<div align="center">

    {{ form('class': 'form-search') }}

    <div align="left">
        <h2>Sign Up</h2>
    </div>
    {{ form.render('inviter') }}
    <table class="signup">
        <tr>
            <td align="right">{{ form.label('player') }}</td>
            <td>
                {{ form.render('player') }}
                {{ form.messages('player') }}
            </td>
        </tr>
        <tr>
            <td align="right">{{ form.label('name') }}</td>
            <td>
                {{ form.render('name') }}
                {{ form.messages('name') }}
            </td>
        </tr>
        <tr>
            <td align="right">{{ form.label('email') }}</td>
            <td>
                {{ form.render('email') }}
                {{ form.messages('email') }}
            </td>
        </tr>
        <tr>
            <td align="right">{{ form.label('password') }}</td>
            <td>
                {{ form.render('password') }}
                {{ form.messages('password') }}
            </td>
        </tr>
        <tr>
            <td align="right">{{ form.label('confirmPassword') }}</td>
            <td>
                {{ form.render('confirmPassword') }}
                {{ form.messages('confirmPassword') }}
            </td>
        </tr>
        <tr>
            <td align="right">{{ form.label('location') }}</td>
            <td>
                {{ form.render('location') }}
                {{ form.messages('location') }}
            </td>
        </tr>
        <tr>
            <td align="right"></td>
            <td>
                {{ form.render('terms') }} {{ form.label('terms') }}
                {{ form.messages('terms') }}
            </td>
        </tr>
        <tr>
            <td align="right"></td>
            <td>{{ form.render('Sign Up') }}</td>
        </tr>
    </table>


    <hr>

    </form>

</div>