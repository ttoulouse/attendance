<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Sessions for {{ $course->course_title }}
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
              @if($sessions->isNotEmpty())
                  <table class="min-w-full divide-y divide-gray-200">
                      <thead>
                          <tr>
                              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Magic Word</th>
                              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                          </tr>
                      </thead>
                      <tbody class="bg-white divide-y divide-gray-200">
                          @foreach($sessions as $session)
                              <tr>
                                  <td class="px-6 py-4 whitespace-nowrap">
                                      {{ $session->session_date->format('M d, Y') }}
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap">
                                      {{ $session->magic_word }}
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap">
                                      <form method="POST" action="{{ route('attendance.sessions.archive', [$course->id, $session->id]) }}">
                                          @csrf
                                          <button type="submit" class="text-blue-600 hover:underline">Archive</button>
                                      </form>
                                  </td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
              @else
                  <p>No attendance sessions found for this course.</p>
              @endif
          </div>
       </div>
    </div>
</x-app-layout>
