<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Godo: Easy To-Do List Manager</title>
    <link rel="stylesheet" href="{{ asset(path: 'css/app.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

    <!-- Axios CDN -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> 

</head>
<body>
    <main>
        <nav>
            <div class="inner">
                <h1 style="display:none;">Godo</h1>
                <img src="{{ asset('media/download/godo-logo.png') }}" alt="">
            </div>
        </nav>

        <!-- Container of List Category -->
        <div class="lists">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <div class="lists-wrapper">
                @foreach($user->lists as $list)
                    <div class="inner" data-list-id="{{ $list->id }}">

                        <!-- Header of List Category -->
                        <header>
                            <h2 contenteditable>{{ $list->title }}</h2>
                            <button class="button remove" data-list-id="{{ $list->id }}">
                                Remove
                            </button>
                        </header>

                        <div class="list" data-list-id="{{ $list->id }}">    

                            <div class="list-container" data-listid="{{ $list->id }}">
                                <!-- List Items -->
                                @foreach($list->listItems->sortByDesc(function($item) {
                                    return $item->status == 1 ? 1 : 0;
                                }) as $listItem)
                                    <x-list-item
                                        list_status="{{ $listItem->status == 1 ? 'open' : ($listItem->status == 2 ? 'closed' : '') }}"
                                        list_icon="{{ $listItem->status == 1 ? 'check_box_outline_blank' : ($listItem->status == 2 ? 'check_box' : '') }}"
                                        list_content_header="{{ $listItem->title }}"
                                        list_content_body="{{ $listItem->content }}"
                                        list_content_date="04/01/2025"
                                        list_id="{{ $list->id }}"
                                        list_item_id="{{ $listItem->id }}"
                                    ></x-list-item>
                                @endforeach
                            </div>

                            <!-- Create New List Item -->
                            <button 
                                class="list-item placeholder-add create-list-item-button"
                                data-list="Default List"
                                data-listid="1">
                                <span class="material-symbols-outlined">
                                    add
                                </span>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="inner">
                <button class="button create">
                    Create List
                </button>
            </div>
        </div>  

        <!-- Container QR Code -->
        <div class="qrcode-container">
            <div class="inner">
                {!! $qrCode !!}
            </div>
        </div>
    </main>

    <!-- Godo Scripts -->
    <script src="{{ asset(path: 'js/godo.js') }}"></script>

</body>
</html>