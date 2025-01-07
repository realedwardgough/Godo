/**
 * 
 * Godo To-Do List Web Application
 * Edward Gough
 * 07/01/2025
 * 
 */


// Development Log to show initialised scripts
console.log('Godo To-Do List Web Application - 07/01/2025');


/**
 * Function: RequestHandler
 * Description: ...
 */
function RequestHandler () {


    // Use Axios to send request to controllers
    // Function requires <meta name="csrf-token" content="{{ csrf_token() }}"> to be present on DOM
    axios.post('/where-it-needs-to-go', {
        task_name: taskName
    }, {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => {
        console.log('Task Added: ' + response.data.message);
    })
    .catch(error => {
        console.error('Error:', error.response.data);
        console.log('Error adding task');
    });
    
}


/**
 * Function: ListItemController
 * Description: ...
 */
function ListItemController (element, request) {
    
    // Attribute collection for selected list item
    let list = element.closest('[data-list-id]')?.getAttribute('data-list-id');
    let listid = element.closest('[data-list-item-id]')?.getAttribute('data-list-item-id');

    // Request to create a new list item from the selected list stack
    if (request == 'create') {
        console.log('You want to create a new list item for ' + list);
    }

    // Request to delete a list item, and the list item was selected
    else if (request == 'delete') {
        console.log('You want to delete a list item (' + listid + ') for ' + list);
    }

}


/**
 * Event Listener
 * Description: ...
 */
document.querySelectorAll('.create-list-item-button').forEach(function(element) {
    element.addEventListener('click', function() {
        ListItemController(this, 'create');
    });
});

/**
 * Event Listener
 * Description: ...
 */
document.querySelectorAll('.delete-list-item-button').forEach(function(element) {
    element.addEventListener('click', function() {
        ListItemController(this, 'delete');
    });
});
