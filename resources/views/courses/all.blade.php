<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Course Management
        </h2>
    </x-slot>

    <div class="py-12">
       <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          @if(session('status'))
              <div class="mb-4 text-green-600 font-semibold">
                  {{ session('status') }}
              </div>
          @endif

          <div class="bg-white shadow-sm sm:rounded-lg p-6">
              <h3 class="text-2xl font-bold mb-4">All Courses</h3>
              @if($courses->isNotEmpty())
                  <ul class="divide-y divide-gray-200">
                      @foreach($courses as $course)
                          <li class="py-4 flex items-center justify-between">
                              <div>
                                  <div class="text-lg font-semibold">
                                      {{ $course->course_title }} 
                                      @if($course->trashed())
                                          <span class="text-red-500">(Deleted)</span>
                                      @endif
                                  </div>
                                  <div class="text-sm text-gray-600">
                                      Section: {{ $course->section_number }}
                                  </div>
                                  <div class="text-sm text-gray-600">
                                      Dates: {{ \Carbon\Carbon::parse($course->start_date)->format('M d, Y') }} -
                                      {{ \Carbon\Carbon::parse($course->end_date)->format('M d, Y') }}
                                  </div>
                              </div>
                              <div class="flex space-x-2">
                                  <!-- Edit Icon (pencil) -->
                                  @if(!$course->trashed())
                                  <a href="{{ route('courses.edit', $course->id) }}"
                                     title="Edit Course"
                                     class="text-blue-500 hover:text-blue-700">
                                      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                           viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5h6m-3-3v6m-4 8h6m-3 3v-6M3 13h4m-4-4h4m-4 8h4" />
                                      </svg>
                                  </a>
                                  @endif

                                  <!-- Delete Icon (red X) or Restore Icon if trashed -->
                                  @if(!$course->trashed())
                                  <form method="POST" action="{{ route('courses.destroy', $course->id) }}"
                                        onsubmit="return confirm('Are you sure you want to delete this course?');">
                                      @csrf
                                      @method('DELETE')
                                      <button type="submit" title="Delete Course"
                                              class="text-red-500 hover:text-red-700">
                                          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                               viewBox="0 0 24 24" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                          </svg>
                                      </button>
                                  </form>
                                  @else
                                  <form method="POST" action="{{ route('courses.restore', $course->id) }}">
                                      @csrf
                                      <button type="submit" title="Restore Course"
                                              class="text-green-500 hover:text-green-700">
                                          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                               viewBox="0 0 24 24" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 10h4v4H3zM7 14h10V4H7zM17 14h4v4h-4z" />
                                          </svg>
                                      </button>
                                  </form>
                                  @endif
                              </div>
                          </li>
                      @endforeach
                  </ul>
              @else
                  <p>No courses found.</p>
              @endif
          </div>
       </div>
    </div>
</x-app-layout>
