@if ($layout->form)
    <livewire:signup-form :form="$layout->form" :key="'signup-form-' . $layout->form->id" />
@endif
