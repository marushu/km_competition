/**
 * KM Competition script - v0.1.0
 *
 * Copyright 2016, Hibou (http://private.hibou-web.com)
 * Released under the GNU General Public License v2 or later
 */


(function($) {

    $( '.add_child_post' ).on( 'click', function( e ) {

        //console.log( e );

        var parent_item = $( this ).closest( '.post_slug_container' );
        //console.log( parent_item );

        clone_item = $( parent_item ).clone( true ).insertAfter( parent_item );
        console.log( clone_item );
        $( clone_item ).addClass( 'clone_added' );
        $( clone_item ).find( 'input' ).val( '' );

        var all_items = $( '.post_slug_container' );
        //console.log( all_items.length );

    } );

    $( '.remove_child_post' ).on( 'click', function( e ) {

        var parent_item = $( this ).closest( '.post_slug_container' );
        //$( parent_item ).remove();
        var all_items = $( '.post_slug_container' );
        //console.log( all_items.length );

        if ( all_items.length >= 2 ) {

            $( parent_item ).remove();

        }

    } );

    $( '#wpbody form' ).submit( function(  ) {

        console.log( 'submitしたよ？' );

        $( '.post_slug_container input' ).each( function() {

            console.log( $( this ).val() );
            if ( $.trim( $( this ).val() ) === '' ) {

                var target = $( this ).closest( '.post_slug_container' );
                $( target ).remove();

            }

        } );

        //return false;

    } );

})(jQuery);