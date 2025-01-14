<!-- Required Parameters to Generate List Item -->
@props([
    'id',
    'title'
])

<!-- Default List -->
<div class="inner" data-list-id="{{ $id }}">
    <header>
        <h2 contenteditable>{{ $title }}</h2>
        <button class="button remove" data-list-id="{{ $id }}">
            Remove
        </button>
    </header>
    <div class="list" data-list-id="{{ $id }}">    
        <div class="list-container" data-listid="{{ $id }}"></div>
        <button class="list-item placeholder-add create-list-item-button">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <span class="material-symbols-outlined">
                add
            </span>
        </button>
    </div>
</div>