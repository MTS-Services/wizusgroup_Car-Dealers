<dialog id="my_modal_1" class="modal">
    <div class="modal-box max-w-3xl p-6 rounded-2xl shadow-lg bg-white">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-2xl font-bold text-gray-800">Welcome Back!</h3>
            <form method="dialog">
                <button class="text-gray-500 hover:text-gray-700 transition duration-200">&times;</button>
            </form>
        </div>

        <div class="grid gap-4 md:grid-cols-1 text-center">
            {{-- USER --}}
            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                <h4 class="text-lg font-semibold text-indigo-700 mb-2">User Access</h4>
                @auth('web')
                    <a href="{{ route('user.profile') }}"
                        class="btn btn-primary w-full bg-amber-600 hover:bg-amber-700 text-white">Go to Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn w-full bg-indigo-600 hover:bg-indigo-700 text-white">Login</a>
                    <a href="{{ route('register') }}"
                        class="btn w-full mt-2 bg-emerald-600 hover:bg-emerald-700 text-white">Register</a>
                @endauth
            </div>

            {{-- ADMIN --}}
            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                <h4 class="text-lg font-semibold text-rose-600 mb-2">Admin Access</h4>
                @auth('admin')
                    <a href="{{ route('admin.dashboard') }}"
                        class="btn w-full bg-rose-600 hover:bg-rose-700 text-white">Admin Dashboard</a>
                @else
                    <a href="{{ route('admin.login') }}"
                        class="btn w-full bg-purple-600 hover:bg-purple-700 text-white">Admin Login</a>
                @endauth
            </div>
        </div>
    </div>
</dialog>
