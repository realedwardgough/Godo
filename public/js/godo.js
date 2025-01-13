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
        case 'listItemCreate':
            url = '/create/list-item';
            break;
        case 'listItemDelete':
            url = '/delete/list-item';
            break;
        case 'listItemEdit':
            url = '/edit/list-item';
            break;
        case 'listItemStatus':
            url = '/status/list-item';
            break;
        case 'listCreate':
            url = '/create/list';
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

    // Additional information required for list item edit action
    if (request == 'listItemEdit') {
        data.title = listItemElement.querySelector('[data-content="list-item-title"]')?.textContent.trim();
        data.content = listItemElement.querySelector('[data-content="list-item-content"]')?.textContent.trim();
    }

    // Addtional information requried for list item status change
    else if (request == 'listItemStatus') {
        data.status = element?.getAttribute('data-status');
        
    }

    // Trigger action through Axios
    RequestHandler(request, data);

}

/**
 * 
 */
function ListController (element, event, request) {
    
    //
    let data = {};

    //
    if (request == 'listDelete') {
        let listId = element.closest('[data-list-id]')?.getAttribute('data-list-id');
        console.log('Should delete this: ' + listId);
    }

    // Trigger action through Axios
    // RequestHandler(request, data);

}


// Attaching the event listener to the document (or a stable parent)
document.body.addEventListener('click', function(event) {
    

    // --- List Items
    // Check if the clicked element matches the selector
    if (event.target.closest('.delete-list-item-button')) {
        ListItemController(event.target, event, 'listItemDelete');
    }

    // Check if the clicked element matches the selector
    if (event.target.closest('.create-list-item-button')) {
        ListItemController(event.target, event, 'listItemCreate');
    }

    // Check if the clicked element matches the selector
    if (event.target.closest('[data-content="complete-item"]')) {
        ListItemController(event.target, event, 'listItemStatus');
    }


    // --- Lists
    // Check if the clicked element matches the selector
    if (event.target.closest('.create')) {
        ListController(event.target, event, 'listCreate');
    }

    // Check if the clicked element matches the selector
    if (event.target.closest('.remove')) {
        ListController(event.target, event, 'listDelete');
    }

});



// Attaching the event listener to the document (or a stable parent)
document.body.addEventListener('focusout', function(event) {
    let titleEdit = event.target.matches('[data-content="list-item-title"]');
    let contentEdit = event.target.matches('[data-content="list-item-content"]');
    if (titleEdit || contentEdit) {
        ListItemController(event.target, event, 'listItemEdit');
    }
});