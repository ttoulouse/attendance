<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manage Students for {{ $course->course_title }}
        </h2>
    </x-slot>

    <div class="py-12">
       <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <!-- Current Students -->
          <div class="bg-white shadow-sm sm:rounded-lg p-6">
              <h3 class="text-2xl font-bold mb-4">Manage Students</h3>
              @if($students->isNotEmpty())
                  <ul class="divide-y divide-gray-200">
                      @foreach($students as $student)
                          <li class="py-2 flex items-center justify-between">
                              <span>
                                  {{ $student->last_name }}, {{ $student->first_name }}
                              </span>
                              <div class="flex space-x-2">
                                  <!-- Edit Button -->
                                  <a href="{{ route('students.edit', [$course->id, $student->id]) }}"
                                     title="Edit Student"
                                     class="text-blue-500 hover:text-blue-700">
                                      <!-- Pencil Icon -->
                                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                           viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536M9 11l3 3L21 7l-3-3L9 11zm0 0L5 15v4h4l4-4"/>
                                      </svg>
                                  </a>

                                  <!-- Delete Button -->
                                  <form method="POST" action="{{ route('students.destroy', [$course->id, $student->id]) }}"
                                        onsubmit="return confirm('Are you sure you want to remove this student?');">
                                      @csrf
                                      @method('DELETE')
                                      <button type="submit" title="Delete Student"
                                              class="text-red-500 hover:text-red-700">
                                          <!-- Red X Icon -->
                                          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                               viewBox="0 0 24 24" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"/>
                                          </svg>
                                      </button>
                                  </form>
                              </div>
                          </li>
                      @endforeach
                  </ul>
              @else
                  <p>No students found.</p>
              @endif
          </div>

          <!-- Add New Students Form -->
          <div class="bg-white shadow-sm sm:rounded-lg p-6 mt-6">
              <h3 class="text-xl font-bold mb-4">Add Students</h3>
              <p class="text-sm text-gray-600 mb-2">
                  Paste a list of students, one per line, in the format <strong>LastName FirstName</strong>.
              </p>
              <form method="POST" action="{{ route('students.store', $course->id) }}">
                  @csrf
                  <textarea name="student_names" rows="5"
                            class="border rounded w-full p-2 mb-4"
                            placeholder="Smith John&#10;Doe Jane&#10;Jackson Michael"></textarea>
                  <button type="submit"
                          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                      Add Students
                  </button>
              </form>
          </div>
       </div>
    </div>
</x-app-layout>
