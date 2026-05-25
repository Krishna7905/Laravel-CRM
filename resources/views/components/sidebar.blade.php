<div class="w-64 bg-indigo-700 text-white flex flex-col">

    <div class="p-6 text-2xl font-bold border-b border-indigo-600">
        SmartCRM
    </div>

   <nav class="flex-1 p-4 space-y-2">

<a href="{{ route('dashboard') }}" class="block p-2 hover:bg-indigo-600 rounded">
Dashboard
</a>

<a href="{{ route('leads.index') }}" class="block p-2 hover:bg-indigo-600 rounded">
Leads
</a>

<a href="{{ route('contacts.index') }}" class="block p-2 hover:bg-indigo-600 rounded">
Contacts
</a>

<a href="{{ route('deals.index') }}" class="block p-2 hover:bg-indigo-600 rounded">
Deals
</a>

<a href="{{ route('tasks.index') }}" class="block p-2 hover:bg-indigo-600 rounded">
Tasks
</a>

</nav>

</div>