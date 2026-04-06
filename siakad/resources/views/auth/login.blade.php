<!DOCTYPE html>
<html lang="en" data-theme="fantasy">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    @vite('resources/css/app.css')
</head>
<body>
  <form class="flex items-center h-screen"action="/login" method="POST">
    @csrf
    <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs h-64 sborder p-4 mx-auto">

        <label class="label font-bold" for="username">Username</label>
        <input type="text" class="input" name="username" placeholder="Username/NRP" />
        <x-forms.error name="username"/>
        <label class="label font-bold">Password</label>
        <input type="password" class="input" name="password" placeholder="Password" />
        <x-forms.error name="password"/>
        <button class="btn btn-primary mt-4">Login</button>
  </fieldset>

  </form>
  

</body>
</html>