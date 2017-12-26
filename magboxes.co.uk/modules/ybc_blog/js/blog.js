$(document).ready(function(){
    $('#ybc-blog-capcha-refesh').click(function(){
        originalCapcha = $('#ybc-blog-capcha-img').attr('src');
        originalCode = $('#ybc-blog-capcha-img').attr('rel');
        newCode = Math.random();
        $('#ybc-blog-capcha-img').attr('src', originalCapcha.replace(originalCode,newCode));
        $('#ybc-blog-capcha-img').attr('rel', newCode);
    });
    $('.blog_rating_star').click(function(){
        var rating = parseInt($(this).attr('rel'));
        $('.blog_rating_star').removeClass('star_on');
        $('#blog_rating').val(rating);
        for(i = 1; i<= rating; i++)
        {
            $('.blog_rating_star_'+i).addClass('star_on');
        }
    });
    $('.ybc-block-comment-report').click(function(){
        if(!confirm(ybc_blog_report_warning))
            return false;
        btnObj = $(this);
        btnObj.addClass('active');
        $.ajax({
            url : ybc_blog_report_url,
            data : {
                id_comment : btnObj.attr('rel')
            },
            dataType: 'json',
            type : 'post',
            success: function(json){
                if(json['success'])
                   btnObj.remove();
                else
                {
                    alert(json['error']);
                }
                btnObj.removeClass('active'); 
            },
            error: function(){
                alert(ybc_blog_error);
                btnObj.removeClass('active'); 
            }                       
        });
    });
    
    $('.ybc-blog-like-span').click(function(){        
        btnObj = $(this);        
        if(!btnObj.hasClass('active'))
        {
            $('.ybc-blog-like-span-'+btnObj.attr('data-id-post')).addClass('active');
            $.ajax({
                url : ybc_blog_like_url,
                data : {
                    id_post : btnObj.attr('data-id-post')
                },
                dataType: 'json',
                type : 'post',
                success: function(json){
                    if(json['success'])
                    {    
                        $('.ben_'+btnObj.attr('data-id-post')).text(json['likes']);   
                    }                       
                    else
                    {
                        $('.ybc-blog-like-span-'+btnObj.attr('data-id-post')).removeClass('active');
                        alert(json['error']);
                    }                   
                },
                error: function(){                    
                    $('.ybc-blog-like-span-'+btnObj.attr('data-id-post')).removeClass('active'); 
                    alert(ybc_like_error);             
                }                       
            });   
        }        
    });    
    
    if ($('.sidebar-post-type-casual .ybc_popular_posts').length > 0)
    	$(".sidebar-post-type-casual .ybc_popular_posts").owlCarousel({            
            items : 1,
            itemsCustom : [[0, 1], [480,1], [600,1], [768,1], [992,1], [1199,1]],           
            // Navigation
            navigation : true,  
            rewindNav : false,
            //Pagination
            pagination : false,       
            dots : false,   
        });
     if ($('#ybc_gallery_home_content').length > 0)
    	$("#ybc_gallery_home_content").owlCarousel({            
            items : 3,
            itemsCustom : [[0, 1], [320, 1], [480,2],[768,3], [992,3], [1199,3]],         
            // Navigation
            navigation : true,  
            rewindNav : false,
            //Pagination
            pagination : false,      
            dots : false,    
        });
     if ($('.ybc_related_products_type_casual').length > 0)
    	$(".ybc_related_products_type_casual").owlCarousel({            
            items : 1,
            itemsCustom : [[0, 1], [320, 1], [480,2], [600,3], [680,3], [768,2], [992,3], [1199,4]],               
            // Navigation
            navigation : true,  
            rewindNav : false,
            //Pagination
            pagination : false,   
            dots : false,       
        });
     if ($('.ybc_blog_related_posts_type_casual .ybc-blog-related-posts-list').length > 0)
    	$(".ybc_blog_related_posts_type_casual .ybc-blog-related-posts-list").owlCarousel({            
            items : 1,
            itemsCustom : [[0, 1], [320, 1], [480,2], [530,2], [600,3], [680,3], [768,2], [992,3], [1199,3]],               
            // Navigation
            navigation : true,  
            rewindNav : false,
            //Pagination
            dots : false,
            pagination : false,          
        });
});