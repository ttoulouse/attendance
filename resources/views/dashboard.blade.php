<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!-- Main Content -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Status Message -->
            @if(session('status'))
                <div class="mb-4 text-green-600 font-semibold">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Card for Active Courses -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">Active Courses</h3>

                    @if($courses->isNotEmpty())
                        <ul class="divide-y divide-gray-200">
                            @foreach($courses as $course)
                                @php
                                    // Retrieve today's attendance session for this course (if any)
                                    $todaySession = $course->attendanceSessions()
                                        ->whereDate('session_date', now()->toDateString())
                                        ->first();
                                @endphp

                                <li class="py-4 sm:flex sm:items-center sm:justify-between">
                                    <!-- Course Info -->
                                    <div>
                                        <div class="text-lg font-semibold">{{ $course->course_title }}</div>
                                        <div class="text-sm text-gray-600">
                                            Section: {{ $course->section_number }}
                                        </div>
                                        <div class="text-sm text-gray-600">
                                            Dates:
                                            {{ \Carbon\Carbon::parse($course->start_date)->format('M d, Y') }}
                                            -
                                            {{ \Carbon\Carbon::parse($course->end_date)->format('M d, Y') }}
                                        </div>
                                    </div>

                                    <!-- Magic Word Area -->
                                    <div class="mt-2 sm:mt-0 flex items-center space-x-4">
                                        @if($todaySession)
                                            <span class="text-green-600 font-bold whitespace-nowrap">
                                                Current Word: {{ $todaySession->magic_word }}
                                            </span>
                                        @else
                                            <span class="text-gray-500 whitespace-nowrap">
                                                Word not set for today
                                            </span>
                                        @endif

                                        <!-- Form to set/update the magic word for today -->
                                        <form method="POST"
                                              action="{{ route('attendance.setMagicWord', $course->id) }}"
                                              class="flex items-center space-x-2">
                                            @csrf
                                            <input type="text"
                                                   name="magic_word"
                                                   placeholder="Enter word"
                                                   class="border rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                                                   required>
                                            <button type="submit"
                                                    class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-1 px-3 rounded focus:outline-none focus:ring-2 focus:ring-blue-300">
                                                Set
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No active courses found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
