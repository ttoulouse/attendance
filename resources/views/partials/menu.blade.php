<!-- resources/views/partials/menu.blade.php -->
<nav class="bg-gray-100 border-b border-gray-200">
    <div class="container mx-auto px-4 py-4">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Class Setup</h2>
            </div>
            <ul class="flex space-x-6">
                <li>
                    <a href="{{ route('courses.create') }}"
                       class="text-gray-700 hover:text-gray-900">
                        Create Course
                    </a>
                </li>
                <li>
                    <a href="{{ route('students.index') }}"
                       class="text-gray-700 hover:text-gray-900">
                        Student Management
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
