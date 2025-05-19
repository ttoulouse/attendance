<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Attendance Alerts for {{ $course->course_title }}
        </h2>
    </x-slot>

    <div class="py-12">
       <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white shadow-sm sm:rounded-lg p-6">
              @if($alerts->isNotEmpty())
                  <table class="min-w-full divide-y divide-gray-200">
                      <thead>
                          <tr>
                              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Attended</th>
                              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Missed</th>
                          </tr>
                      </thead>
                      <tbody class="bg-white divide-y divide-gray-200">
                          @foreach($alerts as $alert)
                              <tr>
                                  <td class="px-6 py-4 whitespace-nowrap">
                                      {{ $alert['student']->last_name }}, {{ $alert['student']->first_name }}
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap">
                                      {{ $alert['attended'] }}
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap">
                                      {{ $alert['missed'] }}
                                  </td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
              @else
                  <p>No alerts found for this course.</p>
              @endif
          </div>
       </div>
    </div>
</x-app-layout>

