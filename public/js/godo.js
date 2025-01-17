/**
 * Godo To-Do List Web Application
 * Edward Gough
 * 17/01/2025
 */

console.log('Godo To-Do List Web Application - Initialized');

/**
 * Sends task data to Laravel controllers using Axios.
 * @param {string} action - Action type ('add', 'remove', etc.).
 * @param {object} data - Payload to send to the server.
 */
const RequestHandler = (action = '', data = {}) => {
    const urls = {
        listItemCreate: '/create/list-item',
        listItemDelete: '/delete/list-item',
        listItemEdit: '/edit/list-item',
        listItemStatus: '/status/list-item',
        listCreate: '/create/list',
        listDelete: '/delete/list',
        listEdit: '/edit/list',
    };

    const url = urls[action];
    if (!url) {
        console.error('Invalid action:', action);
        return;
    }

    axios.post(url, data, {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
    })
    .then(response => ResponseHandler(response))
    .catch(error => console.error('Error:', error.response));
};

/**
 * Handles server responses and updates the DOM accordingly.
 * @param {object} response - Server response.
 */
const ResponseHandler = (response = {}) => {
    response.data.reaction.forEach(({ type, tag, value }) => {
        const element = document.querySelector(tag);

        switch (type) {
            case 'insertAdjacentHTML':
                element?.insertAdjacentHTML('beforeend', value);
                break;
            case 'remove':
                element?.remove();
                break;
            case 'console':
                console.log(value);
                break;
            case 'replaceElement':
                if (element) element.outerHTML = value;
                break;
        }
    });
};

/**
 * Handles actions for individual list items.
 * @param {HTMLElement} element - Triggering element.
 * @param {Event} event - Event object.
 * @param {string} action - Action type (e.g., 'listItemDelete').
 */
const ListItemController = (element, event, action) => {
    const listId = element.closest('[data-list-id]')?.dataset.listId;
    const listItemElement = event.target.closest('[data-list-item-id]');
    const listItemId = listItemElement?.dataset.listItemId;

    const data = { listId, listItemId };

    if (action === 'listItemEdit') {
        data.title = listItemElement?.querySelector('[data-content="list-item-title"]')?.textContent.trim();
        data.content = listItemElement?.querySelector('[data-content="list-item-content"]')?.textContent.trim();
    } else if (action === 'listItemStatus') {
        data.status = element?.dataset.status;
    }

    RequestHandler(action, data);
};

/**
 * Handles actions for entire lists.
 * @param {HTMLElement} element - Triggering element.
 * @param {Event} event - Event object.
 * @param {string} action - Action type (e.g., 'listDelete').
 */
const ListController = (element, event, action) => {
    const listId = element.closest('[data-list-id]')?.dataset.listId;
    const data = { listId };

    if (action === 'listEdit') {
        data.title = element?.textContent.trim();
    }

    RequestHandler(action, data);
};

// Unified event listener for click actions
document.body.addEventListener('click', event => {
    const handlers = [
        { selector: '.delete-list-item-button', action: 'listItemDelete', controller: ListItemController },
        { selector: '.create-list-item-button', action: 'listItemCreate', controller: ListItemController },
        { selector: '[data-content="complete-item"]', action: 'listItemStatus', controller: ListItemController },
        { selector: '.create', action: 'listCreate', controller: ListController },
        { selector: '.remove', action: 'listDelete', controller: ListController },
    ];

    handlers.forEach(({ selector, action, controller }) => {
        const element = event.target.closest(selector);
        if (element) controller(element, event, action);
    });
});

// Unified event listener for focusout actions
document.body.addEventListener('focusout', event => {
    const handlers = [
        { selector: '[data-content="list-item-title"]', action: 'listItemEdit', controller: ListItemController },
        { selector: '[data-content="list-item-content"]', action: 'listItemEdit', controller: ListItemController },
        { selector: '[data-content="list-title"]', action: 'listEdit', controller: ListController },
    ];

    handlers.forEach(({ selector, action, controller }) => {
        const element = event.target.matches(selector) ? event.target : null;
        if (element) controller(element, event, action);
    });
});
