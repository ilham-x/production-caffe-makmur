```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neo Brutalism Login</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-pink-200 flex items-center justify-center p-6">

    <form action="#" method="POST"
          class="w-full max-w-md p-6 bg-yellow-300 border-4 border-black shadow-[10px_10px_0px_black] -rotate-1">

        <h1 class="text-3xl font-extrabold uppercase text-center mb-6">
            Login
        </h1>

        <!-- Email -->
        <div>
            <label class="block font-extrabold uppercase mb-2">
                Email
            </label>

            <input
                type="email"
                placeholder="Masukkan email"
                required
                class="w-full p-3 border-4 border-black bg-white font-bold shadow-[5px_5px_0px_black] focus:outline-none">
        </div>

        <!-- Password -->
        <div class="mt-6">
            <label class="block font-extrabold uppercase mb-2">
                Password
            </label>

            <input
                type="password"
                placeholder="Masukkan password"
                required
                class="w-full p-3 border-4 border-black bg-white font-bold shadow-[5px_5px_0px_black] focus:outline-none">
        </div>

        <!-- Remember -->
        <div class="mt-6 flex items-center">
            <input
                type="checkbox"
                class="w-5 h-5 border-4 border-black">

            <span class="ml-3 font-extrabold uppercase">
                Remember Me
            </span>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between mt-8">
            <a href="#"
               class="font-bold underline border-2 border-black px-3 py-2 bg-green-200 hover:bg-black hover:text-white transition">
                Forgot?
            </a>

            <button
                type="submit"
                class="px-6 py-3 bg-green-500 border-4 border-black font-extrabold shadow-[5px_5px_0px_black]
                       hover:translate-x-[3px]
                       hover:translate-y-[3px]
                       hover:shadow-none
                       transition-all">
                LOGIN
            </button>
        </div>

    </form>

</body>
</html>
```
