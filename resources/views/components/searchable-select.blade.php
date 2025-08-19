
@props([
    'label',
    'options', // Expects an array/collection of items with 'id' and 'name' keys
    'placeholder' => 'Select an option...',
    'listenEvent' => null, // The browser event to listen for to update options
])

<div x-data="searchableSelect({
        // Pass PHP variables into our Alpine component
        wireModel: '{{ $attributes->wire('model')->value() }}',
        placeholder: '{{ $placeholder }}',
        listenEvent: '{{ $listenEvent }}',
        initialOptions: {{ json_encode($options) }}
    })"
    x-init="init()"
    wire:key="searchable-select-{{ $attributes->wire('model')->value() }}"
>
    <label class="form-label">{{ $label }}</label>
    <div wire:ignore>
        <select x-ref="select" class="form-control"></select>
    </div>
</div>

@once
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('searchableSelect', (config) => ({
        select: null,

        // Configuration passed from Blade props
        wireModel: config.wireModel,
        placeholder: config.placeholder,
        listenEvent: config.listenEvent,
        initialOptions: config.initialOptions,

        init() {
            this.select = new TomSelect(this.$refs.select, {
                create: false,
                sortField: { field: 'text', direction: 'asc' },
                placeholder: this.placeholder,
                options: this.initialOptions.map(option => ({ value: option.id, text: option.name })),
                items: [this.$wire.get(this.wireModel)], // Pre-select the current value from Livewire

                onChange: (value) => {
                    // When the user selects an option, update the Livewire model
                    this.$wire.set(this.wireModel, value);
                }
            });

            // If a listenEvent is provided, set up the listener
            if (this.listenEvent) {
                // Initially disable if it depends on another select
                if (!this.$wire.get(this.wireModel)) {
                    this.select.disable();
                }

                window.addEventListener(this.listenEvent, (event) => {
                    const newOptions = event.detail.options || event.detail[0] || [];
                    this.updateOptions(newOptions);
                });
            }

            // When Livewire re-renders, ensure Tom Select's value is in sync
            this.$watch('$wire.' + this.wireModel, (newValue) => {
                if (this.select.getValue() !== newValue) {
                    this.select.setValue(newValue, true); // `true` prevents onChange from firing
                }
            });
        },

        updateOptions(options) {
            this.select.clear();
            this.select.clearOptions();
            this.select.addOption({ value: '', text: this.placeholder });

            if (options && options.length > 0) {
                options.forEach(option => {
                    this.select.addOption({
                        value: option.id,
                        text: option.name
                    });
                });
                this.select.enable();
            } else {
                this.select.disable();
            }
            this.select.refreshOptions(false);
        }
    }));
});
</script>
@endonce