$(function(){
	// Pubnub Account Key
	var pubnub = new PubNub({
        subscribeKey: "sub-c-81be4306-6d1b-11e7-85aa-0619f8945a4f",
        publishKey: "pub-c-64bf1fdd-748e-4447-be40-96c80fe5cc71",
        ssl: true
    });

	// Check here new message came from other users
    pubnub.addListener({
        message: function(message){
            if(json.channel == 'chat_room1') {
            	var msg= '<h4>'+json.message+'</h4><br/>';
            	$('#chat_messages_1').append(msg);
            }
        }
    });

    // Here fetch chat history from created all channels
    function GetallChannels() {
    	var enquiry_id = 0;
    	var transaction_id = 0;
    	var user_id = 0;
    	$.ajax({
			type : "POST",
			url  : "includes/b2bfunctions.php?calc=getchannels",
			data : {'enquiry_id':enquiry_id, 'transaction_id':transaction_id, 'user_id':user_id},
			dataType : 'json',
			beforeSend : function(){
			},
			success : function(result){
				if(result) {
					$.each(result, function(i,v){
						var channel_name = v.channel_name;
						pubnub.history(
					    	{
					            channel : 'chat_room1',
					            count : 100
					        },
					        function(status, response){
					        	$.each(response.messages,function(e,v){
					        		var msg= '<h4>'+v.entry+'</h4>';
					            	$('#chat_messages_1').append(msg);
					        	});
					        }
					    );
					});
				}
			}
		});
    }
    GetallChannels();    

    // Store or Publish message to pubnub channel
    $(document).on('click', '.send-message', function(e){
    	var channel_name = '';
    	var message = '';
    	pubnub.publish(
            {
                message: message,
                channel: channel_name
            },
            function(status, response){
	            if (status.error) {
	                console.log(status)
	            } 
	            else {
	            	var timetoken = response.timetoken;
	                console.log("message Published w/ timetoken", response.timetoken)
	            }
            }    
        );
    });

	// Initiate Chat or Create Channel
	$(document).on('click', '.initiate-chat', function(e){
		e.preventDefault();
		var transaction_id = 0;
		var enquiry_id = 0;
		var user_id = 0;
		$.ajax({
			type : "POST",
			url  : "includes/b2bfunctions.php?calc=createchannel",
			data : {'enquiry_id':enquiry_id, 'transaction_id':transaction_id, 'user_id':user_id},
			dataType : 'json',
			beforeSend : function(){
			},
			success : function(result){
				if(result) {
					var channel_id = result.channel_id;
					var channel_code = result.channel_code;
					var channel_name = result.channel_name;
					// Create Channel
					pubnub.subscribe({ 
				        channels: [channel_name] 
				    });
				}
			}
		});
	});

	// Add Participant / User To Channel
	$(document).on('click', '.adduser-channel', function(e) {
		var channel_id = 0;
		var creater_id = 0;
		var participant_id = 0;
		var participant_name = 0;
		$.ajax({
			type : "POST",
			url  : "includes/b2bfunctions.php?calc=addchanneluser",
			data : {'channel_id':channel_id, 'creater_id':creater_id, 'participant_id':participant_id, 'participant_name':participant_name},
			dataType : 'json',
			beforeSend : function(){
			},
			success : function(result){
			}
		});
	});

	// Remove Participant / User To Channel
	$(document).on('click', '.removeuser-channel', function(e) {
		var channel_id = 0;
		var participant_id = 0;
		$.ajax({
			type : "POST",
			url  : "includes/b2bfunctions.php?calc=removechanneluser",
			data : {'channel_id':channel_id, 'participant_id':participant_id},
			dataType : 'json',
			beforeSend : function(){
			},
			success : function(result){
			}
		});
	});
});