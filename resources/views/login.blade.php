<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-RAPOR | Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(180deg, #f5f5f5 0%, #f5f5f5 100%);
        }
        .card-shadow {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }
        .icon-circle {
            background: #e0edff;
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen">

    <div class="flex w-[1000px] max-w-full overflow-hidden">

        <!-- LEFT SIDE -->
        <div class="w-1/2 p-10 flex flex-col justify-center">
            
            <!-- Logo -->
            <div class="flex items-center space-x-2 mb-8">
                <div class="icon-circle w-10 h-10 rounded-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.847.564 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h1 class="text-xl font-semibold text-blue-700">E-RAPOR</h1>
            </div>

            <!-- Login Title -->
            <h2 class="text-2xl font-semibold text-blue-700 mb-6 text-center">Login</h2>

           
            @if (session('error'))
                <div style="background: #ffb3b3; padding: 10px; margin-bottom: 10px; border-radius: 4px;">
                    {{ session('error') }}
                </div>
            @endif


            <!-- Form -->
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                <div class="relative">
                    <span class="absolute left-4 top-2.5 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.847.564 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </span>
                    <input type="text" name="username" placeholder="Username"
                        class="w-full border border-gray-300 rounded-full pl-11 pr-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none text-gray-700">
                </div>

                <div class="relative">
                    <span class="absolute left-4 top-2.5 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 11c0-1.104-.896-2-2-2s-2 .896-2 2v4a2 2 0 104 0v-4zM17 11v4a2 2 0 104 0v-4a2 2 0 10-4 0z"/>
                        </svg>
                    </span>
                    <input type="password" name="password" placeholder="Password"
                        class="w-full border border-gray-300 rounded-full pl-11 pr-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none text-gray-700">
                </div>

                <!-- Role -->
                <div class="flex flex-col items-center mt-4">
                    <span class="text-gray-600 text-sm mb-2 text-center">Role</span>

                    <!-- Bungkus label dalam flex-row -->
                    <div class="flex flex-row justify-center items-center space-x-6">
                        <label class="inline-flex items-center space-x-2 text-sm text-gray-600">
                            <input type="radio" name="role" value="admin" class="accent-blue-600" required>
                            <span>Admin</span>
                        </label>

                        <label class="inline-flex items-center space-x-2 text-sm text-gray-600">
                            <input type="radio" name="role" value="guru" class="accent-blue-600" required>
                            <span>Guru</span>
                        </label>
                    </div>
                </div>


                <!-- Button -->
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-full py-2 mt-4 transition">
                    Login
                </button>
            </form>
        </div>

        <!-- RIGHT SIDE ILLUSTRATION -->
        <div class="w-1/2 flex items-center justify-center">
            <img src="{{ asset('images/login-illustration.jpg') }}" 
            alt="Login Illustration" 
            class="w-[100%]">
        </div>
    </div>

    <footer class="absolute bottom-2 w-full text-center text-gray-400 text-xs">
        © {{ date('Y') }} E-RAPOR. All rights reserved.
    </footer>

</body>
</html>
