<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm card sm:rounded-lg">
                <div class="text-gray-900 card-body">
                    <h2 class="mb-4 text-3xl text-violet-600">Welcome to Your Dashboard</h2>

                    <div class="grid grid-cols-1 gap-6 mt-6 md:grid-cols-3">
                        <div class="p-4 rounded-md shadow-sm bg-green-50">
                            <h4 class="font-medium text-green-600">Statistics</h4>
                            <p class="mt-2 text-gray-500">View your account statistics and performance metrics.</p>
                            <button class="mt-4 text-white bg-green-500 btn hover:bg-green-600">View Stats</button>
                        </div>

                        <div class="p-4 rounded-md shadow-sm bg-sky-50">
                            <h4 class="font-medium text-sky-600">Reports</h4>
                            <p class="mt-2 text-gray-500">Generate and download various account reports.</p>
                            <button class="mt-4 text-white btn bg-sky-500 hover:bg-sky-600">View Reports</button>
                        </div>

                        <div class="p-4 rounded-md shadow-sm bg-yellow-50">
                            <h4 class="font-medium text-yellow-600">Settings</h4>
                            <p class="mt-2 text-gray-500">Manage your account settings and preferences.</p>
                            <button class="mt-4 text-white bg-yellow-500 btn hover:bg-yellow-600">Settings</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
