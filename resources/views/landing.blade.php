<x-guest-layout>
    <!-- Main Content -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Top Bar: App Name and Login Link -->
            <div class="mb-6 flex justify-between items-center">
                <h2 class="font-semibold text-2xl text-gray-800">
                    {{ config('app.name', 'Psylobby') }}
                </h2>
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline text-lg">
                    Login
                </a>
            </div>
            <!-- Active Courses List -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-2xl font-bold mb-4">Active Courses</h3>
                @if($courses->isNotEmpty())
                    <ul class="divide-y divide-gray-200">
                        @foreach($courses as $course)
                            <li class="py-4">
                                <a href="{{ route('attendance.checkin.form', $course->id) }}"
                                   class="text-lg font-semibold text-blue-600 hover:underline">
                                    {{ $course->course_title }}
                                </a>
                                <div class="text-sm text-gray-600">
                                    Section: {{ $course->section_number }}
                                </div>
                                <div class="text-sm text-gray-600">
                                    Dates:
                                    {{ \Carbon\Carbon::parse($course->start_date)->format('M d, Y') }} -
                                    {{ \Carbon\Carbon::parse($course->end_date)->format('M d, Y') }}
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
</x-guest-layout>
