<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Attendance for {{ $course->course_title }} on {{ $session->session_date->format('M d, Y') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if(session('status'))
                    <div class="mb-4 text-green-600 font-semibold">
                        {{ session('status') }}
                    </div>
                @endif
                @if($students->isNotEmpty())
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($students as $student)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $student->last_name }}, {{ $student->first_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($records->has($student->id))
                                            Checked In
                                        @else
                                            Not Checked In
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form method="POST" action="{{ route('attendance.sessions.toggle', [$course->id, $session->id, $student->id]) }}">
                                            @csrf
                                            <button type="submit" class="text-blue-500 hover:text-blue-700">
                                                @if($records->has($student->id))
                                                    Check Out
                                                @else
                                                    Check In
                                                @endif
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No students found for this course.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
