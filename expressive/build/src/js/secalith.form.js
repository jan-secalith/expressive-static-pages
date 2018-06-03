

function reindexFieldsetLegend(jqButtonElement) {
    const fieldsetType = jqButtonElement.attr('data-target-type');
    const collectionSelector = '.form-collection-' + fieldsetType;
    const fieldsetSelector = '.form-fieldset-' + fieldsetType;
    if( jQuery(collectionSelector).length === 0 ) {
        // the collection is not present in the document
        return false;
    }
    // find the Collection
    const collection = ( jQuery(collectionSelector).length > 1 )
        ? jqButtonElement.parents().eq(0).children(collectionSelector).eq(0)
        : jQuery(collectionSelector).eq(0);
    const fieldsets = collection.find(fieldsetSelector);
    if( fieldsets.length === 0 ) {
        return false;
    }
    // Count the existing fieldsets
    const fieldsetCount = parseInt(fieldsets.length);
    if( fieldsetCount === 0 ) {
        return false;
    }

    // extract new fieldset template from the Collection
    const dataTemplate = collection.children('span[data-template]').eq(0).data('template');
    // create the Legend element for the new fieldset
    const fieldsetInitialLegendText = jQuery(dataTemplate).children('legend').text();

    for (var i = 0; i < fieldsetCount; i++) {
        var newFieldsetLegendCountEl = '<span class="' + fieldsetType + '-count">#' + parseInt(i+1) + '</span>';
        var newFieldsetLegendEl = jQuery('<legend>')
            .html('<span>' + fieldsetInitialLegendText + '</span> ' + newFieldsetLegendCountEl);
        // remove the existing <legend> from the fieldset
        fieldsets.eq(i).children('legend').eq(0)
            .html(jQuery(newFieldsetLegendEl).html())
        ;
    }


}

function removeFieldsetFromButton(jqButtonElement) {

    const fieldsetType = jqButtonElement.attr('data-target-type');
    const fieldsetSelector = '.form-fieldset-' + fieldsetType;
    const parentFieldset = jqButtonElement.parents(fieldsetSelector).eq(0);

    // remove the parent wrapper
    parentFieldset.remove();

    return false;
}
function addFieldsetFromButton(jqButtonElement, direction) {

    direction = ( undefined !== typeof direction && direction === 'prepend') ? 'prepend' : 'append';

    const fieldsetType = jqButtonElement.attr('data-target-type');

    const collectionSelector = '.form-collection-' + fieldsetType;
    const fieldsetSelector = '.form-fieldset-' + fieldsetType;
    if( jQuery(collectionSelector).length === 0 ) {
        // the collection is not present in the document
        return false;
    }

    // find the Collection
    const collection = ( jQuery(collectionSelector).length > 1 )
        ? jqButtonElement.parents().eq(0).children(collectionSelector).eq(0)
        : jQuery(collectionSelector).eq(0);

    // extract new fieldset template from the Collection
    const dataTemplate = collection.children('span[data-template]').eq(0).data('template');

    // determine the Placeholder used in the data-template as index
    const templatePlaceholder = collection.attr('data-template-index-placeholder');

    if( templatePlaceholder.length === 0 ) {
        // the collection placeholder not present
        return false;
    }

    // Count the existing fieldsets
    const fieldsetCount = parseInt(collection.find(fieldsetSelector).length);

    // Generate new Template with replaced indexes
    var fieldset = jQuery(dataTemplate.replace(new RegExp(templatePlaceholder, "g"), fieldsetCount));

    if( direction === 'prepend' ) {
        collection.prepend(fieldset);
    } else {
        collection.append(fieldset);
    }


    return;
};


function removeCollectionFieldset(jqItemElement){
    removeFieldsetFromButton(jqItemElement);
    reindexFieldsetLegend(jqItemElement);
};

function addCollectionFieldset(jqItemElement,direction){
    addFieldsetFromButton(jqItemElement,direction);
    reindexFieldsetLegend(jqItemElement);
};