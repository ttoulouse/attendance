<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Check-In for {{ $course->course_title }}
        </h2>
    </x-slot>

    <div class="py-12">
      <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
          @if(session('status'))
              <div class="mb-4 text-green-600 font-semibold">
                  {{ session('status') }}
              </div>
          @endif

          @if($errors->any())
              <div class="mb-4">
                  <ul class="list-disc list-inside text-red-600">
                      @foreach($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif

          <div class="bg-white shadow-sm sm:rounded-lg p-6">
              <form method="POST" action="{{ route('attendance.checkin.submit', $course->id) }}">
                  @csrf
                  <div class="mb-4">
                      <label for="first_name" class="block text-gray-700 font-bold mb-2">First Name:</label>
                      <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}"
                             class="border rounded w-full p-2" required>
                  </div>
                  <div class="mb-4">
                      <label for="last_name" class="block text-gray-700 font-bold mb-2">Last Name:</label>
                      <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}"
                             class="border rounded w-full p-2" required>
                  </div>
                  <div class="mb-4">
                      <label for="magic_word" class="block text-gray-700 font-bold mb-2">Magic Word:</label>
                      <input type="text" name="magic_word" id="magic_word" value="{{ old('magic_word') }}"
                             class="border rounded w-full p-2" required>
                  </div>
                  <button type="submit"
                          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                      Check In
                  </button>
              </form>
          </div>
      </div>
    </div>
</x-guest-layout>
