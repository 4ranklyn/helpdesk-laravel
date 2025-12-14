<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <h3 class="text-lg font-bold mb-2">User Status</h3>
                        
                        @role('Super Admin')
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                                <span class="font-medium">Role: Super Admin</span>
                                <div class="mt-1">You have full access to all units and system settings.</div>
                            </div>
                        @endrole

                        @role('Admin Unit')
                            <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50" role="alert">
                                <span class="font-medium">Role: Unit Administrator</span>
                                <div class="mt-1">
                                    You manage tickets for: <strong>{{ auth()->user()->unit->name ?? 'No Unit Assigned' }}</strong>
                                </div>
                            </div>
                        @endrole

                        @role('Staff Unit')
                             <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                                <span class="font-medium">Role: Unit Staff</span>
                                <div class="mt-1">
                                    Unit: <strong>{{ auth()->user()->unit->name ?? 'No Unit Assigned' }}</strong>
                                </div>
                            </div>
                        @endrole
                        
                        @unlessrole('Super Admin|Admin Unit|Staff Unit')
                            <div class="p-4 mb-4 text-sm text-gray-800 rounded-lg bg-gray-50" role="alert">
                                <span class="font-medium">Role: User</span>
                            </div>
                        @endunlessrole
                    </div>

                    <div class="border-t pt-4">
                        {{ __("You're logged in!") }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
