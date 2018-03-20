@component('mail::message')
# Last step

You must confirm your email to prove that you are human.

@component('mail::button', ['url' => route('user.confirm') . "?token={$user->confirmation_token}"])
Confirm
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
