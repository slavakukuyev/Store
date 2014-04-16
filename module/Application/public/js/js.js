$(function() {
    
    
    var selected=$('#Address').find('[name="cityid"]').val();  
    if (selected == '') {
        selected=1;
        $('#Address').find('[name="cityid"]').val(1);
    }
     
    $('[name="cities"] option[value="' + selected + '"]').prop('selected', true);
    $('[name="cities"]').on('change', function() {
 
        $('#Address').find('[name="cityid"]').val(this.value);
        
    });    
    
    
    
    var selected=$('#product_form').find('[name="categoryid"]').val();
    
     
    $('[name="categories"] option[value="' + selected + '"]').prop('selected', true);
    $('[name="categories"]').on('change', function() {
 
        $('#product_form').find('[name="categoryid"]').val(this.value);
        
    });    
    
    
    
    
    
    $('#order').find('[name="counts"]').on('change', function(){        
        var count=parseInt(this.value);
        var price=parseInt($('.price').html());
        var total=count*price;        
        
        $('#order').find('[name="count"]').val(count);
        $('#order').find('[name="price"]').val(total);
        $('.total').html(total);
        
        var balance=parseInt($('.balance').html());
        if (total > balance) {
            $('form#order').find('input#submitorder').addClass("hidden").prop('disabled', true);
            $('a[name="deposit_order"]').removeClass("hidden");
        }
        else{
            $('form#order').find('input#submitorder').removeClass("hidden").prop('disabled', false);
            $('a[name="deposit_order"]').addClass("hidden");
        }
        
    });
  
          
    
});