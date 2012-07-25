var refresher;
var updater;

$(document).keypress(function(e) {
if(e.which == 13) {
	if($("#messageme").val() == null || $("#messageme").val() == "")
	{
	}
	else
	{
		sendMessage();
	}
}
});

function login()
{
	var asdf = "";
	var form_data = {
		username: $("#username").val(),
		password: $("#password").val(),
		is_ajax: 1
	};
	
	$.ajax({ type: "POST", url: "ac.php", data: form_data, success: function(data){
        asdf = data;
		if(asdf == "1")
		{
			$.mobile.changePage('#page4');
		}
		else
		{
			alert("login failure");
		}
      }});
}

function annLive()
{
	$('#page5').css({'background-color': 'blue'});
}

function assLogin()
{
	var form_data = {
		username: $("#username").val(),
		password: $("#password").val(),
		is_ajax: 1
	};
	
	$.ajax({ type: "POST", url: "gethtml.php", data: form_data, success: function(data){
        	//asdf = data;
        	$('#assignments').html(data);
        	}});
}

function getChats()
{
	var form_data = {
		username: $("#username").val(),
		password: $("#password").val(),
		is_ajax: 1
	};
	
	$.ajax({ type: "POST", url: "getchat.php", data: form_data, success: function(data){
        	//asdf = data;
        	$('#chat').html(data);
        	$('.chatcourse').click(function() {
        		getChatMessages($(this).attr('id'));
        		});
        	}
        });
}

function getChatMessages(id)
{
	var form_data = {
		username: $("#username").val(),
		password: $("#password").val(),
		courseid: id
	};
	$.ajax({ type: "POST", url: "getchatmessages.php", data: form_data, success: function(data){
			$.mobile.changePage('#page9');
			$('#chatinfo').html(data);
        	}
        }).done(function() { 
	  	//$('#chatinfo').scrollTop($('#chatinfo').height() }, 3000);
	  	
	});
}

function sendMessage()
{
	//alert($("#thekoi").text() + " " + $("#messageme").val() );
	var form_data = {
		username: $("#username").val(),
		password: $("#password").val(),
		chatChannelId: $("#thekoi").text(),
		body: $("#messageme").val()
	};
	$.ajax({ type: "POST", url: "submitchat.php", data: form_data, success: function(data){
			asdf = data;
			if(asdf == "-1")
			{
				alert("Message not sent");
			}
			else
			{
				//alert("message sent" + data);
				$("#messageme").val().replace(/\n/g, "").replace(/ /g, "");
				$("#messageme").val("");
			}
        	}
        });
}

function updateChats()
{
	$('#chatinfo').scrollTop($('#chatinfo').prop('scrollHeight'));
}

function refreshChats()
{
	var form_data = {
		username: $("#username").val(),
		password: $("#password").val(),
		url: $("#refresherl").text(),
		linecount: $("#linecount").text()
	};
	$.ajax({ type: "POST", url: "refreshchat.php", data: form_data, success: function(data){
			//alert( $("#refresherl").text() + "\n" + data);
			/*if(data == -1)
			{
			}
			else
			{*/
				$('#chatinfo').html(data);
			/*}*/
		}
	});
}

function cleanup()
{
	clearInterval(updater);
	clearInterval(refresher);
}

function getCourses()
{
	var form_data = {
		username: $("#username").val(),
		password: $("#password").val(),
		is_ajax: 1
	};
	
	$.ajax({ type: "POST", url: "getcourses.php", data: form_data, success: function(data){
        	$('#resources').html(data);
        	$('.resourcecourse').click( function() {
        		getResource($(this).attr('id'));
        		});
        	}
        });
}

function getFolder(id)
{
	var form_data = {
		username: $("#username").val(),
		password: $("#password").val(),
		courseid: id
	};
	$.ajax({ type: "POST", url: "getfolder.php", data: form_data, success: function(data){
        	$.mobile.changePage('#page2');
        	$('#metainfo').html(data);
        	}
        });
}

function getResource(id)
{
	var form_data = {
		username: $("#username").val(),
		password: $("#password").val(),
		courseid: id
	};
	$.ajax({ type: "POST", url: "getresource.php", data: form_data, success: function(data){
        	$.mobile.changePage('#page2');
        	$('#metainfo').html(data);
        	}
        });
}

function folderSelected(id)
{
	var form_data = {
		username: $("#username").val(),
		password: $("#password").val(),
		folderid: id
	};
	$.ajax({ type: "POST", url: "getfolder.php", data: form_data, success: function(data){
        	$('#metainfo').html(data);
        	}
        });
}

function resourceSelected(id)
{
	//$("#secretIFrame").attr("src","getoneitem.php?username="+$("#username").val()+"&password="+$("#password").val()+"&item="+id);
	var form_data = {
		username: $("#username").val(),
		password: $("#password").val(),
		item: id
	};
	
	$.ajax({ type: "POST", url: "getoneitem.php", data: form_data, success: function(data){
        	$.mobile.changePage('#page3');
        	$("#superlinks").html(data);
        	}});
}

function getAssignment(url)
{
	var form_data = {
		username: $("#username").val(),
		password: $("#password").val(),
		link: url
	};
	
	$.ajax({ type: "POST", url: "getAssignment.php", data: form_data, success: function(data){
        	$.mobile.changePage('#page2');
        	$("#metainfo").html(data);
        	}});
}

function getData()
{
	var form_data = {
		username: $("#username").val(),
		password: $("#password").val(),
		type: 1
	};
	$.ajax({ type: "POST", url: "infoget.php", data: form_data, success: function(data){
        asdf = data;
		$("#announcements").html(data);
		$(".desc").click(function(){
			$(this).css({'background-color':'#FF9980'});
			callAnnounceid($(this).attr("id"));
		});

      }});
	
}

function callAnnounceid(id)
{
	var form_data = {
		username: $("#username").val(),
		password: $("#password").val(),
		type: 2,
		annid : id
	};
	$.ajax({ type: "POST", url: "infoget.php", data: form_data, success: function(data){
        asdf = data;
		$("#metainfo").html(data);
		$.mobile.changePage('#page2');
      }});
}
