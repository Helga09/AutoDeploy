<div x-data="{
    dropdownOpen: false,
    search: '',
    allEntries: [],
    darkColorContent: getComputedStyle($el).getPropertyValue('--color-base'),
    whiteColorContent: getComputedStyle($el).getPropertyValue('--color-white'),
    init() {
        this.mounted();
        // Load all entries when component initializes
        this.allEntries = @js($entries->toArray());
    },
    markEntryAsRead(tagName) {
        // Update the entry in our local Alpine data
        const entry = this.allEntries.find(e => e.tag_name === tagName);
        if (entry) {
            entry.is_read = true;
        }
        // Call Livewire to update server-side
        $wire.markAsRead(tagName);
    },
    markAllEntriesAsRead() {
        // Update all entries in our local Alpine data
        this.allEntries.forEach(entry => {
            entry.is_read = true;
        });
        // Call Livewire to update server-side
        $wire.markAllAsRead();
    },
    switchWidth() {
        if (this.full === 'full') {
            localStorage.setItem('pageWidth', 'center');
        } else {
            localStorage.setItem('pageWidth', 'full');
        }
        window.location.reload();
    },
    setZoom(zoom) {
        localStorage.setItem('zoom', zoom);
        window.location.reload();
    },
    setTheme(type) {
        this.theme = type;
        localStorage.setItem('theme', type);
        this.queryTheme();
    },
    queryTheme() {
        const darkModePreference = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const userSettings = localStorage.getItem('theme') || 'dark';
        localStorage.setItem('theme', userSettings);

        const themeMetaTag = document.querySelector('meta[name=theme-color]');
        let isDark = false;

        if (userSettings === 'dark') {
            document.documentElement.classList.add('dark');
            this.theme = 'dark';
            isDark = true;
        } else if (userSettings === 'light') {
            document.documentElement.classList.remove('dark');
            this.theme = 'light';
            isDark = false;
        } else if (userSettings === 'system') {
            this.theme = 'system';
            if (darkModePreference) {
                document.documentElement.classList.add('dark');
                isDark = true;
            } else {
                document.documentElement.classList.remove('dark');
                isDark = false;
            }
        }

        // Update theme-color meta tag
        if (themeMetaTag) {
            themeMetaTag.setAttribute('content', isDark ? '#101010' : '#ffffff');
        }
    },
    mounted() {
        this.full = localStorage.getItem('pageWidth');
        this.zoom = localStorage.getItem('zoom');
        this.queryTheme();
    },
    get filteredEntries() {
        let entries = this.allEntries;

        // Apply search filter if search term exists
        if (this.search && this.search.trim() !== '') {
            const searchLower = this.search.trim().toLowerCase();
            entries = entries.filter(entry => {
                return (entry.title?.toLowerCase().includes(searchLower) ||
                    entry.content?.toLowerCase().includes(searchLower) ||
                    entry.tag_name?.toLowerCase().includes(searchLower));
            });
        }

        // Always sort: unread first, then by published date (newest first)
        return entries.sort((a, b) => {
            // First sort by read status (unread first)
            if (a.is_read !== b.is_read) {
                return a.is_read ? 1 : -1; // unread (false) comes before read (true)
            }
            // Then sort by published date (newest first)
            return new Date(b.published_at) - new Date(a.published_at);
        });
    }
}" @click.outside="dropdownOpen = false">
    <!-- Custom Dropdown without arrow -->
    <div class="relative">
        <button @click="dropdownOpen = !dropdownOpen"
            class="relative p-2 dark:text-neutral-400 hover:dark:text-white transition-colors cursor-pointer"
            title="Налаштування">
            <!-- Sliders Icon -->
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" title="Налаштування">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
            </svg>

        </button>

        <!-- Dropdown Menu -->
        <div x-show="dropdownOpen" x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2" class="absolute right-0 top-full mt-1 z-50 w-48" x-cloak>
            <div
                class="p-1 bg-white border rounded-sm shadow-lg dark:bg-coolgray-200 dark:border-coolgray-300 border-neutral-300">
                <div class="flex flex-col gap-1">

                    <!-- Divider -->
                    <div class="border-b dark:border-coolgray-500 border-neutral-300"></div>

                    <!-- Theme Section -->
                    <div class="font-bold border-b dark:border-coolgray-500 border-neutral-300 dark:text-white pb-1">
                        Вигляд</div>
                    <button @click="setTheme('dark'); dropdownOpen = false"
                        class="px-1 dropdown-item-no-padding flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <span>Темна</span>
                    </button>
                    <button @click="setTheme('light'); dropdownOpen = false"
                        class="px-1 dropdown-item-no-padding flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span>Світла</span>
                    </button>
                    <button @click="setTheme('system'); dropdownOpen = false"
                        class="px-1 dropdown-item-no-padding flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span>Системна</span>
                    </button>


                </div>
            </div>
        </div>
    </div>

</div>