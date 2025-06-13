<div class="p-6">

    <h1 class="mb-4 text-2xl font-bold text-gray-100">Event List</h1>
    <!-- Search and Filter Row -->
    <div class="flex justify-between gap-4 mb-6">
        <!-- Search Input (Left) -->
        <div class="relative flex-1 max-w-md">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <i class="w-4 h-4 text-gray-400 fas fa-search"></i>
            </div>
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Search events..."
                class="w-full py-2.5 pl-10 pr-10 text-sm text-gray-100 placeholder-gray-400 bg-zinc-800/50 backdrop-blur-sm border border-zinc-700/50 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
            >

            <!-- Clear button when not loading -->
            @if($search)
                <button
                    wire:click="$set('search', '')"
                    wire:loading.remove
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 transition-colors duration-200 hover:text-gray-200"
                >
                    <i class="w-4 h-4 fas fa-times"></i>
                </button>
            @endif
        </div>

        <!-- Date Filter (Right, Smaller) -->
        <div class="flex p-1 space-x-1 border rounded-lg bg-zinc-800/50 backdrop-blur-sm border-zinc-700/50 sm:w-auto">
            <button
                wire:click="$set('dateFilter', 'all')"
                class="px-3 py-2 text-xs font-medium rounded-md transition-all duration-200 {{ $dateFilter === 'all' ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-400 hover:text-gray-200 hover:bg-zinc-700/50' }}"
            >
                All
            </button>
            <button
                wire:click="$set('dateFilter', 'upcoming')"
                class="px-3 py-2 text-xs font-medium rounded-md transition-all duration-200 {{ $dateFilter === 'upcoming' ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-400 hover:text-gray-200 hover:bg-zinc-700/50' }}"
            >
                Upcoming
            </button>
            <button
                wire:click="$set('dateFilter', 'past')"
                class="px-3 py-2 text-xs font-medium rounded-md transition-all duration-200 {{ $dateFilter === 'past' ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-400 hover:text-gray-200 hover:bg-zinc-700/50' }}"
            >
                Past
            </button>
        </div>
    </div>

    <!-- Events Grid -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        @forelse($events as $event)
            <div class="overflow-hidden transition-all duration-200 transform border rounded-lg shadow-lg bg-zinc-800/30 backdrop-blur-sm border-zinc-700/50 hover:border-zinc-600/70 hover:bg-zinc-800/40 hover:shadow-xl hover:-translate-y-1">
                        <!-- Event Image -->
                        <div class="relative aspect-[4/3] bg-zinc-700">
                            @if($event->image)
                                <img src="{{ Storage::url($event->image) }}" alt="{{ $event->name }}" class="object-cover w-full h-full">
                            @else
                                <div class="flex items-center justify-center w-full h-full">
                                    <i class="text-3xl text-zinc-500 bx bx-image"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Event Content -->
                        <div class="p-3">
                            <!-- Event Title -->
                            <h3 class="mb-2 text-sm font-semibold text-gray-100 line-clamp-2">
                                {{ $event->name }}
                            </h3>

                            <!-- Event Date -->
                            <div class="flex items-center mb-2 text-xs text-gray-400">
                                <i class="mr-1.5 bx bx-calendar text-blue-400"></i>
                                <span>{{ $event->start_date->format('M d, Y') }}</span>
                            </div>

                            <!-- Place -->
                            <div class="flex items-center mb-3 text-xs text-gray-400">
                                @if($event->location_type === 'physical')
                                    <i class="mr-1.5 bx bx-map-pin text-green-400 flex-shrink-0"></i>
                                    <span class="truncate-location">{{ $event->location_address ?: 'Physical Location' }}</span>
                                @else
                                    <i class="mr-1.5 bx bx-video text-purple-400 flex-shrink-0"></i>
                                    <span>Virtual Event</span>
                                @endif
                            </div>

                            <!-- Manage Event Button -->
                            <button
                                wire:click="edit({{ $event->id }})"
                                class="flex items-center justify-center gap-1.5 w-full px-3 py-1.5 text-xs font-medium text-white transition-all duration-200 bg-gradient-to-r from-blue-500 to-blue-600 rounded-md hover:from-blue-600 hover:to-blue-700 shadow-sm hover:shadow-md transform hover:-translate-y-0.5"
                            >
                                <i class="w-3 h-3 fas fa-cog"></i>
                                Manage
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="py-16 text-center border rounded-lg bg-zinc-800/20 backdrop-blur-sm border-zinc-700/50">
                            <div class="mb-6">
                                <i class="text-6xl text-zinc-600 bx bx-calendar"></i>
                            </div>
                            <h3 class="mb-3 text-xl font-semibold text-gray-100">
                                @if($search)
                                    No events found for "{{ $search }}"
                                @elseif($dateFilter === 'all')
                                    No events found
                                @elseif($dateFilter === 'upcoming')
                                    No upcoming events
                                @elseif($dateFilter === 'past')
                                    No past events
                                @else
                                    No events found
                                @endif
                            </h3>
                            <p class="text-gray-400">
                                @if($search)
                                    Try adjusting your search terms or filters.
                                @elseif($dateFilter === 'all')
                                    There are no events in the system yet.
                                @elseif($dateFilter === 'upcoming')
                                    No events are scheduled for the future.
                                @elseif($dateFilter === 'past')
                                    No events have occurred yet.
                                @else
                                    No events match your current filter criteria.
                                @endif
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($events->hasPages())
                <div class="mt-6">
                    <div class="p-4 border rounded-lg bg-zinc-800/30 backdrop-blur-sm border-zinc-700/50">
                        {{ $events->links() }}
                    </div>
                </div>
            @endif

    <!-- Event Details Modal -->
    @if($selectedEvent)
        <x-dynamic-modal
            :id="$modalId"
            :size="$modalSize"
            :title="$modalTitle"
            :save-label="$modalSaveLabel"
            :save-function="$modalSaveFunction"
            :cancel-function="$modalCancelFunction"
            :save-button-color="$modalSaveButtonColor"
            :is-open="$showModal">

            <div class="space-y-8">
                <!-- Event Header -->
                <div class="text-center">
                    @if($selectedEvent->image)
                        <div class="relative w-full h-56 mx-auto mb-6 overflow-hidden rounded-2xl">
                            <img src="{{ Storage::url($selectedEvent->image) }}" alt="{{ $selectedEvent->name }}" class="object-cover w-full h-full">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        </div>
                    @endif
                    <h2 class="mb-3 text-3xl font-bold text-transparent bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text dark:from-blue-400 dark:to-purple-400">{{ $selectedEvent->name }}</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400">Hosted by <span class="font-semibold text-blue-600 dark:text-blue-400">{{ $selectedEvent->host->name }}</span></p>
                </div>

                <!-- Event Info Grid -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Date & Time -->
                    <div class="p-6 border rounded-2xl bg-gradient-to-br from-blue-50/80 to-indigo-50/50 backdrop-blur-sm border-blue-200/30 dark:from-blue-900/30 dark:to-indigo-900/20 dark:border-blue-700/30">
                        <div class="flex items-center mb-4">
                            <i class="mr-3 text-2xl text-blue-600 bx bx-time dark:text-blue-400"></i>
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Date & Time</h4>
                        </div>
                        <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                            <div class="flex items-center">
                                <span class="w-12 font-medium text-green-600 dark:text-green-400">Start:</span>
                                <span class="ml-2">{{ $selectedEvent->start_date->format('M d, Y H:i') }}</span>
                            </div>
                            <div class="flex items-center">
                                <span class="w-12 font-medium text-red-600 dark:text-red-400">End:</span>
                                <span class="ml-2">{{ $selectedEvent->end_date->format('M d, Y H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Registration -->
                    <div class="p-6 border rounded-2xl bg-gradient-to-br from-purple-50/80 to-pink-50/50 backdrop-blur-sm border-purple-200/30 dark:from-purple-900/30 dark:to-pink-900/20 dark:border-purple-700/30">
                        <div class="flex items-center mb-4">
                            <i class="mr-3 text-2xl text-purple-600 bx bx-user-plus dark:text-purple-400"></i>
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Registration</h4>
                        </div>
                        <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                            <div class="flex items-center">
                                <span class="w-12 font-medium text-green-600 dark:text-green-400">Start:</span>
                                <span class="ml-2">{{ $selectedEvent->registration_start_date->format('M d, Y H:i') }}</span>
                            </div>
                            <div class="flex items-center">
                                <span class="w-12 font-medium text-red-600 dark:text-red-400">End:</span>
                                <span class="ml-2">{{ $selectedEvent->registration_end_date->format('M d, Y H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Event Details -->
                    <div class="p-6 border rounded-2xl bg-gradient-to-br from-green-50/80 to-emerald-50/50 backdrop-blur-sm border-green-200/30 dark:from-green-900/30 dark:to-emerald-900/20 dark:border-green-700/30">
                        <div class="flex items-center mb-4">
                            <i class="mr-3 text-2xl text-green-600 bx bx-info-circle dark:text-green-400"></i>
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Event Details</h4>
                        </div>
                        <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                            <div class="flex items-center justify-between">
                                <span class="font-medium">Status:</span>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $this->getEventStatusBadge($selectedEvent->status) }}">
                                    {{ ucfirst($selectedEvent->status) }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="font-medium">Capacity:</span>
                                <span class="font-semibold">{{ $selectedEvent->capacity ?: 'Unlimited' }}</span>
                            </div>
                            @if($selectedEvent->ticket_price)
                                <div class="flex items-center justify-between">
                                    <span class="font-medium">Price:</span>
                                    <span class="font-semibold text-green-600 dark:text-green-400">${{ number_format($selectedEvent->ticket_price, 2) }}</span>
                                </div>
                            @endif
                            <div class="flex items-center justify-between">
                                <span class="font-medium">Public:</span>
                                <span class="font-semibold {{ $selectedEvent->is_public ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">{{ $selectedEvent->is_public ? 'Yes' : 'No' }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="font-medium">Approval Required:</span>
                                <span class="font-semibold {{ $selectedEvent->require_approval ? 'text-orange-600 dark:text-orange-400' : 'text-green-600 dark:text-green-400' }}">{{ $selectedEvent->require_approval ? 'Yes' : 'No' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Created By -->
                    <div class="p-6 border rounded-2xl bg-gradient-to-br from-orange-50/80 to-yellow-50/50 backdrop-blur-sm border-orange-200/30 dark:from-orange-900/30 dark:to-yellow-900/20 dark:border-orange-700/30">
                        <div class="flex items-center mb-4">
                            <i class="mr-3 text-2xl text-orange-600 bx bx-user dark:text-orange-400"></i>
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Created By</h4>
                        </div>
                        <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                            <div>
                                <span class="font-medium text-gray-700 dark:text-gray-300">User:</span>
                                <span class="ml-2 font-semibold">{{ $selectedEvent->user->name }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700 dark:text-gray-300">Email:</span>
                                <span class="ml-2">{{ $selectedEvent->user->email }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700 dark:text-gray-300">Created:</span>
                                <span class="ml-2">{{ $selectedEvent->created_at->format('M d, Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                @if($selectedEvent->desc)
                    <div>
                        <h4 class="flex items-center mb-4 text-xl font-semibold text-gray-800 dark:text-gray-100">
                            <i class="mr-3 text-2xl text-blue-600 bx bx-file-blank dark:text-blue-400"></i>
                            Description
                        </h4>
                        <div class="p-6 border rounded-2xl bg-gradient-to-br from-gray-50/80 to-slate-50/50 backdrop-blur-sm border-gray-200/30 dark:from-zinc-800/80 dark:to-zinc-700/50 dark:border-zinc-600/30">
                            <div class="prose-sm prose dark:prose-invert max-w-none">
                                {!! $selectedEvent->desc !!}
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Activities -->
                @if($selectedEvent->activities->count() > 0)
                    <div>
                        <h4 class="flex items-center mb-4 text-xl font-semibold text-gray-800 dark:text-gray-100">
                            <i class="mr-3 text-2xl text-green-600 bx bx-calendar-event dark:text-green-400"></i>
                            Activities ({{ $selectedEvent->activities->count() }})
                        </h4>
                        <div class="space-y-4">
                            @foreach($selectedEvent->activities as $activity)
                                <div class="p-5 border rounded-2xl bg-gradient-to-r from-gray-50/80 to-blue-50/30 backdrop-blur-sm border-gray-200/30 dark:from-zinc-800/80 dark:to-zinc-700/30 dark:border-zinc-600/30">
                                    <h5 class="mb-2 text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $activity->name }}</h5>
                                    @if($activity->desc)
                                        <p class="mb-3 text-gray-600 dark:text-gray-400">{{ $activity->desc }}</p>
                                    @endif
                                    <div class="flex flex-wrap gap-4 text-sm text-gray-500 dark:text-gray-400">
                                        <div class="flex items-center">
                                            <i class="mr-1 text-blue-500 bx bx-time"></i>
                                            <span>{{ $activity->start_date->format('M d, Y H:i') }}</span>
                                            <span class="mx-2">→</span>
                                            <span>{{ $activity->end_date->format('M d, Y H:i') }}</span>
                                        </div>
                                        @if($activity->capacity)
                                            <div class="flex items-center">
                                                <i class="mr-1 text-purple-500 bx bx-group"></i>
                                                <span>Capacity: {{ $activity->capacity }}</span>
                                            </div>
                                        @endif
                                        @if($activity->ticket_price)
                                            <div class="flex items-center">
                                                <i class="mr-1 text-green-500 bx bx-money"></i>
                                                <span>Price: ${{ number_format($activity->ticket_price, 2) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </x-dynamic-modal>
    @endif
</div>

@push('styles')
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Enhanced modern glass-morphism effect */
.backdrop-blur-sm {
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
}

/* Search input styling */
.search-input {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.search-input:focus {
    background: rgba(39, 39, 42, 0.7);
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5), 0 8px 25px rgba(0, 0, 0, 0.15);
}

/* Search clear button */
.search-clear-btn {
    transition: all 0.2s ease;
    opacity: 0.6;
}

.search-clear-btn:hover {
    opacity: 1;
    transform: scale(1.1);
}

/* Search input focus effects */
.search-input-container:focus-within .search-icon {
    color: #60a5fa;
}

/* Modern search input design */
.modern-search-input {
    background: rgba(39, 39, 42, 0.5);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(82, 82, 91, 0.5);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.modern-search-input:focus {
    background: rgba(39, 39, 42, 0.8);
    border-color: rgba(59, 130, 246, 0.6);
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2), 0 8px 25px rgba(0, 0, 0, 0.1);
}

/* Compact filter button styling */
.compact-filter-btn {
    min-width: 60px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    backdrop-filter: blur(8px);
}

.compact-filter-btn:hover {
    background-color: rgba(63, 63, 70, 0.5);
    transform: translateY(-1px);
}

.compact-filter-btn.active {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
}

/* Responsive layout for search and filter */
@media (max-width: 640px) {
    .search-filter-container {
        flex-direction: column;
        gap: 1rem;
    }

    .compact-filter-btn {
        min-width: 50px;
        padding: 0.375rem 0.5rem;
        font-size: 0.75rem;
    }
}

@media (min-width: 641px) {
    .search-filter-container {
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
    }
}

/* Dark mode optimized dropdown */
.dropdown-menu {
    position: absolute !important;
    z-index: 9999 !important;
    right: 0 !important;
    top: 100% !important;
    min-width: 12rem !important;
    background: rgba(39, 39, 42, 0.9) !important;
    backdrop-filter: blur(12px) !important;
    border: 1px solid rgba(82, 82, 91, 0.5) !important;
    border-radius: 0.5rem !important;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2) !important;
}

/* Ensure parent containers don't clip dropdown */
.relative {
    position: relative !important;
}

.grid {
    overflow: visible !important;
}

/* Enhanced tab button styling for compact layout */
.tab-button {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    backdrop-filter: blur(8px);
    min-width: 60px;
}

.tab-button:hover {
    background-color: rgba(63, 63, 70, 0.5);
    transform: translateY(-1px);
}

.tab-button.active {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
}

/* Enhanced filter tabs for compact layout */
.filter-tabs {
    background: rgba(39, 39, 42, 0.5);
    backdrop-filter: blur(16px);
    border: 1px solid rgba(82, 82, 91, 0.3);
    display: flex;
    gap: 4px;
    width: fit-content;
}

/* Search and filter layout */
.search-filter-layout {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

@media (min-width: 640px) {
    .search-filter-layout {
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
    }
}

/* Responsive text sizing for compact buttons */
@media (max-width: 640px) {
    .filter-tabs button {
        font-size: 0.75rem;
        padding: 0.375rem 0.5rem;
        min-width: 50px;
    }
}

@media (min-width: 641px) {
    .filter-tabs button {
        font-size: 0.75rem;
        padding: 0.5rem 0.75rem;
        min-width: 60px;
    }
}

/* Enhanced event card hover effects */
.event-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    backdrop-filter: blur(12px);
    background: rgba(39, 39, 42, 0.3);
}

.event-card:hover {
    border-color: rgba(82, 82, 91, 0.7);
    background: rgba(39, 39, 42, 0.4);
    transform: translateY(-4px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
}

/* Responsive card sizing for 5-column layout */
@media (min-width: 1280px) {
    .event-card {
        min-height: 280px;
    }

    .event-card h3 {
        font-size: 0.875rem;
        line-height: 1.25rem;
    }
}

/* Ensure text truncation works well in smaller cards */
.truncate-location {
    max-width: 100%;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

/* Modern gradient button with enhanced effects */
.manage-event-btn {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.2);
    position: relative;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.manage-event-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s ease;
}

.manage-event-btn:hover::before {
    left: 100%;
}

.manage-event-btn:hover {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    box-shadow: 0 8px 30px rgba(59, 130, 246, 0.4);
    transform: translateY(-2px);
}

.manage-event-btn:active {
    transform: translateY(0);
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
}

/* Enhanced focus states for dark mode */
input:focus,
select:focus,
button:focus {
    outline: none;
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
}

/* Modern glass scrollbar for dark theme */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: rgba(39, 39, 42, 0.3);
    border-radius: 4px;
    backdrop-filter: blur(8px);
}

::-webkit-scrollbar-thumb {
    background: rgba(82, 82, 91, 0.6);
    border-radius: 4px;
    backdrop-filter: blur(8px);
    transition: all 0.3s ease;
}

::-webkit-scrollbar-thumb:hover {
    background: rgba(113, 113, 122, 0.8);
}

/* Smooth animations for all interactive elements */
* {
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

/* Enhanced glass effect for filter tabs */
.filter-tabs {
    background: rgba(39, 39, 42, 0.5);
    backdrop-filter: blur(16px);
    border: 1px solid rgba(82, 82, 91, 0.3);
}

/* Pagination glass effect */
.pagination-container {
    background: rgba(39, 39, 42, 0.3);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(82, 82, 91, 0.3);
}
</style>
@endpush
