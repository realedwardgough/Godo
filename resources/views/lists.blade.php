<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Godo: Easy To-Do List Manager</title>
    <link rel="stylesheet" href="{{ asset(path: 'css/app.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>
<body>
    
    <!-- Main Container -->
    <main>

        <!-- Navigation -->
        <nav>
            <div class="inner">
                <h1 style="display:none;">Godo</h1>
                <img src="{{ asset('media/download/godo-logo.png') }}" alt="">
            </div>
        </nav>

        <!-- Container of List Category -->
        <div class="lists">
            
            

            <!-- Container for each list item -->
            @foreach($user->lists as $list)

                <!-- Default List -->
                <div class="inner">

                    <!-- Header of List Category -->
                    <header>
                        <h2 contenteditable>{{ $list->title }}</h2>
                        <a class="button remove" href="">
                            Remove
                        </a>
                    </header>

                    <div class="list" data-list-id="{{ $list->id }}">    

                        <!-- List Items -->
                        @foreach($list->listItems as $listItem)
                            <x-list-item
                                list_status="open"
                                list_icon="check_box_outline_blank"
                                list_content_header="{{ $listItem->title }}"
                                list_content_body="{{ $listItem->content }}"
                                list_content_date="04/01/2025"
                                list_id="{{ $list->id }}"
                                list_item_id="{{ $listItem->id }}"
                            ></x-list-item>
                        @endforeach

                        <!-- Create New List Item -->
                        <button 
                            class="list-item placeholder-add create-list-item-button"
                            data-list="Default List"
                            data-listid="1">
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            <span class="material-symbols-outlined">
                                add
                            </span>
                        </button>
                    </div>
                </div>
            @endforeach

        </div>  

        <!-- Container QR Code -->
        <div class="qrcode-container">
            <div class="inner">
                <img src="{{ asset('media/download/example-qrcode.png') }}" alt="QR Code">
                <p>{{ session('unique_session_id') }}</p>
            </div>
        </div>
        
    </main>

    <!-- Godo Scripts -->
    <script src="{{ asset(path: 'js/godo.js') }}"></script>

</body>
</html>