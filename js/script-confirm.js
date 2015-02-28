$(document).ready(function(){
	
	$('.item .delete').click(function(event){
		event.preventDefault();
		var elem = $(this).closest('.item');
		var target = $(this).attr('href');
		var location = window.location;
		
		$.confirm({
			'title'		: 'Delete Confirmation',
			'message'	: 'You are about to delete this item. <br />It cannot be restored at a later time! Continue?',
			'buttons'	: {
				'Yes'	: {
					'class'	: 'bLue',
					'action': function(){
						
						$.ajax({
			              type: "POST",
			              url: target,
			              success: function(response){
			                if(response == 'success'){
			                  elem.slideUp();
			               }	
			              }
			            });
			            return false;
					}
				},
				'No'	: {
					'class'	: 'gray',
					'action': function(){}	
				}
			}
		});
		
	});
	
	$('#primary .item span.quit , #primary .item li a.logout').bind('click' ,function(event){
		event.preventDefault();
		var target = $('.logout').attr('href');
		var location = window.location;
		
		$.confirm({
			'title'		: 'Logout Confirmation',
			'message'	: 'You are about to logout. <br />Continue?',
			'buttons'	: {
				'Yes'	: {
					'class'	: 'bLue',
					'action': function(){
						location.href=target;
					}
				},
				'No'	: {
					'class'	: 'gray',
					'action': function(){}
				}
			}
		});
		
	});


	$('a.retake').bind('click' ,function(event){
		event.preventDefault();
		var elem = $(this).closest('a.retake');
		var target = $(this).attr('href');
		var location = window.location;
		
		$.confirm({
			'title'		: 'Retake Confirmation',
			'message'	: 'You are about to retake a quiz. <br />Continue?',
			'buttons'	: {
				'Yes'	: {
					'class'	: 'bLue',
					'action': function(){
						location.href=target;
					}
				},
				'No'	: {
					'class'	: 'gray',
					'action': function(){}
				}
			}
		});
		
	});


});