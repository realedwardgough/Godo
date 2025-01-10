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
    let url;

    // 
    if (action == 'create') {
        url = '/create/list-item';
    }
    else if (action == 'delete') {
        url = '/delete/list-item';
    }

    // 
    axios.post(url, data, {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => {
        ResponseHandler(response);
    })
    .catch(error => {
        console.error('Error:', error.response);
    });
}

function ResponseHandler(data = {}) {
    

    // 
    data.data.reaction.forEach(function(item) {

        console.log(item);
        console.log(item.type);

        // Push HTML into the end of a section
        if (item.type == 'insertAdjacentHTML') {
            document.querySelector(item.tag).insertAdjacentHTML('beforeend', item.value);
        }

        // Remove HTML element from DOM
        if (item.type == 'remove') {
            document.querySelector(item.tag).remove();
        }

        // Display console log
        if (item.type == 'console') {
            console.log(item.value);
        }


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
        RequestHandler(request, data);
    }

    // Request to delete a list item, and the list item was selected
    else if (request == 'delete') {
        console.log(data);
        RequestHandler(request, data);
    }

}


// Attaching the event listener to the document (or a stable parent)
document.body.addEventListener('click', function(event) {
    
    // Check if the clicked element matches the selector
    if (event.target.closest('.delete-list-item-button')) {
        ListItemController(event.target, 'delete');
    }

    // Check if the clicked element matches the selector
    if (event.target.closest('.create-list-item-button')) {
        ListItemController(event.target, 'create');
    }

});