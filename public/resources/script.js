// global sorting variables

console.log("tested");
let sortColumn = 'id';
let sortDirection = 'ASC';
// generic sorting handler
$(document).on('click', '.sortColumn', function () {

    let column = $(this).data('column');

    // toggle direction
    if (sortColumn === column) {

        sortDirection =
            sortDirection === 'ASC'
                ? 'DESC'
                : 'ASC';

    } else {

        sortColumn = column;
        sortDirection = 'ASC';

    }

    // callback function
    let callbackFunction = $(this).data('callback');

    // check function exists
    if (
        callbackFunction &&
        typeof window[callbackFunction] === 'function'
    ) {

        window[callbackFunction](
            1,
            sortColumn,
            sortDirection
        );

    }

});