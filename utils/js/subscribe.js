
function subscribe()
{
    var param = "login="
            + $("input#input_subscribe_login").val()
            + "&pseudonyme="
            + $("input#input_subscribe_pseudonyme").val()
            + "&password="
            + $("input#input_subscribe_password").val()
            + "&password_confirmed="
            + $("input#input_subscribe_passwordConfirmed").val();
    $.ajax({
        type: 'POST',
        url: '/ajax/subscribe',
        data: param,
        success:
            function(result) 
            {
                alert(result);
            }
    });
}

$(document).ready(function() {
    
    $("#button_subscribe").live('click', function(event) {
        if($("#content_subscribe").css("display") === "block")
        {
            $("#button_subscribe").removeClass("buttonselected");
            $("#content_subscribe").css({"display":"none"});
        }
        else
        {
            event.stopPropagation();
            $("#button_subscribe").addClass("buttonselected");
            $("#content_subscribe").css({"display":"block"});
            $("#button_connexion").removeClass("buttonselected");
            $("#content_connexion").css({"display":"none"});
        }
    });
    
    $("html").live('click', function(e) {
        
        hasParent = false;
        for(var node = e.target; node !== document.body; node = node.parentNode)
        {
          if(node.id === 'content_subscribe'){
            hasParent = true; 
            break;
          }
        }
        
        if(!hasParent)
        {
            $("#button_subscribe").removeClass("buttonselected");
            $("#content_subscribe").css({"display":"none"});
        }
    });
    
    $("#content_subscribe button").live('click', function() {
       subscribe(); 
    });
    
});

