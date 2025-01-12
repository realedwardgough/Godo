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
    switch (action) {
        case 'create':
            url = '/create/list-item';
            break;
        case 'delete':
            url = '/delete/list-item';
            break;
        case 'edit':
            url = '/edit/list-item';
            break;
        case 'status':
            url = '/status/list-item';
            break;
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

/**
 * Function: ResponseHandler
 * Description: ...
 * @param {object} data
 */
function ResponseHandler(data = {}) {
    data.data.reaction.forEach(function(item) {

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

        // Replace element with new HTML
        if (item.type == 'replaceElement') {
            document.querySelector(item.tag).outerHTML = item.value;
        }

    });
}


/**
 * Function: ListItemController
 * Description: ...
 * @param {object} element
 * @param {object} event
 * @param {string} request
 */
function ListItemController (element, event, request) {
    

    // Attribute collection for selected list item
    let listId = element.closest('[data-list-id]')?.getAttribute('data-list-id');
    let listItemElement = event.target.closest('[data-list-item-id]');
    let listItemId = listItemElement?.getAttribute('data-list-item-id');
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

    //
    else if (request == 'edit') {
        data.title = listItemElement.querySelector('[data-content="list-item-title"]')?.textContent.trim();
        data.content = listItemElement.querySelector('[data-content="list-item-content"]')?.textContent.trim();
        RequestHandler(request, data);
    }

    //
    else if (request == 'status') {
        data.status = element?.getAttribute('data-status');
        RequestHandler(request, data);
    }

}


// Attaching the event listener to the document (or a stable parent)
document.body.addEventListener('click', function(event) {
    
    // Check if the clicked element matches the selector
    if (event.target.closest('.delete-list-item-button')) {
        ListItemController(event.target, event, 'delete');
    }

    // Check if the clicked element matches the selector
    if (event.target.closest('.create-list-item-button')) {
        ListItemController(event.target, event, 'create');
    }

    // Check if the clicked element matches the selector
    if (event.target.closest('[data-content="complete-item"]')) {
        ListItemController(event.target, event, 'status');
    }

});



// Attaching the event listener to the document (or a stable parent)
document.body.addEventListener('focusout', function(event) {

    let titleEdit = event.target.matches('[data-content="list-item-title"]');
    let contentEdit = event.target.matches('[data-content="list-item-content"]');
    let listItemId = event.target.closest('[data-list-item-id]')?.getAttribute('data-list-item-id');
    
    //
    if (titleEdit || contentEdit) {
        ListItemController(event.target, event, 'edit');
    }

});