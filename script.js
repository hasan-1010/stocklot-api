<script>
    
jQuery(window).on( 'grid:items:added', function(){ 

    jQuery('.reset-button').click(function(){
        jQuery('.filter-category select').val('Select Category');

        jQuery('.empty-message').hide();
        jQuery('.vc_grid-item').show();
    });

    jQuery('.filter-button').click(function(){
        let filter_value = jQuery('.filter-category select').val();
        if(filter_value == 'Select Category') {
            jQuery('.empty-message').hide();
            jQuery('.vc_grid-item').show();
            return;
        }

        let grid_category = '';
        let grid_counter = 0;
        let hide_grid = 0;
        jQuery('.vc_grid-item').each(function(){
            $this = jQuery(this);
            grid_category = $this.find('.wanted-category').text();
            if(grid_category == filter_value){
                $this.show();
            }
            else{
                $this.hide();
                hide_grid++;
            }
            grid_counter++;
        });
        if(hide_grid == grid_counter){
            jQuery('.empty-message').hide();
            jQuery('.wanted-custom-grid').before('<p class="empty-message" style="text-align: center; font-weight: bold">Sorry, No wanted post with this filter.</p>');
        }
        else{
            jQuery('.empty-message').hide();
        }
    });
});
</script>