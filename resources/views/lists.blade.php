<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Godo: Easy To-Do List Manager</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>
<body>
    
    <!-- Main Container -->
    <main>


        <!-- Navigation -->
        <nav>
            <div class="inner">
                <h1>Godo</h1>
            </div>
        </nav>



        <!-- Container of List Category -->
        <div class="lists">
            <div class="inner">

                <!-- Header of List Category -->
                <header>
                    <h2>Default List</h2>
                </header>

                <!-- Container for each list item -->
                <div class="list">
                   
                    <!-- Single List Item -->
                    <div class="list-item">
                        <div class="list-icon">
                            <span class="material-symbols-outlined">
                                check_box_outline_blank
                            </span>
                        </div>
                        <div class="list-content">
                            <h3 contenteditable>Task 2</h3>
                            <p contenteditable>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam molestie, felis id commodo posuere, lorem ligula dignissim justo, quis cursus nisl velit vestibulum nisl. Vestibulum tristique finibus justo, sed placerat magna placerat a. In dictum aliquam nibh in vehicula. Etiam a suscipit dolor, non fermentum justo. Morbi laoreet purus libero, ut gravida ipsum malesuada eget.</p>
                            <div class="list-additional">
                                <span class="material-symbols-outlined">
                                    calendar_today
                                </span>
                                <h4>04/01/2025</h4>
                            </div>
                        </div>
                        <div class="list-actions">
                            <button class="action delete">
                                <span class="material-symbols-outlined">
                                    close
                                </span>
                            </button>
                        </div>
                    </div>

                    <!-- Closed Single List Item -->
                    <div class="list-item closed">
                        <div class="list-icon">
                            <span class="material-symbols-outlined">
                                check_box
                            </span>
                        </div>
                        <div class="list-content">
                            <h3 contenteditable>Task 1</h3>
                            <p contenteditable>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam molestie, felis id commodo posuere, lorem ligula dignissim justo, quis cursus nisl velit vestibulum nisl. Vestibulum tristique finibus justo, sed placerat magna placerat a. In dictum aliquam nibh in vehicula. Etiam a suscipit dolor, non fermentum justo. Morbi laoreet purus libero, ut gravida ipsum malesuada eget.</p>
                            <div class="list-additional">
                                <span class="material-symbols-outlined">
                                    calendar_today
                                </span>
                                <h4>02/01/2025</h4>
                            </div>
                        </div>
                        <div class="list-actions">
                            <button class="action delete">
                                <span class="material-symbols-outlined">
                                    close
                                </span>
                            </button>
                        </div>
                    </div>

                </div>

            </div>
        </div>



        <!-- Container QR Code -->
        <div class="qrcode-container">
            <div class="inner">
                <h3>Scan the code to access from anywhere</h3>
                <img src="{{ asset('media/download/example-qrcode.png') }}" alt="QR Code">
            </div>
        </div>
        
    </main>

</body>
</html>