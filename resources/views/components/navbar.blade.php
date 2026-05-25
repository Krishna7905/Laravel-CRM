<div class="bg-white shadow px-6 py-4 flex justify-between items-center">

    <div class="text-lg font-semibold">
        Dashboard
    </div>

    <div class="flex items-center gap-4">
        <span>{{ Auth::user()->name }}</span>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="text-red-500 hover:underline">
                Logout
            </button>
        </form>
    </div>

</div>