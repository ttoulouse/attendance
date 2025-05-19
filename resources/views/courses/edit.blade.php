<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Course: {{ $course->course_title }}
        </h2>
    </x-slot>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
         <div class="bg-white shadow-sm sm:rounded-lg p-6">
            @if ($errors->any())
                <div class="mb-4">
                    <ul class="list-disc list-inside text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('courses.update', $course->id) }}">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label for="course_title" class="block text-gray-700 font-bold mb-2">Course Title:</label>
                    <input type="text" name="course_title" id="course_title" value="{{ old('course_title', $course->course_title) }}"
                           class="border rounded w-full p-2" required>
                </div>

                <div class="mb-4">
                    <label for="section_number" class="block text-gray-700 font-bold mb-2">Section Number:</label>
                    <input type="text" name="section_number" id="section_number" value="{{ old('section_number', $course->section_number) }}"
                           class="border rounded w-full p-2" required>
                </div>

                <div class="mb-4">
                    <label for="start_date" class="block text-gray-700 font-bold mb-2">Start Date:</label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $course->start_date->format('Y-m-d')) }}"
                           class="border rounded w-full p-2" required>
                </div>

                <div class="mb-4">
                    <label for="end_date" class="block text-gray-700 font-bold mb-2">End Date:</label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $course->end_date->format('Y-m-d')) }}"
                           class="border rounded w-full p-2" required>
                </div>

                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Update Course
                </button>
            </form>
         </div>
      </div>
    </div>
</x-app-layout>
