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
                
                <div class="nav-item">
                    <a href="" class="action delete">
                        <span class="material-symbols-outlined">
                            save
                        </span>
                    </a>
                </div>

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
                            <h3>Task 1</h3>
                            <p>Task 1 description</p>
                        </div>
                        <div class="list-actions">
                            <button class="action edit">
                                <span class="material-symbols-outlined">
                                    edit
                                </span>
                            </button>
                            <button class="action delete">
                                <span class="material-symbols-outlined">
                                    delete
                                </span>
                            </button>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        
    </main>

</body>
</html>