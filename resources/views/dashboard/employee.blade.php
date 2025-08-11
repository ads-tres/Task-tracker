
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Employee Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Your Tasks</h3>

                {{-- Fileter tasks --}}
                <form method="GET" action="{{ route('dashboard') }}" class="mb-4">
                    <label for="filter" class="text-sm text-gray-700 dark:text-gray-300">Filter by status:</label>
                    <select name="status" id="filter"
                        onchange="this.form.submit()"
                        class="ml-2 rounded-md dark:bg-gray-700 dark:text-white border-gray-300 dark:border-gray-600">
                        <option value="">All</option>
                        <option value="Not Started" {{ request('status') === 'Not Started' ? 'selected' : '' }}>Not Started</option>
                        <option value="In Progress" {{ request('status') === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="Completed" {{ request('status') === 'Completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </form>
                

                @if ($tasks->isEmpty())
                    <p class="text-gray-600 dark:text-gray-300">You have no assigned tasks yet.</p>
                @else
                    <ul class="space-y-4">
                        @foreach ($tasks as $task)
                            <li class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-900">
                                <h4 class="text-md font-bold text-gray-900 dark:text-white">{{ $task->title }}

                                    {{--status --}}

                                @php
                                $badgeColor = match ($task->status) {
                                'Completed' => 'bg-green-600',
                                'In Progress' => 'bg-yellow-500',
                                'Not Started' => 'bg-red-600',
                                 default => 'bg-gray-600',
                                   };
                                @endphp

                                <span class="inline-block px-3 py-1 text-xs font-semibold text-white rounded-full {{ $badgeColor }}">
                                {{ $task->status }}
                                </span>
                                </h4>
                                <p class="text-gray-700 dark:text-gray-300">{{ $task->description }}</p>
                                {{-- takes the task's deadline date and formats it into a human-readable string --}}                            
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    Deadline: {{ \Carbon\Carbon::parse($task->deadline)->toFormattedDateString() }}
                                </p>
                                
                                <!-- Deadline alert -->
                                @php
                                    $today = \Carbon\Carbon::today();
                                    $deadline = \Carbon\Carbon::parse($task->deadline);
                                @endphp
                                
                                @if ($deadline->isToday())
                                    <p class="mt-2 text-sm font-semibold text-yellow-400"> Deadline is today!</p>
                                @elseif ($deadline->isPast())
                                    <p class="mt-2 text-sm font-semibold text-red-500"> Task is overdue!</p>
                                @endif
                                
                                
                                {{-- priority --}}
                        <p class="text-sm mt-1 text-gray-500 dark:text-gray-400">
                            Priority: 
                            <span class="
                                @if ($task->priority === 'High') text-red-500
                                @elseif ($task->priority === 'Medium') text-yellow-500
                                @else text-green-500 @endif
                                font-semibold
                            ">
                                {{ $task->priority }}
                            </span>
                        </p>

                        {{-- time spent --}}
                        <p class="text-sm text-gray-400 dark:text-gray-400 mt-1">
                            Time Spent: {{ $task->time_spent ?? 0 }} min
                        </p>
                        
                        <!-- Allow input if task is not completed -->
                        @if ($task->status !== 'Completed')
                            <form method="POST" action="{{ route('tasks.logTime', $task->id) }}" class="mt-2">
                                @csrf
                                @method('PATCH')
                        
                                <label for="time_spent" class="text-sm text-gray-700 dark:text-gray-300">Log Time (in minutes):</label>
                                <input type="number" name="time_spent" value="{{ $task->time_spent ?? 0 }}"
                                       class="w-24 ml-2 rounded-md dark:bg-gray-700 dark:text-white border-gray-300 dark:border-gray-600" />
                        
                                <button type="submit"
                                        class="ml-2 px-3 py-1 text-sm bg-indigo-600 hover:bg-indigo-700 text-white rounded">
                                    Save
                                </button>
                            </form>
                        @endif
                        
                        {{-- feedback --}}
                        @if ($task->feedback)
                        <p class="mt-2 text-sm text-green-400"> Feedback: {{ $task->feedback }}</p>
                        @endif
                            
                                               

                        {{-- status update --}}
                        @if ($task->status !== 'Completed')
                        <form method="POST" action="{{ route('tasks.updateStatus', $task->id) }}" class="mt-2">
                         @csrf
                         @method('PATCH')

                         <label for="status" class="text-sm text-gray-700 dark:text-gray-300">Update Status:</label>
                         <select name="status" class="mt-1 rounded-md dark:bg-gray-700 dark:text-white border-gray-300 dark:border-gray-600">
                         <option {{ $task->status === 'Not Started' ? 'selected' : '' }}>Not Started</option>
                         <option {{ $task->status === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                         <option {{ $task->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                         </select>
                         <button type="submit" class="ml-2 px-3 py-1 text-sm bg-green-600 hover:bg-green-700 text-white rounded">
                                Update
                         </button>
                         </form>
                         @endif 

                            </li>                          
                            
                            
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
