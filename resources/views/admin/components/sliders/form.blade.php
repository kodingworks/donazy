@props(['slider' => new \App\Models\Slider(), 'selectedCampaigns' => null])

<div>
    <label class="block text-sm mb-4">
        <x-admin::label value="Nama" required />
        <x-admin::input
            type="text"
            name="name"
            placeholder="Nama"
            :error="$errors->has('name')"
            :value="old('name', $slider->name)"
        />
        @error('name')
            <x-admin::input-helper error :value="$message" />
        @enderror
    </label>
    <label class="block text-sm mb-4">
        <x-admin::label value="Urutan" />
        <x-admin::input
            type="number"
            name="sort"
            placeholder="Urutan"
            min="1"
            :value="old('sort', $slider->sort ?? 1)"
        />
    </label>
    <div class="text-sm mb-4">
        <x-admin::label value="Program" required />
        <div
            @if ($selectedCampaigns instanceof \Illuminate\Support\Collection)
                x-data="ProgramSelector({ selectedOptions: JSON.parse('{{ $selectedCampaigns->toJson() }}') })"
            @else
                x-data="ProgramSelector()"
            @endif
            x-init="init()"
            x-on:click="setOpen()"
            x-on:click.away="setClose()"
            class="relative"
        >
            <ul x-show="selectedOptions.length">
                <template x-for="selectedOption in selectedOptions" :key="selectedOption.id">
                    <li class="mb-2">
                        <input type="hidden" name="campaign_ids[]" x-bind:value="selectedOption.id">
                        <div class="inline-flex space-x-2 items-center px-4 py-2 bg-gray-200 shadow rounded">
                            <span x-text="selectedOption.name"></span>
                            <button
                                x-on:click="removeSelectedOption(selectedOption)"
                                type="button"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </li>
                </template>
            </ul>
            <x-admin::input
                x-model.debounce="search"
                type="text"
                placeholder="Nama program"
            />
            <ul
                x-show="open"
                class="absolute w-full mt-1 bg-white shadow rounded"
            >
                <li
                    x-show="loading"
                    class="p-4 flex items-center space-x-2 absolute w-full mt-1 bg-white shadow rounded"
                >
                    <svg class="animate-spin h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Mencari data</span>
                </li>
                <template x-for="option in options" :key="option.id">
                    <li
                        x-on:click="addSelectedOption(option)"
                        x-bind:class="option.selected && 'text-primary border-primary'"
                        class="px-4 py-2 flex items-center space-x-4 border border-gray-200 cursor-pointer hover:text-primary hover:border-primary"
                    >
                        <img
                            x-bind:src="option.thumbnail_cover_url"
                            class="w-24 h-12 object-cover"
                        />
                        <span x-text="option.name"></span>
                    </li>
                </template>
            </ul>
        </div>
        @error('campaign_ids')
            <x-admin::input-helper error :value="$message" />
        @enderror
        <script>
            function ProgramSelector({ selectedOptions = null } = {}) {
                return {
                    loading: false,
                    open: false,
                    search: '',
                    options: [],
                    selectedOptions: selectedOptions || [],
                    init() {
                        this.$watch('search', this.watchSearch.bind(this));
                    },
                    setOpen() {
                        this.open = true;

                        if (this.options.length < 1) {
                            this.watchSearch('');
                        }
                    },
                    setClose() {
                        this.open = false;
                    },
                    watchSearch(value) {
                        this.loading = true;

                        axios.get(`/api/campaigns?per_page=10&search=${value}`)
                            .then(response => {
                                this.options = response.data.data.map(option => {
                                    if (this.isOptionSelected(option)) {
                                        option.selected = true;
                                    }

                                    return option;
                                });
                            })
                            .catch(error => {
                                this.options = [];
                                alert(error)
                            })
                            .finally(() => {
                                this.loading = false;
                            });
                    },
                    addSelectedOption(option) {
                        this.options = this.options.map(opt => {
                            if (opt.id === option.id) {
                                opt.selected = true;
                            }

                            return opt;
                        });

                        if (this.isOptionSelected(option)) {
                            return;
                        }

                        this.selectedOptions.push(option);
                    },
                    removeSelectedOption(option) {
                        this.options = this.options.map(opt => {
                            if (opt.id === option.id) {
                                delete opt.selected;
                            }

                            return opt;
                        });

                        this.selectedOptions = this.selectedOptions.filter(selectedOption => selectedOption.id !== option.id);
                    },
                    isOptionSelected(option) {
                        return Boolean(this.selectedOptions.filter(selectedOption => selectedOption.id === option.id).length);
                    }
                };
            };
        </script>
    </div>
</div>
