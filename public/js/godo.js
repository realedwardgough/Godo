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
 * Description: Send task data to Laravel controller using Axios
 * @param {string} action - Either 'add' or 'remove'
 * @param {string} taskName - The name of the task (required for 'add')
 * @param {int} taskId - The ID of the task (required for 'remove')
 */
function RequestHandler(action = '', data = {}) {

    // 
    let url = '/create/list-item';

    // 
    axios.post(url, data, {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => {
        console.log(response.data.message);

        // Target the element with class 'list-container' and data-listid="1"
        if(response.data.html) {
            document.querySelector('.list-container[data-listid="'+data.listId+'"]').insertAdjacentHTML('beforeend', response.data.html);
        }

    })
    .catch(error => {
        console.error('Error:', error.response);
    });
}


/**
 * Function: ListItemController
 * Description: ...
 */
function ListItemController (element, request) {
    
    // Attribute collection for selected list item
    let listId = element.closest('[data-list-id]')?.getAttribute('data-list-id');
    let listItemId = element.closest('[data-list-item-id]')?.getAttribute('data-list-item-id');
    let data = {
        listId: listId,
        listItemId: listItemId
    };

    // Request to create a new list item from the selected list stack
    if (request == 'create') {
        console.log('You want to create a new list item for ' + listId);
        RequestHandler(request, data);
    }

    // Request to delete a list item, and the list item was selected
    else if (request == 'delete') {
        console.log('You want to delete a list item (' + listItemId + ') for ' + listId);
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
