<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
       <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white shadow-sm sm:rounded-lg p-6">
              <h3 class="text-2xl font-bold mb-4">Active Courses</h3>
              @if($courses->isNotEmpty())
                  <ul class="divide-y divide-gray-200">
                      @foreach($courses as $course)
                          <li class="py-4">
                              <!-- Link to the course's student list -->
                                <a href="{{ route('students.showForCourse', $course->id) }}"
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
</x-app-layout>
