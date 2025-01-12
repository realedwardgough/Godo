<!-- Required Parameters to Generate List Item -->
@props([
    'list_status',
    'list_icon',
    'list_content_header',
    'list_content_body',
    'list_content_date',
    'list_id',
    'list_item_id'
])

<!-- Single List Item -->
<div class="list-item {{ $list_status }}" data-list-item-id="{{ $list_item_id }}">
    <div class="list-icon">
        <span class="material-symbols-outlined">
            {{ $list_icon }}
        </span>
    </div>
    <div class="list-content">
        <h3 contenteditable data-content="list-item-title" data-title="{{ $list_content_header }}">{{ $list_content_header }}</h3>
        <p contenteditable data-content="list-item-content" data-content="{{ $list_content_body }}">{{ $list_content_body }}</p>
        <div class="list-additional">
            <span class="material-symbols-outlined">
                calendar_today
            </span>
            <h4>{{ $list_content_date }}</h4>
        </div>
    </div>
    <div class="list-actions">
        <button class="action delete delete-list-item-button">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <span class="material-symbols-outlined">
                close
            </span>
        </button>
    </div>
</div>