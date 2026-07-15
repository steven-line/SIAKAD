<!DOCTYPE html>
<html lang="en" data-theme="fantasy">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    @vite('resources/css/app.css')
</head>
<body class="flex justify-center items-center h-screen">

  <form class="w-full max-w-xs" action="/login" method="POST">
    @csrf

    <fieldset class="fieldset bg-base-200 border-base-300 rounded-box p-6 shadow-lg">
        
        @error('aktif')
        <div class="alert alert-error mb-4 text-center justify-center">
            <span>{{ $message }}</span>
        </div>
        @enderror
        
        <label class="label font-bold" for="username">Username</label>
        <input type="text" class="input w-full" name="username" placeholder="Username/NRP" value="{{ old('username') }}" />
        <x-forms.error name="username"/>

        <label class="label font-bold">Password</label>
        <input type="password" class="input w-full" name="password" placeholder="Password" value="{{ old('password') }}"/>
        <x-forms.error name="password"/>

        <button class="btn btn-primary mt-4 w-full">Login</button>

    </fieldset>

  </form>

</body>
</html>