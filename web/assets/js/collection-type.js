// setup an "add a item" link

jQuery(document).ready(function() {
    var $addItemLink = $('<a href="#" class="add_item_link btn btn-primary">Add a item</a>');
    var $newLinkLi = $('<div></div>').append($addItemLink);
    
    // Get the ul that holds the collection of items
    var $collectionHolder = $('.collection-type');

    // add the "add a item" anchor and li to the items ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addItemLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new item form (see code block below)
        addItemForm($collectionHolder, $newLinkLi);
    });


});

function addItemForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    // Replace '$$name$$' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a item" link li
    var $newFormLi = $('<div></div>').append(newForm);

    // also add a remove button, just for this example
    $newFormLi.append('<a href="#" class="remove-item  btn btn-danger">Remove</a>');

    $newLinkLi.before($newFormLi);

    // handle the removal, just for this example
    $('.remove-item').click(function(e) {
        e.preventDefault();

        $(this).parent().remove();

        return false;
    });
}