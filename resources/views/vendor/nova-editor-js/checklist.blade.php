@foreach ($items as $item)
    <div class="checklist-item"><span class="checkbox {{ $item['checked'] ? 'checkbox-checked' : '' }}"></span>
        <div class="checkbox-text">
            {{ $item['text'] }}
        </div>
    </div>
@endforeach
