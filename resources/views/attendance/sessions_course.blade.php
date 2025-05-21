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
                                          <button type="submit" title="Archive Session" class="text-blue-500 hover:text-blue-700">
                                              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h18v3H3z" />
                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14v12H5z" />
                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l3 3 3-3m-3 3V9" />
                                              </svg>
                                          </button>
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
