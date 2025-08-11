<x-app-layout> 
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Assign new task --}}
            <a 
            href="{{ route('tasks.create') }}" 
            class="inline-block mb-6 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
            >
                 Assign New Task
            </a>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-blue-600 text-white p-4 rounded-lg shadow">
                    <h3 class="text-lg font-semibold">Due Today</h3>
                    <p class="text-2xl">{{ $tasksDueToday }}</p>
                </div>
                <div class="bg-green-600 text-white p-4 rounded-lg shadow">
                    <h3 class="text-lg font-semibold">Completed Today</h3>
                    <p class="text-2xl">{{ $tasksCompletedToday }}</p>
                </div>
                <div class="bg-red-600 text-white p-4 rounded-lg shadow">
                    <h3 class="text-lg font-semibold">Overdue Tasks</h3>
                    <p class="text-2xl">{{ $tasksOverdue }}</p>
                </div>
            </div>

            {{-- Filter Form --}}
            <form method="GET" class="mb-6 flex flex-wrap gap-4 text-sm">
                <select name="status" class="dark:bg-gray-800 dark:text-white border-gray-300 dark:border-gray-600 p-2 rounded">
                    <option value="">All Statuses</option>
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                </select>

                <select name="priority" class="dark:bg-gray-800 dark:text-white border-gray-300 dark:border-gray-600 p-2 rounded">
                    <option value="">All Priorities</option>
                    <option value="High" {{ request('priority') == 'High' ? 'selected' : '' }}>High</option>
                    <option value="Medium" {{ request('priority') == 'Medium' ? 'selected' : '' }}>Medium</option>
                    <option value="Low" {{ request('priority') == 'Low' ? 'selected' : '' }}>Low</option>
                </select>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Filter
                </button>
            </form>

            {{-- Task List --}}
            <div class="space-y-4">
                @foreach ($tasks as $task)
    <div x-data="{ open: false }" class="bg-gray-100 dark:bg-gray-700 p-4 rounded shadow mb-4">
        <div class="flex justify-between items-center mb-2">
            <h4 class="text-lg font-bold text-gray-900 dark:text-white">{{ $task->title }}</h4>
            <span class="text-sm px-2 py-1 rounded 
                @if ($task->status === 'Completed') bg-green-500 text-white 
                @elseif ($task->status === 'In Progress') bg-yellow-400 text-black 
                @else bg-red-500 text-white @endif">
                {{ $task->status }}
            </span>
        </div>

        <p class="text-sm text-gray-700 dark:text-gray-300 mb-2">
            Assigned to: <strong>{{ $task->employee->name }}</strong><br>
            Priority: <strong>{{ $task->priority }}</strong><br>
            Deadline: <strong>{{ \Carbon\Carbon::parse($task->deadline)->toFormattedDateString() }}</strong>
        </p>

        <button @click="open = !open" class="text-blue-600 dark:text-blue-400 flex items-center text-sm">
            <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span x-text="open ? 'Hide' : 'View Description'"></span>
        </button>

        <div x-show="open" x-transition class="mt-2 text-gray-800 dark:text-gray-200">
            <p>{{ $task->description }}</p>
        </div>

        @if ($task->status === 'Completed')
            <form method="POST" action="{{ route('tasks.feedback', $task->id) }}" class="mt-3">
                @csrf
                @method('PATCH')
                <label for="feedback" class="text-sm text-gray-700 dark:text-gray-300">Give Feedback:</label>
                <textarea name="feedback"
                          class="w-full mt-1 p-2 rounded-md dark:bg-gray-800 dark:text-white border-gray-300 dark:border-gray-600"
                          rows="2">{{ $task->feedback }}</textarea>

                <button type="submit" class="mt-2 px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded">
                    Save Feedback
                </button>
            </form>
        @endif
    </div>
@endforeach

            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $tasks->withQueryString()->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
